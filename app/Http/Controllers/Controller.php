<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $admin = false;
    protected $prefix = null;
    protected $viewPrefix = null;
    protected $model = null;
    protected $rules = [];

    public function __construct()
    {
        $this->admin && $this->prefix === null && $this->prefix = 'admin';
        $this->admin && $this->viewPrefix === null && $this->viewPrefix = 'admin';
        singleUser() && Auth::loginUsingId(singleUser()->id);
        $this->initSearch();
        $this->initSort();
    }

    private function initSearch()
    {
        $search = (array) request('search');
        foreach ($search as $key => $value) {
            if ($value === null || $value === '') {
                unset($search[$key]);
            }
        }
        $this->search = $search;
    }

    private function initSort()
    {
        $sort = (array) request('sort');
        foreach ($sort as $key => $value) {
            if ($value === null || $value === '') {
                unset($sort[$key]);
            }
        }
        $this->sort = $sort;
    }

    protected function mSearch($builder): Builder
    {
        return $builder->search($this->search)->sort();
    }

    protected function vld($rules = null)
    {
        return $this->validate(request(), $rules ?? $this->rules);
    }

    protected function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return call_user_func([$this->modelClass(), 'query']);
    }

    protected function model()
    {
        return $this->model;
    }

    protected function modelClass()
    {
        $class = '';
        $pieces = explode('_', $this->model());
        foreach ($pieces as $piece) {
            $class .= ('\\' . ucfirst($piece));
        }
        return 'App\\Models' . $class;
    }

    protected function modelName()
    {
        $device = mobile() ? 'mobile' : 'pc';
        $key = 'view.';
        $key .= ($this->admin ? 'admin' : 'user');
        $key .= '.nav';
        $key .= ($this->admin ? '' : ".$device");
        $navs = config($key);
        $name = $m = $this->model();
        foreach ($navs as $nav) {
            if ($nav[0] == $m) {
                $name = $nav[1];
            }
        }
        return $name;
    }

    protected function table()
    {
        $class = $this->modelClass();
        return (new $class)->getTable();
    }

    protected function view($view, $para = [])
    {
        $model = Str::snake(Str::camel($this->model()), '-');
        $modelClass = $this->modelClass();
        $modelName = $this->modelName();
        $initPara = [
            'm' => $model,
            'modelClass' => $modelClass,
            'modelName' => $modelName,
            'prefix' => $this->prefix,
        ];
        empty($para['d']) && $initPara['d'] = null;
        empty($para['l']) && $initPara['l'] = [];
        return view(($this->viewPrefix ? endWith('.', $this->viewPrefix) : '') . ($model ? $model . '.' : '') . $view, array_merge($initPara, $para));
    }

    protected function viewOk($view, $para = [])
    {
        return $this->view($view, array_merge($para, ['msg' => __('msg.success')]));
    }

    protected function directOk($uri)
    {
        return redirect(endWith('/', $this->viewPrefix) . $uri)->with('msg', __('msg.success'));
    }

    protected function backOk()
    {
        return redirect()->back()->withInput()->with('msg', __('msg.success'));
    }

    protected function backErr($errMsg)
    {
        return redirect()->back()->withInput()->withErrors(__($errMsg));
    }

    protected function api($rules, callable $handle)
    {
        try {
            $validator = Validator::make(request()->all(), $rules);
            expIf($validator->fails(),$validator->errors()->first());
            return $handle();
        } catch (\Exception $e) {
            return ers($e->getMessage());
        }
    }

    protected function own($model, $ownerKey = null)
    {
        $this->authorize('own', [$model, $ownerKey]);
    }

    protected function isOwn()
    {
        return user()->can('own', [$model, $ownerKey]);
    }
}
