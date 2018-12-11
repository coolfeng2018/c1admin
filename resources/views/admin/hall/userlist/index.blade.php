@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">UID</div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">手机号码</div>
                <div class="layui-input-inline">
                    <input type="text" name="phone" id="phone"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">IP</div>
                <div class="layui-input-inline">
                    <input type="text" name="ip" id="ip"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">机器码</div>
                <div class="layui-input-inline">
                    <input type="text" name="dev" id="dev"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">渠道</div>
                <div class="layui-input-inline">
                    <select name="channel" id="channel" lay-verify="required" lay-filter="status" >
                        <option value="0" selected>全部</option>
                        @foreach($channel as $key =>$val)
                        <option value="{{$val['code']}}">{{$val['name']}}</option>
                        @endforeach
                    </select>
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
                    @can('hall.userlist.create')
                    @{{(d.is_lock) ?
                    '<a class="layui-btn layui-btn-sm" lay-event="cancellock">解封</a>':
                    '<a class="layui-btn  layui-btn-danger layui-btn-sm" lay-event="addlock">封号</a>'
                    }}
                    @endcan

                    <a class="layui-btn  layui-btn-sm" lay-event="detail">详情</a>
                </div>
            </script>
            <script type="text/html" id="status">
                <div class="layui-btn-group">
                    <a class="layui-btn  layui-btn-sm" lay-event="edit">@{{$status_name}}</a>
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
                    ,url: "{{ route('admin.userlist.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'uid', title: '玩家Id', align: 'center'}
                        ,{field: 'nickname', title: '玩家昵称', sort: true, align: 'center'}
                        ,{field: 'phone', title: '账号类型', align: 'center'}
                        ,{field: 'phone', title: '手机号码', align: 'center'}
                        ,{field: 'channel', title: '渠道', align: 'center'}
                        ,{field: 'created_time', title: '注册时间', align: 'center'}
                        ,{field: 'ip', title: '注册IP', align: 'center'}
                        ,{field: 'last_ip', title: '最后登陆IP', align: 'center'}
                        ,{field: 'bankInfo', title: '银行卡信息', align: 'center'}
                        ,{field: 'payInfo', title: '支付宝信息', align: 'center'}
                        ,{field: 'client_version', title: '兑现银行卡', align: 'center'}
                        ,{field: 'device_id', title: '机器码', align: 'center'}
                        ,{field: '', title: '操作', align: 'right', toolbar: '#options'}
                    ]]
                });
                var search = {
                    submit: function () {
                        var uid   = $('#uid').val();
                        var phone = $("#phone").val();
                        var ip    = $("#ip").val();
                        var dev   = $("#dev").val();
                        var channel = $("#channel").val();
                        dataTable.reload({
                            where:{uid:uid,phone:phone,ip:ip,dev:dev,channel:channel},
                            page:{curr:1}
                        })
                    }
                };
                //监听工具条
                table.on('tool(dataTable)', function(obj){   //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data                      //获得当前行数据
                        ,layEvent    = obj.event;            //获得 lay-event 对应的值
                    var uid      = data.uid;
                    var status   = data.is_lock;
                    if (layEvent =='detail'){;
                        var index = layer.open({
                            title: '用户详情',
                            type: 2,
                            skin: 'layui-layer-rim',  //加上边框
                            area: ['60%', '60%'],    //宽高
                            content: "userlist/detail?uid="+uid +'&status='+status,
                            shadeClose: true,       //点击遮罩关闭
                        });
                    }else if(layEvent == 'addlock'){
                        var index = layer.open({
                            title: '封号',
                            type: 2,
                            skin: 'layui-layer-rim', //加上边框
                            area: ['40%', '40%'],    //宽高
                            content: "userlist/create?uid="+uid,
                            shadeClose: true,       //点击遮罩关闭
                            end:function(){
                                //location.reload()
                                search.submit();
                            }
                        });
                    }else if(layEvent == 'cancellock'){
                        $.post("{{route('admin.userlist.cancellock')}}", {uid: uid}, function (res) {
                            if (res.code == 0){
                                //layer.msg(res.msg,{icon:1})
                                // location.reload()
                                search.submit();

                            }else {
                                layer.msg(res.msg,{icon:2})
                            }
                        });
                    }
                });

                $("#add").click(function(){
                    var index = layer.open({
                        title: '添加控制名单',
                        type: 2,
                        skin: 'layui-layer-rim',  //加上边框
                        area: ['50%', '50%'],    //宽高
                        content: "gmcontrol/create",
                        shadeClose: true,       //点击遮罩关闭
                    });
                });

                //搜索
                $("#search").click(function () {
                    search.submit();
                });
            });

        </script>
    @endcan
@endsection
