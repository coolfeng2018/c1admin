<?php
function p($arr){
    echo '<pre>';
    print_r($arr);
    echo '<pre>';
}
/**
 * 往二维数组头追加数组,
 * @param $body
 * @param $header
 * @return array
 */
function array_unshif_data($body,$header){
    $newBody = [];
    $newBody[] = $header;
    foreach ($body as $key => $value){
        $newBody[$key+1] = $value;
    }
    return $newBody;
}

/**
 * 转换成人民币(分=>元)
 * @param $money 钱（单位分）
 * @return float|int
 */
function toRmb($money){
    if(empty($money)){
        return 0 ;
    }
    $to = round($money/100,2);
    return $to;
}

/**
 * 转换成人民币(元=>分)
 * @param $money 钱（单位元）
 * @return int
 */
function toMinute($money){
    if(empty($money)){
        return 0 ;
    }
    $to = intval($money*100);
    return $to;
}



?>