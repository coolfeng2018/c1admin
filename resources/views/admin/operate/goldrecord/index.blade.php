@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <select id="reason" name="reason" lay-verify="required">
                        <option value selected>变化原因选择</option>
                        @foreach($goldReasonList as $index => $goldReason)
                            <option value="{{$index}}">{{ $goldReason['cn'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select id="table" name="table" lay-verify="required">
                        <option value selected>房间选择</option>
                        @foreach($tableList as $index => $table)
                            <option value="{{$index}}">{{ $table }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" placeholder="请输入用户ID" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    日期
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="stime" id="stime" value="{{$stime or date("Y-m-d H:i:s",strtotime("-7 day"))}}" placeholder="开始日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    -
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="etime" id="etime" value="{{$etime or date("Y-m-d H:i:s")}}" placeholder="结束日期"
                           class="layui-input" readonly>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            {{--<script type="text/html" id="options">--}}
                {{--<div class="layui-btn-group">--}}
                    {{--@can('operate.userhead.send')--}}
                        {{--<a class="layui-btn layui-btn-sm" lay-event="send">审核通过</a>--}}
                    {{--@endcan--}}
                    {{--@can('operate.userhead.refuse')--}}
                        {{--<a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="refuse">拒绝</a>--}}
                    {{--@endcan--}}
                {{--</div>--}}
            {{--</script>--}}
            {{--<script type="text/html" id="head_url">--}}
                {{--<a href="@{{d.head_url_str}}" target="_blank" title="点击查看">--}}
                    {{--<img src="@{{d.head_url_str}}" alt="" width="28" height="28">--}}
                {{--</a>--}}
            {{--</script>--}}
        </div>
    </div>
@endsection
@section('script')
    @can('operate.goldrecord')
        <script>
            layui.use(['layer','table','laydate'],function () {
                var layer = layui.layer;
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.goldrecord.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        // {field: 'id', title: 'ID', sort: true, align: 'center'}
                        {field: 'uid', title: 'UID', align: 'center'}
                        ,{field: 'cur_num', title: '变化前数量', align: 'center'}
                        ,{field: 'chg_num', title: '变化数量', align: 'center'}
                        ,{field: 'rsn', title: '变化原因', align: 'center'}
                        ,{field: 'table', title: '房间类型', align: 'center'}
                        ,{field: 'channel', title: '渠道号', align: 'center'}
                        ,{field: 'optime', title: '操作时间', align: 'center'}
                    ]]
                });
                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'refuse'){
                        layer.prompt({
                            formType: 2,
                            value: '请输入',
                            title: '审核拒绝备注',
                            area: ['60', '50']
                        }, function(value, index){

                            $.post("{{ route('admin.userhead.refuse') }}",{ids:[data.id],desc:value},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:2})
                                }
                                layer.close(index);
                            });
                        });
                    } else if(layEvent === 'send'){
                        layer.prompt({
                            formType: 2,
                            value: '请输入',
                            title: '审核通过备注',
                            area: ['60', '50']
                        }, function(value, index){

                            $.post("{{ route('admin.userhead.send') }}",{id:data.id,desc:value},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:2})
                                }
                                layer.close(index);
                            });
                        });
                    }
                });
                //搜索
                $("#searchBtn").click(function () {
                    var uid = $("#uid").val();
                    var reason = $("#reason").val();
                    var table = $("#table").val();
                    var stime = $("#stime").val();
                    var etime = $("#etime").val();
                    dataTable.reload({
                        where:{uid:uid,reason:reason,table:table,stime:stime,etime:etime},
                        page:{curr:1}
                    })
                });
                //开始日期
                laydate.render({
                    elem: '#stime'
                    ,type: 'datetime'
                });
                //结束日期
                laydate.render({
                    elem: '#etime'
                    ,type: 'datetime'
                });
            })
        </script>
    @endcan
@endsection