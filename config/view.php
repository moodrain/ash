<?php

return [

    'admin' => [
        'nav' => [
            ['dashboard', 'dash', 'admin'],
            ['subject', 'subject', [
                ['subject-list', 'subject list', 'admin/subject/list'],
                ['subject-edit', 'subject edit', 'admin/subject/edit'],
            ]],
            ['comment', 'comment', [
                ['comment-list', 'comment list', 'admin/comment/list'],
                ['comment-edit', 'comment edit', 'admin/comment/edit'],
            ]],
            ['subject-category', 'subject-category', [
                ['subject-category-list', 'subject-category list', 'admin/subject-category/list'],
                ['subject-category-edit', 'subject-category edit', 'admin/subject-category/edit'],
            ]],
            ['explorer', 'explorer', 'admin/explorer'],
        ],
    ],

    'user' => [
        'nav' => [
            'pc' => [
                ['home', 'home', ''],
                ['subject', 'subject', 'subject'],
                ['subject-edit', 'subject edit', 'subject/edit'],
            ],
            'mobile' => [
                ['home', 'home', ''],
                ['subject', 'subject', 'subject'],
                ['subject-edit', 'subject edit', 'subject/edit'],
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
