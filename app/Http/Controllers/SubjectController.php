<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Psr7\mimetype_from_filename;

class SubjectController extends Controller
{
    public function list()
    {
        $size = 20;
        $builder = function() {
            $builder = Subject::query();
            request('search') && $builder->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                    ->orWhereHas('user', function($q) {
                        $q->where('name', request('search'));
                    });
            });
            request('categoryId') && $builder->where('category_id', request('categoryId'));
            return $builder;
        };
        $subjects = $builder()->skip(request('page') * $size - $size)->take($size)->get();
        $total = $builder()->count();
        return view('subject.list', compact('subjects', 'total'));
    }

    public function show(Subject $subject)
    {
        $size = 20;
        $builder = function() use ($subject) {
            return Comment::query()->where('subject_id', $subject->id)->orderBy('order_id')->orderBy('id');
        };
        $comments = $builder()->skip($size * request('page') - $size)->take($size)->get();
        $total = $builder()->count();
        $subject->makeHidden('content');
        $comments->makeHidden('content');
        return view('subject.item', compact('subject', 'comments', 'total'));
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            return view('subject.edit', ['d' => request('id') ? Subject::query()->findOrFail(request('id')) : null]);
        }
        $this->rules = [
            'title' => 'required',
            'categoryId' => 'required|exists:subject_categories,id',
            'content' => 'required',
            'images' => 'nullable|array'
        ];
        $isUpdate = request()->filled('id');
        $isUpdate && $this->rules['id'] = 'exists:subjects';
        $this->vld($this->rules);
        return $isUpdate ? $this->update() : $this->store();
    }

    public function store()
    {
        $subject = new Subject(request()->only(array_keys($this->rules)));
        $subject->userId = uid();
        $subject->save();
        return $this->directOk('/subject/' . $subject->id);
    }

    public function update()
    {
        $subject = Subject::query()->find(request('id'));
        $this->own($subject);
        $subject->fill(request()->only(array_keys($this->rules)));
        $subject->save();
        return $this->viewOk('subject.edit', ['d' => $subject]);
    }

    public function upload($file = null)
    {
        if (request()->isMethod('get')) {
            return response(file_get_contents(storage_path('app/upload/subject/' . basename($file))))->header('Content-Type', mimetype_from_filename($file));
        }
        $this->vld(['file' => 'file']);
        $file = request()->file('file');
        $mbMax = 10;
        if ($file->getSize() > $mbMax * 1024 * 1024) {
            return ers('max file size is ' . $mbMax . ' M');
        }
        $tmp = $file->getRealPath();
        $ext = $file->getClientOriginalExtension();
        $name = md5_file($tmp);
        $path = storage_path('app/upload/subject/' . $name . '.' . $ext);
        try {
            rename($tmp, $path);
            return rs('/subject/upload/' . $name . '.' . $ext);
        } catch (\Throwable $e) {
            return ers($e->getMessage());
        }
    }

    public function comment()
    {
        $this->vld([
            'subjectId' => 'required|exists:subjects,id',
            'commentId' => 'exists:comments,id',
            'content' => 'required',
            'images' => 'array',
        ]);
        try {
            DB::beginTransaction();
            $subject = Subject::query()->find(request('subjectId'));
            $commentReply = request('commentId') ? Comment::query()->find(request('commentId')) : null;
            $comment = new Comment(request()->only('content', 'images', 'subjectId', 'commentId'));
            $comment->fromUserId = uid();
            $comment->userId = $commentReply ? $commentReply->fromUserId : $subject->userId;
            $comment->orderId = $commentReply ? $commentReply->orderId : 0;
            $comment->save();
            ! $commentReply && $comment->update(['orderId' => $comment->id]);
            $size = 20;
            $count = Comment::query()
                ->where('subject_id', request('subjectId'))
                ->where('order_id', '<=', $comment->orderId)
                ->where('id', '<=', $comment->id)
                ->count();
            $page = ceil($count / $size);
            DB::commit();
            $query = ['page' => $page];
            ! $commentReply && $query['bottom'] = 1;
            return $this->directOk('/subject/' . request('subjectId') . '?' . http_build_query($query));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->backErr($e->getMessage());
        }
    }

}