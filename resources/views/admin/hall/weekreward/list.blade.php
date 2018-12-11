@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" placeholder="ID" class="layui-input">
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
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.weekrewardlist.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'nickname', title: '用户昵称', sort: true, align: 'center'}
                        ,{field: 'uid', title: '用户ID', align: 'center'}
                        ,{field: 'can_exchange_award', title: '待兑换金额', align: 'center'}
                        ,{field: 'last_award', title: '昨日收益', align: 'center'}
                        ,{field: 'total_award', title: '累计收益', align: 'center'}
                        ,{field: 'day_count', title: '状态', align: 'center'}
                    ]]
                });

                //搜索
                $("#search").click(function () {
                    var uid = $('#uid').val();
                    dataTable.reload({
                        where:{uid:uid}
                    })
                });

            });
        </script>
    @endcan
@endsection
