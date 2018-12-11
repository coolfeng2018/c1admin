@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('hall.gmcontrol.create')
                    <button class="layui-btn layui-btn-sm" id="add"> 添加</button>
                @endcan
            </div>
            <div class="layui-form">
                <div class="layui-input-inline">玩家ID</div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" class="layui-input" value="">
                </div>
                <div class="layui-input-inline">状态</div>
                <div class="layui-input-inline">
                    <select name="status" id="status" lay-verify="required" lay-filter="status">
                        <option value="-1" selected>全部</option>
                        @foreach($status as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
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
                    @{{(d.curr_status == 1) ?
                    '<a class="layui-btn layui-btn-danger  layui-btn-sm status" lay-event="status">停止</a>':
                    '<a class="layui-btn  layui-btn-sm status" lay-event="status">启用</a>'
                    }}

                    @can('hall.gmcontrol.edit')
                        <a class="layui-btn  layui-btn-sm" lay-event="edit">编辑</a>
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
            layui.use(['layer', 'table', 'laydate'], function () {
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化

                var html = $("#dataTable").html();
                var dataTable = table.render({
                    elem: '#dataTable'
                    , url: "{{ route('admin.gmcontrol.data') }}" //数据接口
                    , cellMinWidth: 80
                    , page: true //开启分页
                    , cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'name', title: '玩家昵称', sort: true, align: 'center'}
                        , {field: 'uid', title: '玩家Id', align: 'center'}
                        , {field: 'init_control_coins', title: '控制金额', align: 'center'}
                        , {field: 'curr_control_coins', title: '当前个人库存值', align: 'center'}
                        , {field: 'curr_control_status', title: '状态', align: 'center'}
                        , {field: 'curr_control_weight', title: '权重值', align: 'center'}
                        , {field: 'creation_type', title: '创建类型', align: 'center'}
                        , {field: 'create_at', title: '创建时间', align: 'center'}
                        , {field: 'editor', title: '最后修人员', align: 'center'}
                        , {field: '', title: '操作', align: 'right', toolbar: '#options'}
                    ]]
                });
                var search = {
                    submit: function () {
                        var uid = $('#uid').val();
                        var range = $("#range").val();
                        var title = $("#title").val();
                        var status = $("#status").val();
                        dataTable.reload({
                            where: {uid: uid, range: range, title: title, status: status},
                            page:{curr:1}
                        })
                    }
                };
                //监听工具条
                table.on('tool(dataTable)', function (obj) {   //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data                      //获得当前行数据
                        , layEvent = obj.event;            //获得 lay-event 对应的值
                    var uid = data.uid;
                    var status = data.curr_status;
                    if (layEvent == 'detail') {
                        var index = layer.open({
                            title: '邮件详情',
                            type: 2,
                            skin: 'layui-layer-rim',  //加上边框
                            area: ['60%', '60%'],    //宽高
                            content: "gmcontrol/detail?uid=" + uid,
                            shadeClose: true,       //点击遮罩关闭
                        });
                    } else if (layEvent == 'edit') {
                        var index = layer.open({
                            title: '编辑',
                            type: 2,
                            skin: 'layui-layer-rim', //加上边框
                            area: ['60%', '60%'],    //宽高
                            content: "gmcontrol/edit?uid=" + uid,
                            shadeClose: true,       //点击遮罩关闭
                            end: function () {
                                //location.reload()
                                search.submit();
                            }
                        });
                    } else if (layEvent == 'status') {
                        $.post("{{route('admin.gmcontrol.changeStatus')}}", {uid: uid, status: status}, function (res) {
                            if (res.code == 0) {
                                //layer.msg(res.msg,{icon:1})
                                // location.reload()
                                search.submit();

                            } else {
                                layer.msg(res.msg, {icon: 2})
                            }
                        });
                    }
                });

                $("#add").click(function () {
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
