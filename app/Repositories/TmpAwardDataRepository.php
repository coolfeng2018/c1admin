<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: renkui
 * +------------------------------
 * DateTime: 2018/9/20 19:52
 * +------------------------------
 */

namespace App\Repositories;
use App\Models\TmpAwardAddFreeCountModel;
use App\Models\TmpAwardBindPlayerModel;
use App\Models\TmpAwardLuckyDrawModel;
use Illuminate\Support\Facades\DB;


class TmpAwardDataRepository extends BaseRepository
{
    public static function award_main() {

        $start = strtotime(date('Ymd') . '000000');
        $end = strtotime(date('Ymd') . '235959');
        //免费次数
        $ret_1 = TmpAwardAddFreeCountModel::query()
            ->select(DB::Raw('SUM(add_count) AS add_count,add_type'))
            ->whereIn('add_type',[1,2,3])
            ->where('time','>', $start)
            ->where('time','<=', $end)
            ->groupBy('add_type')
            ->get()->toArray();
        $count_tg = $count_vip = $count_bd = 0;
        if (!empty($ret_1)) {
            $count_tg = empty($ret_1[0]['add_count']) ? 0 : $ret_1[0]['add_count'];
            $count_vip = empty($ret_1[1]['add_count']) ? 0 : $ret_1[1]['add_count'];
            $count_bd = empty($ret_1[2]['add_count']) ? 0 : $ret_1[2]['add_count'];
        }
        //绑定玩家
        $ret_2 = TmpAwardBindPlayerModel::query()
            ->where('bind_uid',88888)
            ->where('time','>', $start)
            ->where('time','<=', $end)
            ->count();
        $binding_count_gm = empty($ret_2) ? 0 : $ret_2;

        $ret_2_1 = TmpAwardBindPlayerModel::query()
            ->where('bind_uid','!=',88888)
            ->where('time','>', $start)
            ->where('time','<=', $end)
            ->count();
        $binding_count = empty($ret_2_1) ? 0 : $ret_2_1;
        //抽奖
        $ret_3_1 = TmpAwardLuckyDrawModel::query()
            ->select(DB::Raw('count(id) as count,count(distinct uid) as uid_count'))
            ->where('time','>', $start)->where('time','<=', $end)
            ->get()->toArray();
        $add_count = empty($ret_3_1) ? 0 : $ret_3_1[0]['count'];
        $add_num = empty($ret_3_1) ? 0 : $ret_3_1[0]['uid_count'];

        $ret_3_2 = TmpAwardLuckyDrawModel::query()
            ->where('pay_coins', '>', 0)
            ->where('time','>', $start)->where('time','<=', $end)
            ->count();
        $pay_count = empty($ret_3_2) ? 0 : $ret_3_2;

        $ret_3_3 = TmpAwardLuckyDrawModel::query()
            ->select(DB::Raw('count(id) as count,cp_valid'))
            ->where('cpcode','!=','')
            ->where('time','>', $start)->where('time','<=', $end)
            ->groupBy('cp_valid')->get()->toArray();
        $cp_count_true = $cp_count_false = 0 ;
        if (!empty($ret_3_3)) {
            foreach ($ret_3_3 as $v) {
                if ($v['cp_valid']) {
                    $cp_count_true = $v['count'];
                }
                else {
                    $cp_count_false = $v['count'];
                }
            }
        }
        return [ 0 => [
            'add_count' => $add_count,
            'add_num' => $add_num,
            'pay_count' => $pay_count,
            'free_count' => $add_count > 0 ? ($add_count - $pay_count) : 0,
            'count_bd' => $count_bd,
            'count_vip' => $count_vip,
            'count_tg' => $count_tg,
            'binding_count' => $binding_count,
            'binding_count_gm' => $binding_count_gm,
            'cp_count_true' => $cp_count_true,
            'cp_count_false' => $cp_count_false,
            'date' => date('Y-m-d', $start)
            ]
        ];
    }
}