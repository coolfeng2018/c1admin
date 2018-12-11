@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" placeholder="请输入管理ID 或者 名称 " class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
        </div>
    </div>
@endsection
@section('script')
    @can('system.opreatelog')
        <script>
            layui.use(['layer','table'],function () {
                var layer = layui.layer;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.opreatelog.data') }}" //数据接口
                    ,cellMinWidth: 30
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'id', title: 'ID', align: 'center'}
                        ,{field: 'user_name', title: '操作者', align: 'center'}
                        ,{field: 'method', title: '请求方法', align: 'center'}
                        ,{field: 'path', title: '请求路由', align: 'center'}
                        ,{field: 'params', title: '请求参数',align: 'center'}
                        ,{field: 'ip', title: '请求IP', align: 'center'}
                        ,{field: 'created_at', title: '请求时间', sort: true, align: 'center'}
                    ]]
                });
                //搜索
                $("#searchBtn").click(function () {
                    var uid = $("#uid").val();
                    dataTable.reload({
                        where:{uid:uid}
                    })
                });
            })
        </script>
    @endcan
@endsection