<?php

namespace App\Http\Middleware;

use Closure;
use \Spatie\Permission\Middlewares\PermissionMiddleware as Permission;

class PermissionMiddleware extends Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        return parent::handle($request,$next,$permission);
    }
}
