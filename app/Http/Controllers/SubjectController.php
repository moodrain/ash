<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Subject;

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
        Comment::query()->orderByDesc('');
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            return view();
        }
    }

}