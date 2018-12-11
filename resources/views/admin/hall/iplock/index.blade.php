@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('hall.iplock.create')
                    <button class="layui-btn layui-btn-sm" id="add"> 添加</button>
                @endcan
            </div>
            <div class="layui-form">
                <div class="layui-input-inline">IP</div>
                <div class="layui-input-inline">
                    <input type="text" name="ip" id="ip" class="layui-input" value="">
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
                    @can('hall.iplock.edit')
                    @{{(d.lock_status == 1) ?
                    '<a class="layui-btn layui-btn-danger  layui-btn-sm status" lay-event="status">解禁</a>':
                    '<a class="layui-btn  layui-btn-sm status" lay-event="status">禁止</a>'
                    }}
                    @endcan
                    <a class="layui-btn  layui-btn-sm" lay-event="edit">编辑</a>

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
                    , url: "{{ route('admin.iplock.data') }}" //数据接口
                    , cellMinWidth: 80
                    , page: true //开启分页
                    , cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'id', title: 'ID', sort: true, align: 'center'}
                        , {field: 'lock_data', title: '禁止', align: 'center'}
                        , {field: 'status', title: '状态', align: 'center'}
                        , {field: 'memo', title: '备注', align: 'center'}
                        , {field: 'op_name', title: '最后修改的操作人', align: 'center'}
                        , {field: 'otime', title: '操作时间', align: 'center'}
                        , {field: '', title: '操作', align: 'right', toolbar: '#options'}
                    ]]
                });
                var search = {
                    submit: function () {
                        var ip = $('#ip').val();
                        dataTable.reload({
                            where: {ip:ip},
                            page:{curr:1}
                        })
                    }
                };
                //监听工具条
                table.on('tool(dataTable)', function (obj) {   //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data                      //获得当前行数据
                        , layEvent = obj.event;            //获得 lay-event 对应的值
                    var id = data.id;
                    var status = data.lock_status;
                    if (layEvent == 'edit') {
                        var index = layer.open({
                            title: '编辑',
                            type: 2,
                            skin: 'layui-layer-rim', //加上边框
                            area: ['60%', '60%'],    //宽高
                            content: "iplock/edit?id=" + id,
                            shadeClose: true,       //点击遮罩关闭
                            end: function () {
                                //location.reload()
                                search.submit();
                            }
                        });
                    } else if (layEvent == 'status') {
                        $.post("{{route('admin.iplock.changeStatus')}}", {id: id, status: status}, function (res) {
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
                        content: "iplock/create",
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
