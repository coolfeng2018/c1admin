@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="sdate" id="sdate" value="{{$sdate or date("Y-m-d",strtotime("-10 day"))}}" placeholder="请选择开始日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="edate" id="edate" value="{{$edate or date("Y-m-d")}}" placeholder="请选择结束日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <select id="channel" name="channel" lay-verify="required">
                        <option value="all">所有渠道</option>
                        @foreach($channelList as $index => $val)
                            <option value="{{$val}}">{{ $val }}</option>
                        @endforeach
                    </select>
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
    @can('operate.raetotal')
        <script>
            layui.use(['laydate','table'],function () {
                var laydate = layui.laydate;
                var table = layui.table;
                //开始日期
                laydate.render({
                    elem: '#sdate'
                    ,type: 'date'
                    ,value: ''
                });
                //结束日期
                laydate.render({
                    elem: '#edate'
                    ,type: 'date'
                    ,value: ''
                });

                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.raetotal.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [
                        [
                            {field: 'time', title: '日期', align: 'center'},
                            {field: 'dnu', title: '新增用户数', align: 'center'},
                            {field: 'recharge_count', title: '新增用户充值人数', align: 'center'},
                            {field: 'new_recharge_sum', title: '新增用户充值总额', align: 'center'},
                            {field: 'widthdraw_sum', title: '新增提现总额', align: 'center'},
                            {field: 'dau', title: '活跃人数', align: 'center'},
                            {field: 'rn1', title: '次日留存', align: 'center'},
                            {field: 'recharge_sum', title: '总充值人数', align: 'center'},
                            {field: 'paysum', title: '总充值金额', align: 'center'},
                            {field: 'ecoin', title: '总提现', align: 'center'},
                        ]
                    ]
                });

                //搜索
                $("#searchBtn").click(function () {
                    var sdate = $("#sdate").val();
                    var edate = $("#edate").val();
                    var channel = $("#channel").val();
                    dataTable.reload({
                        where:{sdate:sdate,edate:edate,channel:channel},
                        page:{curr:1}
                    })
                });
            })
        </script>
    @endcan
@endsection