@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >

                <div class="layui-input-inline">
                    玩家ID
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" data-href="" id="searchBtn">查找</button>
                </div>

                <div class="layui-input-inline">
                    @can('operate.goldcoin.create')
                        <a class="layui-btn layui-btn-sm" href="{{ route('admin.goldcoin.create') }}">修改金币</a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable">

            </table>
        </div>
    </div>
@endsection

@section('script')
    @can('operate.goldcoin')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.goldcoin.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'uid', title: '玩家ID'}
                        ,{field: 'type', title: '修改类型'}
                        ,{field: 'value', title: '修改数量'}
                        ,{field: 'remarks', title: '备注'}
                        ,{field: 'auth', title: '操作者'}
                        ,{field: 'updated_at', title: '操作时间'}
                    ]]
                });
                //搜索
                $("#searchBtn").click(function () {
                    var uid = $("#uid").val();
                    dataTable.reload({
                        where:{uid:uid},
                        page:{curr:1}
                    })
                });
            })
        </script>
    @endcan
@endsection