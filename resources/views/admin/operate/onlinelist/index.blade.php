@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <form action="" method="get">
                    <legend><b style="font-size: 18px">在线列表 </b> <b>大厅人数:{{ $hall_num ?? 0}}</b> <b>房间人数: {{ $game_num ?? 0 }}</b></legend>
                    <hr class="layui-bg-gray">
                    <div class="layui-input-inline">
                        <select id="table_type" name="table_type" lay-verify="required">
                            <option value="-1">所有</option>
                            @foreach($table_type as $key => $value)
                                <option value="{{$key}}" @if(isset($where['table_type']) && $where['table_type'] == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="layui-card-body">

            <table class="layui-table">
                <colgroup>
                    <col width="150">
                    <col width="150">
                    <col width="200">
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th> 玩家id</th>
                    <th> 昵称</th>
                    <th> 所在位置</th>
                    <th> 携带金币额度</th>
                    <th> 渠道来源</th>
                    <th> 注册时间</th>
                    <th> 注册IP</th>
                    <th> 最后登陆IP</th>
                    <th> 机器码</th>
                </tr>
                </thead>
                <tbody>

                @if($data)

                    @foreach ($data as $k=>$v)
                        <tr>
                            <td><a href="#" onclick="info({{ $v['uid']??'' }})"><span class="layui-badge layui-bg-blue">{{ $v['uid']??'' }}</span></a></td>
                            <td>{{ $v['name']??'' }}</td>
                            <td>{{ $v['table_type']??'' }}</td>
                            <td>{{$v['coins']??'' }}</td>
                            <td>{{ $v['channel']??'' }} </td>
                            <td>{{ $v['created_time']??'' }} </td>
                            <td>{{ $v['ip']??'' }} </td>
                            <td>{{ $v['last_ip']??'' }} </td>
                            <td>{{ $v['device_id']??'' }} </td>
                        </tr>
                    @endforeach

                @else

                    <tr>
                        <td colspan="1000">暂无数据！！！</td>
                    </tr>

                @endif

                </tbody>
            </table>

        </div>
    </div>
@endsection
@section('script')
    @can('operate.onlinelist')
        <script>
            function info(id) {
                layer.open({
                    type: 2,
                    title: false,
                    area: ['1000px', '800px'],
                    shade: 0.8,
                    shadeClose: true,
                    content: 'goldrecord?uid='+id
                });
            }
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var table = layui.table;
                var form = layui.form;
                //搜索
                $("#searchBtn").click(function () {

                });


            })
        </script>
    @endcan
@endsection