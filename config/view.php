<?php

return [

    'admin' => [
        'nav' => [
            ['dashboard', '面板', 'admin'],
            ['subject', '主题', [
                ['subject-list', '主题列表', 'admin/subject/list'],
                ['subject-edit', '主题编辑', 'admin/subject/edit'],
            ]],
            ['comment', '回复', [
                ['comment-list', '回复列表', 'admin/comment/list'],
                ['comment-edit', '回复编辑', 'admin/comment/edit'],
            ]],
            ['subject-category', '分类', [
                ['subject-category-list', '分类列表', 'admin/subject-category/list'],
                ['subject-category-edit', '分类编辑', 'admin/subject-category/edit'],
            ]],
            ['explorer', '文件管理', 'admin/explorer'],
        ],
    ],

    'user' => [
        'nav' => [
            'pc' => [
                ['home', '首页', ''],
                ['subject', '主题', 'subject'],
                ['subject-edit', '主题编辑', 'subject/edit'],
            ],
            'mobile' => [
                ['home', '首页', ''],
                ['subject', '主题', 'subject'],
                ['subject-edit', '主题编辑', 'subject/edit'],
            ],
        ],
    ],

    'nav' => [
        'auth' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
