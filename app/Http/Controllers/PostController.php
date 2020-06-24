<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;

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
            $isUpdate = request()->filled('id');
            $this->rules = [
                'abstract' => '',
            ];
            $this->rules['name'] = $isUpdate
                ? ['required', Rule::unique($this->table())->ignore(request('id'))]
                : 'required|unique:' . $this->table();
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
        $this->rules = [
            'id' => 'required_without:ids|exists:' . $this->table(),
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:' . $this->table() . ',id',
        ];
        $this->vld();
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}
