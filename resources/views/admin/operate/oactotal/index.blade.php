@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline hidden">
                    <input type="hidden" name="oac_list" id="oac_list" value="{{$oacListArr}}" class="layui-input">
                    <input type="hidden" name="prefix" id="prefix" value="{{$prefix}}" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="sdate" id="sdate" value="{{$sdate or date("Y-m-d",strtotime("-1 day"))}}" placeholder="请选择开始日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="edate" id="edate" value="{{$edate or date("Y-m-d")}}" placeholder="请选择结束日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <span class="layui-word-aux">单位：元</span>
            <table id="dataTable" lay-filter="dataTable"></table>
        </div>
    </div>
@endsection
@section('script')
    @can('operate.oactotal')
        <script>
            layui.use(['laydate','table'],function () {
                var laydate = layui.laydate;
                var table = layui.table;
                var tableListArr = JSON.parse($("#oac_list").val());
                var prefix = $("#prefix").val();
                //开始日期
                laydate.render({
                    elem: '#sdate'
                    ,format: 'yyyy-MM-dd'
                    ,value: ''
                });
                //结束日期
                laydate.render({
                    elem: '#edate'
                    ,format: 'yyyy-MM-dd'
                    ,value: ''
                });

                var cols = [{field: 'date', title: '日期', align: 'center'}];
                $.each(tableListArr,function (index,value) {
                    cols.push({field: prefix+index, title: value, align: 'center'});
                });

                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.oactotal.data') }}" //数据接口
                    ,cellMinWidth: 100
                    ,page: false //开启分页
                    ,cols: [cols]
                });

                //搜索
                $("#searchBtn").click(function () {
                    var sdate = $("#sdate").val();
                    var edate = $("#edate").val();
                    dataTable.reload({
                        where:{sdate:sdate,edate:edate},
                        page:{curr:1}
                    })
                });
            })
        </script>
    @endcan
@endsection