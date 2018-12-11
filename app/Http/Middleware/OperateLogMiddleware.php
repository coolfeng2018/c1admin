<?php

namespace App\Http\Middleware;

use App\Models\OperationLog;
use Closure;
use Illuminate\Support\Facades\Auth;

class OperateLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        if(!empty($input)){

            $user_id = 0;
            $username = isset($input['username']) ? $input['username'] : '' ;

            if(Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id;
                $username = $user->username;
            }else{
                if (isset($input['password'])) unset($input['password']) ;
            }
            $data = [
                'user_id'=>$user_id,
                'user_name'=>$username,
                'method'=>$request->method(),
                'path'=>$request->path(),
                'ip'=>$request->ip(),
                'params'=>$input,
            ];
            OperationLog::create($data);
        }
        return $next($request);
    }
}
