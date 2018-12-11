@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    平台
                </div>
                <div class="layui-input-inline">
                    <select id="channel" name="channel" lay-verify="required">
                        @foreach($list['channel'] as $index => $statusName)
                            <option value="{{$index}}" {{ ($index == 'z' ) ? 'selected' : '' }}>{{ $statusName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="layui-input-inline">
                    支付方式
                </div>
                <div class="layui-input-inline">
                    <select id="payment_channel" name="payment_channel" lay-verify="required">
                        @foreach($list['payList'] as $index => $statusName)
                            <option value="{{$index}}" {{ ($index == 'z' ) ? 'selected' : '' }}>{{ $statusName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="layui-input-inline">
                    状态
                </div>
                <div class="layui-input-inline">
                    <select id="status" name="status" lay-verify="required">
                        @foreach($list['status'] as $index => $statusName)
                            <option value="{{$index}}" {{ ($index == 'z' )? 'selected':''}}>{{ $statusName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="layui-input-inline">
                    用户ID
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid"  class="layui-input" value="">
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

                <div class="layui-input-inline">
                   @can('operate.order.orderadd')
                        <button class="layui-btn layui-btn-sm"  data-href="">
                            <a class="layui-btn layui-btn-sm" href="{{ route('admin.order.orderadd')}}">添加人工订单</a>
                        </button>
                    @endcan

                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="export" data-href="">导出EXCEL</button>
                </div>

            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <div class="layui-btn-group">
                        @{{# if(d.status != 3 ){ }}
                        <a class="layui-btn layui-btn-sm" lay-event="discarded">废弃</a>
                        @{{# } }}
                    </div>
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('operate.order')
        <script>
            layui.use(['layer','table','form','laydate'],function () {
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.order.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'uid', title: '用户ID', sort: true, align: 'center'}
                        ,{field: 'name', title: '昵称', align: 'center'}
                        ,{field: 'order_id', title: '订单号', align: 'center'}
                        ,{field: 'payment_channel', title: '付款方式', align: 'center'}
                        ,{field: 'status_name', title: '支付结果', align: 'center'}
                        ,{field: 'channel', title: '平台', align: 'center'}
                        ,{field: 'productName', title: '商品名称', align: 'center'}
                        ,{field: 'amount', title: '金额', align: 'center'}
                        ,{field: 'give_money', title: '赠送金额', align: 'center'}
                        ,{field: 'create_time', title: '购买时间', align: 'center'}
                        ,{fixed: 'right', title:'操作', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //搜索
                $("#search").click(function () {
                    var channel = $("#channel").val();
                    var payment_channel = $("#payment_channel").val();
                    var status = $("#status").val();
                    var uid = $("#uid").val();
                    var stime = $("#stime").val();
                    var etime = $("#etime").val();
                    dataTable.reload({
                        where:{channel:channel,payment_channel:payment_channel,status:status,uid:uid,stime:stime,etime:etime},
                        page:{curr:1}
                    })
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

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'discarded'){
                        layer.confirm('确认废除吗？', function(index){
                            $.post("{{ route('admin.order.destroy') }}",{order_id:data.order_id},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                }
                                layer.close(index);
                              //  layer.msg(result.msg,{icon:6})
                            });
                        });
                    }
                });
            });
        </script>
    @endcan
@endsection
