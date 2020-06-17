<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{

    protected function model()
    {
        return 'post';
    }

    protected function builder()
    {
        return Post::query();
    }

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with('user');
        return $this->view('list', ['list' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('post')) {
            return request('id') ? $this->update() : $this->store();
        }
        return $this->view('edit', [
            'd' => request('id') ? $this->builder()->find(request('id')) : null,
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'abstract' => '',
        ];
        $this->vld($rules);
        $item = $this->builder()->newModelInstance(request()->only(array_keys($rules)));
        $item->userId = uid();
        $item->save();
        return $this->viewOk('edit');
    }

    public function update()
    {
        $rules = [
            'id' => 'required|exists:posts',
            'name' => 'required',
            'abstract' => '',
        ];
        $this->vld($rules);
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($rules)));
        $item->save();
        return $this->viewOk('edit', ['d' => $item]);
    }

    public function destroy()
    {
        $rules = [
            'id' => 'required_without:ids|exists:posts',
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:posts,id',
        ];
        $this->vld($rules);
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }




}
