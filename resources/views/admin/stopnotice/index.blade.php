@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('config.stopnotice.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.stopnotice.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.stopnotice.create') }}">添加</a>
                @endcan

            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.stopnotice.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.stopnotice.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>

        </div>
    </div>
@endsection

@section('script')
    @can('config.stopnotice')
        <script>
            layui.use(['layer', 'table', 'form', 'laydate'], function () {
                var layer = layui.layer;
                // var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , height: 500
                    , url: "{{ route('admin.stopnotice.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: '编号', sort: true, width: 80}
                        , {field: 'title', title: '公告标题',}
                        , {field: 'info', title: '公告内容'}
                        , {field: 'inscribe', title: '公告落款'}
                        , {field: 'notice_time', title: '通知时间'}
                        , {field: 'start_time', title: '公示开始时间'}
                        , {field: 'end_time', title: '公示结束时间'}
                        , {field: 'redactor', title: '操作者'}
                        , {fixed: 'right', width: 220, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.stopnotice.destroy') }}", {
                                _method: 'delete',
                                ids: [data.id]
                            }, function (result) {
                                if (result.code == 1) {
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg, {icon: 6})
                            });
                        });
                    } else if (layEvent === 'edit') {
                        location.href = '/admin/stopnotice/' + data.id + '/edit';
                    }
                });
                //按钮批量删除
                $("#listDelete").click(function () {
                    var ids = [];
                    var hasCheck = table.checkStatus('dataTable');
                    var hasCheckData = hasCheck.data;
                    if (hasCheckData.length > 0) {
                        $.each(hasCheckData, function (index, element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length > 0) {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.stopnotice.destroy') }}", {
                                _method: 'delete',
                                ids: ids
                            }, function (result) {
                                if (result.code == 1) {
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg, {icon: 6})
                            });
                        })
                    } else {
                        layer.msg('请选择删除项', {icon: 5})
                    }
                })

            })
        </script>
    @endcan
@endsection