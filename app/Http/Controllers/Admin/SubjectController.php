<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;

class SubjectController extends Controller
{
    protected $model = 'subject';

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
                'title' => 'required',
                'user_id' => 'required|exists:users,id',
                'category_id' => 'required|exists:subject_categories,id',
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
        Comment::query()->wherein('subject_id', $ids)->delete();
        return $this->backOk();
    }

}
