<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $request =  app('request');
        $proto = $request->server->get('HTTP_X_FORWARDED_PROTO');
        if($proto && strtolower($proto) == 'https'){
            $request->server->set('HTTPS', 'on');
        }

        //TODO:开发模式下 - DEBUG SQL
        if (config('app.debug') == true) {
            DB::listen(function ($query) {
                if (PHP_SAPI == 'cli') {
                    echo $query->sql . PHP_EOL;
                    echo json_encode($query->bindings, JSON_UNESCAPED_UNICODE) . PHP_EOL;
                } else {
                    Log::info(__METHOD__ . ' - SQL ：' . $query->sql);
                    Log::info(__METHOD__ . ' - SQL Params ：' . json_encode($query->bindings, JSON_UNESCAPED_UNICODE));
                }
            });
        }

        Schema::defaultStringLength(191);
        //左侧菜单
        view()->composer('admin.layout',function($view){
            $menus = \App\Models\Permission::with([
                'childs'=>function($query){$query->with('icon');}
                ,'icon'])->where('parent_id',0)->orderBy('sort','desc')->get();
            $unreadMessage = \App\Models\Message::where('read',1)->where('accept_uuid',auth()->user()->uuid)->count();
            $view->with('menus',$menus);
            $view->with('unreadMessage',$unreadMessage);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
