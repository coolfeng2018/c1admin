<?php

namespace App\Console\Commands;

use App\Repositories\DataUnionOrderRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Log;

class UnionOrderUpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_union_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新过期未处理的银联订单状态';

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
        echo "start...";
        $info = DataUnionOrderRepository::cliUpdateOrderStatus();
        if($info){
            Log::info(__METHOD__ . ' - '.$this->signature.' ：' . json_encode($info, JSON_UNESCAPED_UNICODE));
        }
        die('SUCCESS' . PHP_EOL);
    }
}
