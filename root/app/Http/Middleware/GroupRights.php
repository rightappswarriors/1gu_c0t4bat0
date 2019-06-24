<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Route;

class GroupRights {

    public function handle($request, Closure $next)
    {
        $n_route = $request->route();
        dd(['master-file/inventory/brand_name', Route::getFacadeRoot()->current()->uri()]);
        return $next($request);
    }

}