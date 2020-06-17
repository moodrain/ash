<?php

namespace App\Http\Controllers;

class PostController extends Controller
{

    protected $model = 'post';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with('user');
        return $this->view('list', ['l' => $builder->paginate()]);
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
            'id' => 'required|exists:' . $this->table(),
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
            'id' => 'required_without:ids|exists:' . $this->table(),
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:' . $this->table() . ',id',
        ];
        $this->vld($rules);
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}
