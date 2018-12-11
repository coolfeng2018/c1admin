@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    场次
                </div>
                <div class="layui-input-inline">
                    <select id="channel" name="channel" lay-verify="required">
                        <option value="-1" >全部</option>
                        @foreach ($tableList as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="layui-input-inline">
                    账号ID
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid"  class="layui-input" value="">
                </div>


                <div class="layui-input-inline">
                    时间范围
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="stime" id="stime" value="{{$date or $sdate}}" placeholder="开始日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    -
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="etime" id="etime" value="{{$date or $edate}}" placeholder="结束日期"
                           class="layui-input" readonly>
                </div>

                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="search" data-href="">查找</button>
                </div>

            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>

            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    {{--@can('operate.bankorder.refuse')--}}
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="detail">详情</a>
                    {{--@endcan--}}
                </div>
            </script>
        </div>


    </div>
@endsection

@section('script')
    @can('operate.order')
        <script>
            layui.use(['layer','table','laydate'],function () {
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化

                var html = $("#dataTable").html();
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.record.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'table_gid', title: '牌局号', sort: true, align: 'center'}
                        ,{field: 'table_type', title: '房间类型', align: 'center'}
                        ,{field: 'begin_time', title: '游戏时间（开始）', align: 'center'}
                        ,{field: 'userNum', title: '参与人数/机器人', align: 'center'}
                        ,{field: 'winCount', title: '系统总输赢', align: 'center'}
                        ,{field: '', title: '操作', align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){   //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data                      //获得当前行数据
                        ,layEvent = obj.event;               //获得 lay-event 对应的值
                        var gid = data.table_gid;
                        var etime = $("#etime").val();

                        if (layEvent == 'detail'){
                            layer.open({
                                title: '牌局详情',
                                type: 2,
                                skin: 'layui-layer-rim', //加上边框
                                area: ['60%', '50%'], //宽高
                                content: "record/detail?gid="+gid+'&etime='+etime, //弹出的页面
                                shadeClose: true,    //点击遮罩关闭
                            });

                        }
                });
                //搜索
                $("#search").click(function () {
                    var channel = $('#channel').val();
                    var uid = $("#uid").val();
                    var stime = $("#stime").val();
                    var etime = $("#etime").val();
                    dataTable.reload({
                        where:{channel:channel,uid:uid,stime:stime,etime:etime},
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
            });
        </script>
    @endcan
@endsection
