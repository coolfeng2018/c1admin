@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <audio src="/music/WeChat.mp3" type="audio/mpeg" id="myaudio" loop="false" hidden="true"></audio>
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" placeholder="请输入用户ID" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <select id="status" name="status" lay-verify="required">
                        @foreach($statusArr as $index => $statusName)
                            <option value="{{$index}}" {{ ($index ==  -1 ) ? 'selected' : '' }}>{{ $statusName }}</option>
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
            <script type="text/html" id="read_state">
                @{{#  if(d.read_state == 0){ }}
                <span class="layui-badge">未读取</span>
                @{{#  } else { }}
                <span class="layui-badge layui-bg-gray">已读取</span>
                @{{#  } }}
            </script>
            <script type="text/html" id="reback">
                @{{#  if(d.reback == 0){ }}
                    <span class="layui-badge">未回复</span>
                @{{#  } else { }}
                    <span class="layui-badge layui-bg-gray">已回复</span>
                @{{#  } }}
            </script>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('operate.customer.send')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="send">回复</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('operate.customer')
        <script>
            layui.use(['layer','table'],function () {
                var layer = layui.layer;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.customer.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'MessageId', title: 'ID', sort: true, align: 'center'}
                        ,{field: 'FromUid', title: '发送者', align: 'center'}
                        ,{field: 'ToUid', title: '接收者', align: 'center'}
                        ,{field: 'read_state', title: '是否读取', align: 'center',toolbar: '#read_state'}
                        ,{field: 'message', title: '消息', align: 'center'}
                        ,{field: 'reback', title: '是否回复', align: 'center',toolbar: '#reback'}
                        ,{field: 'time', title: '留言时间', align: 'center'}
                        ,{field: 'updatetime', title: '最后回复时间', align: 'center'}
                        ,{fixed: 'right', width: 150, align:'center', toolbar: '#options'}
                    ]]
                });
                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'send'){
                        layer.open({
                            type: 2,
                            title: '回复'+data.FromUid,
                            skin: 'layui-layer-rim', //加上边框
                            area: ['60%', '90%'], //宽高
                            content: "{{ route('admin.customer.send') }}"+"?id="+data.MessageId+"&uid="+data.FromUid,
                            shadeClose:true,
                            end:function () {
                                dataTable.reload();
                            }
                        });
                    }
                });

                //搜索
                $("#searchBtn").click(function () {
                    var uid = $("#uid").val();
                    var status = $("#status").val();
                    dataTable.reload({
                        where:{uid:uid,status:status},
                        page:{curr:1}
                    })
                });

                //定时器
                setInterval(function () {
                    $.post("{{route('admin.customer.play')}}", {}, function (res) {
                        var myAuto = document.getElementById('myaudio');
                        if (res.code == 0 && res.data.is_open){
                            //刷新表
                            if(res.data.is_refash){
                                dataTable.reload();
                            }
                            //播放
                            myAuto.play();
                            setTimeout(function () {
                                myAuto.pause();
                            },3000);
                        }else {
                            //停止
                            myAuto.pause();
                            myAuto.load();
                        }
                    });
                },5000);
            })
        </script>
    @endcan
@endsection