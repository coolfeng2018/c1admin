@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    用户ID
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" placeholder="ID" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    日期
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="stime" id="stime" value="{{$date or $list['stime']}}" placeholder="开始日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    -
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="etime" id="etime" value="{{$date or $list['etime']}}" placeholder="结束日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="search" data-href="">查找</button>
                </div>

            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
        </div>


    </div>
@endsection

@section('script')
    @can('operate.order')
        <script>
            layui.use(['layer','table','laydate'],function () {
                var table = layui.table;
                var laydate = layui.laydate;
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.weekrewardexchange.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'nickname', title: '用户昵称', sort: true, align: 'center'}
                        ,{field: 'uid', title: '用户ID', align: 'center'}
                        ,{field: 'coins', title: '兑换金额', align: 'center'}
                        ,{field: 'update_time', title: '兑换时间', align: 'center'}
                    ]]
                });

                //开始日期
                laydate.render({
                    elem: '#stime'
                    , format: 'yyyy-MM-dd'
                });
                //结束日期
                laydate.render({
                    elem: '#etime'
                    , format: 'yyyy-MM-dd'
                });

                //搜索
                $("#search").click(function () {
                    var uid = $('#uid').val();
                    var stime = $("#stime").val();
                    var etime = $("#etime").val();
                    dataTable.reload({
                        where:{uid:uid,stime:stime,etime:etime}
                    })
                });

            });
        </script>
    @endcan
@endsection
