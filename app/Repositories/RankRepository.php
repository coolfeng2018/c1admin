<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/9/19 11:13
 * +------------------------------
 */

namespace App\Repositories;

use App\Models\DataRankBoard;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * 系统配置
 * Class BrocastRepository
 * @package App\Repositories
 */
class RankRepository extends BaseRepository
{

    /**
     * 获取服务端排行榜数据
     * @param $uri
     * @param $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getServerRankData($uri, $params)
    {

        Log::info(__METHOD__ . ' Http client request: ' . $uri . '-' . json_encode($params));

        $client = new Client();
        $data = $client->request('POST', $uri,
            [
                'json' => ($params),
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ])->getBody()->getContents();

        Log::info(__METHOD__ . ' Http client response: ' . $data);

        $data = json_decode($data, true);

        if (is_array($data) && $data['code'] == 0 && !empty($data['result']['rank_list'])) {

            //处理充值金额
            $rank_list = self::getDayRechargeMoney($data['result']['rank_list']);

            return ['code' => 1, 'msg' => 'SUCCESS', 'data' => [
                'data' => $rank_list,
                'total' => count($data['result']['rank_list'])
            ]];
        }
        return ['code' => 0, 'msg' => '获取服务端数据失败......', 'data' => ''];
    }

    /**
     * 取得当日充值汇总
     * @param array $data
     * @return array
     */
    public static function getDayRechargeMoney($data = [])
    {
        $connection = DB::connection(config('constants.MYSQL_PAYMENT'));

        foreach ($data as $k => $v) {
            $amount = $connection->table('order')
                ->where(['uid' => $v['uid'], 'status' => 2])
                ->whereBetween('create_time', [strtotime(date('Y-m-d')), (strtotime(date('Y-m-d')) + 86400)])
                ->sum('amount');
            $data[$k]['amount'] = $amount > 0 ? $amount / 100 : $amount;
        }
        return $data;
    }


    /**
     * 落地服务端数据到Mysql TODO：已经转移到API项目
     * @param $params
     * @return array
     */
    public static function setServerRankData($params)
    {
        if (!isset($params['result']['type']) || !in_array($params['result']['type'], [1, 2, 3])) {
            return ['code' => 0, 'msg' => '排行榜类型缺失'];
        }
        if (!isset($params['result']['rank_list']) || count($params['result']['rank_list']) < 1) {
            return ['code' => 0, 'msg' => '数据列表缺失'];
        }

        $type = $params['result']['type'];

        //TODO:先清除同一天的数据，再重新写入, 开发中 。。。
//        DataRankBoard::query()->where(['type' => $type])->whereBetween('create_time', [strtotime(date('Y-m-d')), (strtotime(date('Y-m-d')) + 86400)])->delete();

        $insert_data = [];
        foreach ($params['result']['rank_list'] as $k => $v) {

            $insert_data[$k]['type'] = $type;
            $insert_data[$k]['uid'] = $v['uid'];
            $insert_data[$k]['nick_name'] = $v['name'];
            $insert_data[$k]['rank_level'] = $v['rank'];

            switch ($type) {
                case 1 :
                    $insert_data[$k]['today_income'] = $v['value'];
                    break;
                case 2 :
                    $insert_data[$k]['charge_money'] = $v['value'];
                    break;
                case 3 :
                    $insert_data[$k]['online_time'] = $v['value'];
                    break;
            }

            $insert_data[$k]['created_at'] = isset($params['time']) ? $params['time'] : time();
            $insert_data[$k]['updated_at'] = time();
        }

        $result = DataRankBoard::query()->insert($insert_data);
        return $result ? ['code' => 1, 'msg' => 'success'] : ['code' => 0, 'msg' => 'error'];
    }

}