@extends('admin.base')

@section('content')

    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-btn-group">

                <a href="{{route('admin.rank.history', ['type'=>1])}}"
                   class="layui-btn @if($type == 1) layui-btn-danger @endif ">历史赚金排行</a>
                <a href="{{route('admin.rank.history', ['type'=>2])}}"
                   class="layui-btn @if($type == 2) layui-btn-danger @endif">历史兑换排行</a>
                <a href="{{route('admin.rank.history', ['type'=>3])}}"
                   class="layui-btn @if($type == 3) layui-btn-danger @endif">历史在线排行</a>
            </div>

            <div class="layui-form">

                <input type="hidden" name="type" value="{{$type or 1}}">

                <div class="layui-input-inline">
                    <input type="number" min="0" name="uid" id="uid" value="{{$uid or ''}}" placeholder="请输入玩家ID"
                           class="layui-input">
                </div>

                <div class="layui-input-inline">
                    <input type="text" name="date" id="date" value="{{$date or ''}}" placeholder="请选择日期"
                           class="layui-input" readonly>
                </div>

                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn" data-href="">查找</button>
                </div>
            </div>

        </div>
        <div class="layui-card-body">


            <table class="layui-table">
                <colgroup>
                    <col width="150">
                    <col width="200">
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th>序号</th>
                    <th>玩家昵称</th>
                    <th>玩家ID</th>

                    @switch($type)
                        @case(1)
                        <th>赚金</th>
                        @break
                        @case(2)
                        <th>兑换</th>
                        @break
                        @case(3)
                        <th>在线</th>
                        @break
                    @endswitch
                    <th>排名</th>
                    <th>充值</th>
                </tr>
                </thead>
                <tbody>

                @foreach($result as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->nick_name}}</td>
                        <td>{{$v->uid}}</td>
                        @switch($type)
                            @case(1)
                            <td>{{$v->today_income}}</td>
                            @break
                            @case(2)
                            <td>{{$v->charge_money}}</td>
                            @break
                            @case(3)
                            <td>{{$v->online_time}}</td>
                            @break
                        @endswitch
                        <td>{{$v->rank_level}}</td>
                        <td>{{$v->recharge_money}}</td>

                    </tr>
                @endforeach

                </tbody>
            </table>

            <div>
                {{ $result->appends(['type' => $type, 'uid'=>$uid, 'date'=>$date])->links() }}
                <span>共 {{$result->total()}} 条</span>
            </div>


        </div>
    </div>
@endsection

@section('script')
    @can('rank.history')
        <script>
            layui.use(['laydate'], function () {

                laydate = layui.laydate;

                //日期
                laydate.render({
                    elem: '#date'
                    , format: 'yyyy-MM-dd'
                });

                //搜索
                $("#searchBtn").click(function () {
                    var uid = $("#uid").val();
                    var date = $("#date").val();
                    window.location.href = '{{route('admin.rank.history', ['type'=>$type])}}' + '&uid=' + uid + '&date=' + date;
                });

            });

            // $(function () {
            //     $('#searchBtn').on('click', function () {
            //         alert(1) ;
            //     }) ;
            // });

        </script>
    @endcan
@endsection