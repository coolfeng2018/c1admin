@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">


                    <a class="layui-btn layui-btn-sm" style="width: 80px" href="{{ route('admin.package.create') }}">添加</a>


                    <button class="layui-btn layui-btn-sm " style="width:120px;" id="send">发送配置到服务器</button>

            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">

                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>


                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>

                </div>
            </script>

            <script type="text/html" id="url">
                <a href="{{$path or ''}}@{{d.url}}" target="_blank" title="点击查看"><img src="{{$path or ''}}@{{d.url}}" alt="" width="50"></a>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('config.goods')
        <script>
            layui.use(['layer', 'table', 'form'], function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , height: 500
                    , url: "{{ route('admin.sysnotice.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                       /* {checkbox: true, fixed: true}*/
                          {field: 'prop_id', title: 'ID'}
                        , {field: 'name', title: '物品名称'}
                        , {field: 'type_name', title: '类型'}
                        , {field: 'describe', title: '描述'}
                        , {field: 'url', title: '图片',toolbar:'#url'}
                        , {field: 'updated_at', title: '更新时间'}
                        , {fixed: 'right', width: 220, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.sysnotice.destroy') }}", {
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
                        location.href = '/admin/sysnotice/edit?id=' + data.id;
                    }
                });
                $("#send").click(function(){
                    $.post("{{route('admin.sysnotice.send')}}", {}, function (res) {
                        if (res.code == 0) {
                            layer.msg(res.msg, {icon: 1})
                        } else {
                            layer.msg(res.msg, {icon: 2})
                        }
                    })
                })

            })
        </script>
    @endcan
@endsection