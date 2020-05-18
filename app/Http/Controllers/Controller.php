<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function setParamRouterToRequest(Request $request, $paramName){
        $request[$paramName] = Route::current()->parameter($paramName) ?? $request->get($paramName);
    }

    protected function getParamRouterOrRequest(Request $request, $paramName){
        return Route::current()->parameter($paramName) ?? $request->get($paramName);
    }
}
