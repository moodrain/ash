<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteHelper
{
    public function resourceAdminRoute($model, $namespace = 'Admin')
    {
        $class = ucfirst(Str::camel($model));
        $controller = endWith('\\', '\\App\\Http\\Controllers\\' . $namespace) . $class . 'Controller';
        Route::get("$model/list", [$controller, 'list']);
        Route::match(['get', 'post'], "$model/edit", [$controller, 'edit']);
        Route::post("$model/delete", [$controller, 'destroy']);
    }

    public function resourceAdminRoutes($models, $namespace = 'Admin')
    {
        foreach ($models as $model) {
            $this->resourceAdminRoute($model, $namespace);
        }
    }
}