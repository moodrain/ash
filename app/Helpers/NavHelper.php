<?php

namespace App\Helpers;

class NavHelper
{
    public function resourceAdminNav($model, $prefix = 'admin')
    {
        $prefix && $prefix = endWith('/', $prefix);
        return [$model, $model, [
            ["$model-list", "$model list", "$prefix$model/list"],
            ["$model-edit", "$model edit", "$prefix$model/edit"],
        ]];
    }

    public function resourceAdminNavs($models, $prefix = 'admin')
    {
        return array_map(function($model) use ($prefix) {
            return $this->resourceAdminNav($model, $prefix);
        }, $models);
    }
}