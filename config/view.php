<?php

return [

    'admin' => [
        'nav' => [
            ['dashboard', 'Dashboard', 'admin'],
            ['subject', 'Subject', [
                ['subject-list', 'Subject List', 'admin/subject/list'],
                ['subject-edit', 'Subject Edit', 'admin/subject/edit'],
            ]],
            ['comment', 'Comment', [
                ['comment-list', 'Comment List', 'admin/comment/list'],
                ['comment-edit', 'Comment Edit', 'admin/comment/edit'],
            ]],
            ['subject-category', 'Subject Category', [
                ['subject-category-list', 'Subject Category List', 'admin/subject-category/list'],
                ['subject-category-edit', 'Subject Category Edit', 'admin/subject-category/edit'],
            ]],
            ['explorer', 'Explorer', 'admin/explorer'],
        ],
    ],

    'user' => [
        'nav' => [
            'pc' => [
                ['home', 'Home', ''],
                ['subject', 'Subject', 'subject'],
                ['subject-edit', 'Subject Edit', 'subject/edit'],
            ],
            'mobile' => [
                ['home', 'Home', ''],
                ['subject', 'Subject', 'subject'],
                ['subject-edit', 'Subject Edit', 'subject/edit'],
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
