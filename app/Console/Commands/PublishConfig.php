<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:publish_config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量发送配置至服务器';

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
        $plist = config('publish_config');
        if(empty($plist)){
            $str = ' no publish_config todo'.PHP_EOL;
            Log::info(__METHOD__.$str);
            echo $str;
            return false ;
        }

        foreach ($plist as $item=>$func) {
            $action = app($item);
            $func = empty($func) ? 'send': $func;
            $funcs = [$func];
            if(strpos($func,',') !== false){
                $funcs = explode(',',$func);
            }
            try{
                foreach ($funcs as $tmpFunc) {
                    $result = $action->$tmpFunc();
                    $ret = \GuzzleHttp\json_decode($result->getContent());
                    if($ret && $ret->code == 0 ){
                        $str = $item.' send result:'.$ret->msg. PHP_EOL;
                    }else{
                        $str = $item.' send result:('.$ret->code.')msg:'.$ret->msg.PHP_EOL;
                    }
                    Log::info(__METHOD__.$str);
                    echo $str;
                }

            }catch (\Exception $e){
                Log::info(__METHOD__.'ErrorException:'.$e->getMessage());

                echo $e->getMessage(). PHP_EOL;
            }
        }
        die('SUCCESS'. PHP_EOL);
    }
}
