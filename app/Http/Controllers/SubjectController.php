<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Subject;
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
            'images' => 'array'
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
        abort_if($subject->userId != uid(), 403);
        $subject->fill(request()->only(array_keys($this->rules)));
        $subject->save();
        return $this->viewOk('subject.edit', ['d' => $subject]);
    }

    public function upload($file = null)
    {
        if (request()->isMethod('get')) {
            return response(file_get_contents(storage_path('app/upload/subject/' . $file)))->header('Content-Type', mimetype_from_filename($file));
        }
        $this->vld(['file' => 'file']);
        $file = request()->file('file');
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

    private $rules;

}