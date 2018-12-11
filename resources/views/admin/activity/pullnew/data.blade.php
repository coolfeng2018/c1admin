@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="sdate" id="sdate" value="{{$sdate or date("Y-m-d",strtotime("-1 day"))}}" placeholder="请选择开始日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="edate" id="edate" value="{{$edate or date("Y-m-d")}}" placeholder="请选择结束日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>

            <script type="text/html" id="award">
                <div class="layui-input-inline">@{{# if(d.is_award){ }} 是 @{{# }else{ }} 否 @{{# } }}</div>
            </script>

            <script type="text/html" id="options">
                @can('activity.pullnewdata.details')
                    @{{# if(d.is_award){ }}
                        <div class="layui-btn-group">
                            <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="pull-new-detail">查看详情</a>
                        </div>
                    @{{# } }}
                @endcan
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('activity.pullnewdata')
        <script>
            layui.use(['laydate','table','layer'],function () {
                var table = layui.table
                    ,layer = layui.layer
                    ,laydate = layui.laydate;

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

                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.pullnewdata.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: false //开启分页
                    ,cols: [[ //表头
                        // {checkbox: true,fixed: true}
                        {field: 'date', title: '日期',align: 'center'}
                        ,{field: 'payer_pops', title: '参与人数', align: 'center'}
                        ,{field: 'payer_times', title: '参与次数', align: 'center'}
                        ,{field: 'free_times', title: '免费次数', align: 'center'}
                        ,{field: 'pay_coins', title: '付费总额', align: 'center'}
                        ,{field: 'award_coins', title: '获奖总额', align: 'center'}
                        ,{field: 'binds', title: '绑定人数(邀请)', align: 'center'}
                        ,{field: 'is_award', title: '付费总额', align: 'center', toolbar: '#award'}
                        ,{fixed: 'right',title: '操作', width: 150, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'pull-new-detail'){
                        layer.open({
                            type: 2,
                            title: '奖励详情',
                            skin: 'layui-layer-rim', //加上边框
                            anim: 2,
                            area: ['60%', '50%'], //宽高
                            content: "{{ route('admin.pullnewdata.details') }}"+"?date="+data.date
                        });
                    }
                });
                //搜索
                $("#searchBtn").click(function () {
                    var sdate = $("#sdate").val();
                    var edate = $("#edate").val();
                    dataTable.reload({
                        where:{sdate:sdate,edate:edate}
                    })
                });
            })
        </script>
    @endcan
@endsection