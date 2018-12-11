<?php

namespace App\Console;

use App\Console\Commands\MakeUserTableFee;
use App\Console\Commands\MakeUserTableOac;
use App\Console\Commands\PublishConfig;
use App\Console\Commands\RankUpdateRechargeMoney;
use App\Console\Commands\MakePermissionMenu;
use App\Console\Commands\UnionOrderUpdateStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

        UnionOrderUpdateStatus::class,//更新过期未处理的银联订单状态

        MakeUserTableFee::class,//台费

        MakeUserTableOac::class,//产出与消耗

        RankUpdateRechargeMoney::class,//每日充值总金额

        PublishConfig::class, //批量发送配置至服务器

        MakePermissionMenu::class, //批量添加后台菜单选项

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
