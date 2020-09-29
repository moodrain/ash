<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    protected $admin = true;
    protected $model = 'comment';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with('subject', 'from');
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('post')) {
            $isUpdate = request()->filled('id');
            $this->rules = [
                'userId' => 'required|exists:users,id',
                'fromUserId' => 'required|exists:users,id',
                'subjectId' => 'required|exists:subjects,id',
                'commentId' => 'exists:comments,id',
                'orderId' => 'required',
                'content' => 'required',
                'images' => 'array'
            ];
            $isUpdate && $this->rules['id'] = 'exists:' . $this->table();
            $this->vld();
            return $isUpdate ? $this->update() : $this->store();
        }
        return $this->view('edit', [
            'd' => request('id') ? $this->builder()->find(request('id')) : null,
        ]);
    }

    private function store()
    {
        $item = $this->builder()->newModelInstance(request()->only(array_keys($this->rules)));
        $item->userId = uid();
        $item->save();
        return $this->viewOk('edit');
    }

    private function update()
    {
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($this->rules)));
        $item->save();
        return $this->viewOk('edit', ['d' => $item]);
    }

    public function destroy()
    {
        $this->vld([
            'id' => 'required_without:ids|exists:' . $this->table(),
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:' . $this->table() . ',id',
        ]);
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}
