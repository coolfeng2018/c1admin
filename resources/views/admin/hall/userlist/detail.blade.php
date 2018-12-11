@extends('admin.base')
@section('content')
    <style>

        .body{width: 1100px;height: 490px;
        }
        .head-img{width: 180px; float: left;text-align: center;margin-top: 20px;
        }
        img{width: 100px; height: 100px; margin-top: 20px; margin-left: 10px;
        }
        .content{height: 80%; margin-top: 20px; float: left;
        }
        .row-r{width: 850px; height: 172px;
        }
        .head{
            border-bottom:1px solid #ddd; width: 100%; line-height: 30px; font-size: 18px;margin-top: 10px;
            background-color: #D8D8D8;
        }
        .content .info{
            width: 100%;
        }
        .content .info .one{
            width: 150px;font-size: 15px; line-height: 28px; text-align: right; float: left; margin-right: 20px;
        }
        .content .info .two{
            font-size: 15px; line-height: 28px; text-align: left; float: left;margin-right: 40px;
        }
        .userInfo{
            text-align: center;line-height: 40px;
        }
        .val{width:  180px; height: 28px;
        }
        .banck{
            width: 1030px;
            height: 100px;
        }
        .banck .banckTitle{
            width: 100%;
            height: 30px;
            font-size: 18px;
            line-height: 30px;
            background-color: #D8D8D8;
            border-bottom:1px solid #ddd;
        }
        .banck .banckInfo{
            width: 100%;
            height: 50px;
            font-size: 15px;
        }
        .banck .banckInfo .name{
            width: 70px;
            line-height: 50px;
            text-align: right;
            line-height: 50px;
            float: left;
        }
        .banck .banckInfo .info1{
            margin-left: 5px;
            width: 240px;
            line-height: 50px;
            text-align: left;
            float: left;
        }

    </style>
    <div class="body">
        <div class="head-img">
            <img src="{{$list['head_img'] or ''}}">
            <div class="userInfo">{{$list['nickname'] or ''}}</div>
            <div class="userInfo">状态：{{$status?'已经封号':'正常'}}</div>
        </div>
        <div class="content">
            <div class="row-r">
                <div class="head"><b>基本信息</b></div>
                <div class="info">
                    <div class="one">
                        <div>uid/昵称:</div>
                        <div>注册时间:</div>
                        <div>最后登陆时间:</div>
                        <div>手机号:</div>
                        <div>渠道:</div>
                    </div>
                    <div class="two">
                        <div class="val">{{$list['uid'] or ''}}/{{$list['nickname'] or ''}}</div>
                        <div class="val">{{$list['regist_time'] or ''}}</div>
                        <div class="val">{{$list['last_login_time'] or ''}}</div>
                        <div class="val">{{$list['phone'] or 'a'}}</div>
                        <div class="val">{{$list['channel'] or 'aa'}}</div>
                    </div>

                    <div class="one">
                        <div>性别:</div>
                        <div>注册IP:</div>
                        <div>最后登陆IP:</div>
                        <div>设备号:</div>
                        <div>客户端版本号:</div>
                    </div>
                    <div class="two">
                        <div class="val">{{$list['sex'] or ''}}</div>
                        <div class="val">{{$list['regist_ip'] or ''}}</div>
                        <div class="val">{{$list['login_ip'] or ''}}</div>
                        <div class="val">{{$list['device_id'] or ''}}</div>
                        <div class="val">{{$list['client_version'] or ''}}</div>
                    </div>
                </div>

            </div>

            <div class="row-r">
                <div class="head"><b>累计信息</b></div>
                <div class="info">
                    <div class="one">
                        <div>初次购买时间:</div>
                        <div>金币数量:</div>
                        <div>累计充值:</div>
                        <div>累计赢金币:</div>
                    </div>
                    <div class="two">
                        <div class="val">{{$list['first_buy_time'] or ''}}</div>
                        <div  class="val">{{$list['coins'] or ''}}</div>
                        <div class="val">{{$list['deposit_sum'] or ''}}</div>
                        <div class="val">{{$list['win_sum'] or ''}}</div>

                    </div>

                    <div class="one">
                        <div>购买金额:</div>
                        <div>累计兑换:</div>
                        <div>累计扣台费:</div>
                        <div>累计押注:</div>
                    </div>
                    <div class="two">
                        <div class="val">{{$list['buycount'] or ''}}</div>
                        <div class="val">{{$list['exch_sum'] or ''}}</div>
                        <div class="val">{{$list['cost_sum'] or ''}}</div>
                        <div class="val">{{$list['lose_sum'] or ''}}</div>
                    </div>
                </div>
            </div>

            @if(isset($list['payData']['account']))
            <div class="row-r">
                <div class="head"><b>支付宝信息</b></div>
                <div class="info">
                    <div class="one">
                        <div>支付宝实名:</div>

                    </div>
                    <div class="two">
                        <div class="val">{{$list['payData']['name'] or ''}}</div>

                    </div>

                    <div class="one">
                        <div>支付宝账号:</div>

                    </div>
                    <div class="two">
                        <div class="val">{{$list['payData']['account'] or ''}}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @if(isset($list['bank']['account']))
    <div class="banck">
        <div class="banckTitle"><b>兑现银行卡信息</b></div>
        <div class="banckInfo">
            <div class="name">开户名: </div>
            <div class="info1">{{$list['bank']['name'] or ''}}</div>

            <div class="name">银行卡号:</div>
            <div class="info1">{{$list['bank']['account'] or ''}}</div>

            <div class="name">开户行: </div>
            <div class="info1">{{$list['bank']['addres'] or ''}}</div>
        </div>
    </div>
    @endif
    @if(isset($data[0]))
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th> UID </th>
            <th> 封号状态 </th>
            <th> 原因 </th>
            <th> 结束时间 </th>
            <th> 最后修改的操作人 </th>
            <th> 操作时间 </th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $val)
        <tr>
            <td>{{$val['uid'] or ''}}</td>
            <td>{{$val['status'] or ''}}</td>
            <td>{{$val['reason'] or ''}}</td>
            <td>{{$val['etime'] or ''}}</td>
            <td>{{$val['op_name'] or ''}}</td>
            <td>{{$val['otime'] or ''}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif

@endsection


