#!/bin/bash
umask 002
#切换到当前目录
cd $(cd "$(dirname "$0")";pwd)
readonly path=$(pwd)/;
readonly minute=$((10#$(date +%M)))
readonly hour=$(date +%k)
readonly day=$((10#$(date +%d)))
readonly month=$(date +%m)
readonly weekday=$(date +%w)
readonly Ymd=$(date +%Y%m%d)
readonly yesterday=$(date +"%Y-%m-%d" -d "-1day")

echo "${Ymd},${hour}:${minute}" >> ${path}crontab.sh.log
#每1分钟执行的任务
    source /etc/profile; php /data/html/c1Admin/artisan command:update_union_order

#每3分钟执行的任务
#if [ "0" -eq "$(($minute % 3))" ] ; then
#    ${path}/check_bills_run.sh
#    echo "check_bills_run" >> ${path}crontab.sh.log
#fi

#每5分钟执行的任务
#if [ "0" -eq "$(($minute % 5))" ] ; then
#fi

#每1小时执行的任务_脚本运行检查
#if [ "0" -eq $minute ] ; then
#fi

#每2小时分钟执行的任务
#if [ "0" -eq "$(($hour % 2))" ] && [ "0" -eq $minute ]  ; then
#fi

#每4小时分钟执行的任务
#if [ "0" -eq "$(($hour % 4))" ] && [ "0" -eq $minute ] ; then
#fi

#每天凌晨1点执行的任务_生成数据
if [ "1" -eq $hour ] && [ "0" -eq $minute ] ; then
    source /etc/profile; php /data/html/c1Admin/artisan command:make_user_table_fee --date="${yesterday}"
    source /etc/profile; php /data/html/c1Admin/artisan command:make_user_table_oac --date="${yesterday}"
    source /etc/profile; php /data/html/c1Admin/artisan rank:update_recharge_money --date="${yesterday}"
fi

#每天凌晨1点30分执行的任务_创建表
if [ "1" -eq $hour ] && [ "30" -eq $minute ] ; then
    source /etc/profile; php /data/html/c1Admin/artisan rank:update_recharge_money --date="${yesterday}"
fi

#每天凌晨2点执行的任务_创建表
#if [ "2" -eq $hour ] && [ "0" -eq $minute ] ; then
#    /usr/local/php/bin/php ${path}/index.php dc dbcreate createTable money
#fi

#每天凌晨3点执行的任务
#if [ "3" -eq $hour ] && [ "0" -eq $minute ] ; then
#fi

#每天凌晨3点半执行的任务_数据生成任务
#if [ "3" -eq $hour ] && [ "30" -eq $minute ] ; then
#fi

#每天凌晨4点执行的任务_清除message表中的过期消息
#if [ "4" -eq $hour ] && [ "0" -eq $minute ] ; then
#fi

#if [ "4" -eq $hour ] && [ "30" -eq $minute ] ; then
#fi

#每天凌晨5点执行的任务
#if [ "5" -eq $hour ] && [ "0" -eq $minute ] ; then
#fi

#if [ "5" -eq $hour ] && [ "30" -eq $minute ] ; then
#fi

#每天凌晨点6:30执行的任务
#if [ "6" -eq $hour ] && [ "30" -eq $minute ] ; then
#fi

#每月一号 凌晨2点 执行的任务_创建表
#if [ "1" -eq $day ] && [ "2" -eq $hour ] && [ "0" -eq $minute ] ; then
#fi

