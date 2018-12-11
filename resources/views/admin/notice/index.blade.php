@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('notice.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('notice.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.notice.create') }}">添加</a>
                @endcan
                @can('notice.send')
                    <a class="layui-btn layui-btn-sm" id="sendBtn"
                       data-href="{{ route('admin.notice.send') }}">发送到服务器配置</a>
                @endcan

            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('notice.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('notice.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>

        </div>
    </div>
@endsection

@section('script')
    @can('notice.index')
        <script>
            layui.use(['layer', 'table', 'form', 'laydate'], function () {
                var layer = layui.layer;
                // var form = layui.form;
                var table = layui.table;


                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , height: 500
                    , url: "{{ route('admin.notice.data') }}" //数据接口
                    , page: true //开启分页
                    // ,cellMinWidth: 80
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}

                        , {field: 'id', title: 'ID', sort: true, width: 80}

                        , {field: 'info', title: '公告内容', width:500}
                        , {field: 'interval', title: '时间间隔(秒)'}
                        , {field: 'is_circul', title: '是否循环'}
                        , {field: 'play_start_time', title: '播放开始时间'}
                        , {field: 'play_end_time', title: '播放结束时间'}

                        // ,{field: 'create_at', title: '创建时间'}
                        // ,{field: 'update_at', title: '更新时间'}

                        , {fixed: 'right', width: 220, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.notice.destroy') }}", {
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
                        location.href = '/admin/notice/' + data.id + '/edit';
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
                            $.post("{{ route('admin.notice.destroy') }}", {
                                _method: 'delete',
                                ids: ids
                            }, function (result) {
                                if (result.code == 0) {
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

                //搜索
                $("#searchBtn").click(function () {
                    var positionId = $("#position_id").val()
                    var title = $("#title").val();
                    dataTable.reload({
                        where: {position_id: positionId, title: title}
                    })
                });

                //发送配置
                $("#sendBtn").click(function () {
                    layer.confirm('确认发送吗？', function (index) {
                        $.post("{{ route('admin.notice.send') }}", {_method: 'post'}, function (result) {
                            // if (result.code==0){
                            //     dataTable.reload()
                            // }
                            layer.close(index);
                            layer.msg(result.msg, {icon: 6})
                        });
                    })

                    // var positionId = $("#position_id").val()
                    // var title = $("#title").val();
                    // dataTable.reload({
                    //     where:{position_id:positionId,title:title}
                    // })
                });


            })
        </script>
    @endcan
@endsection