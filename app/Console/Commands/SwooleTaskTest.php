<?php

namespace App\Console\Commands;

use App\Tasks\TestTask;
use Illuminate\Console\Command;
use Hhxsv5\LaravelS\Swoole\Task\Task;

class SwooleTaskTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:swoole_task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 实例化TestTask并通过deliver投递，此操作是异步的，投递后立即返回，由Task进程继续处理TestTask中的handle逻辑

        $task = new TestTask('task data');
// $task->delay(3);// 延迟3秒投放任务
        $ret = Task::deliver($task);
        var_dump($ret);//判断是否投递成功
    }
}
