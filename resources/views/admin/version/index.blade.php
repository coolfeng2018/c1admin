@extends('admin.base')

@section('content')

    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">

                @can('config.version.create')
                    <a class="layui-btn layui-btn-sm" style="width: 80px" href="{{route('admin.version.create') }}">添加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.version.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.version.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>

        </div>
    </div>
@endsection

@section('script')
        <script>
            layui.use(['layer', 'table', 'form'], function () {
                var layer = layui.layer;
                var table = layui.table;
                var dataTable = table.render({
                    elem: '#dataTable'
                    , height: 500
                    , url: "{{ route('admin.version.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                       /* {checkbox: true, fixed: true}*/
                          {field: 'id', title: 'id'}
                        , {field: 'version', title: '更新版本'}
                        , {field: 'is_force', title: '是否强更'}
                        , {field: 'update_type', title: '类型'}
                        , {field: 'allow_version', title: '允许版本'}
                        , {field: 'allow_channel', title: '允许渠道'}
                        , {field: 'platform', title: '平台'}
                        , {field: 'is_public', title: '版本公开'}
                        , {field: 'status_name', title: '状态'}
                        , {field: 'release_time', title: '更新时间'}
                        , {fixed: 'right', width: 220, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) {
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.version.destroy') }}", {
                                _method: 'delete',
                                ids: [data.id]
                            }, function (result) {
                                if (result.code == 0) {
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg, {icon: 6})
                            });
                        });
                    } else if (layEvent === 'edit') {
                        location.href = '/admin/version/edit?id=' + data.id;
                    }
                });

            })
        </script>
@endsection