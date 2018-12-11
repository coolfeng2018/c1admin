@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('brodcast.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('brodcast.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.brodcast.create') }}">添加</a>
                @endcan
                @can('brodcast.send')
                    <a class="layui-btn layui-btn-sm" id="sendBtn"
                       data-href="{{ route('admin.brodcast.send') }}">发送到服务器配置</a>
                @endcan


                {{--<button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>--}}
            </div>
            {{--<div class="layui-form" >
                <div class="layui-input-inline">
                    <select name="position_id" lay-verify="required" id="position_id">
                        <option value="">请选择广告位置</option>

                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="title" placeholder="请输入标题" class="layui-input">
                </div>
            </div>--}}
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('brodcast.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('brodcast.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="coins_range">
            @{{ d.coins_range_min + ' - '+ d.coins_range_max }}
            </script>
            <script type="text/html" id="time_range">
                @{{ d.time_range_min + ' - '+ d.time_range_max }}
            </script>

            {{--<script type="text/html" id="thumb">--}}
            {{--<a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>--}}
            {{--</script>--}}
        </div>
    </div>
@endsection

@section('script')
    @can('brodcast.index')
        <script>
            layui.use(['layer', 'table', 'form'], function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , height: 500
                    , url: "{{ route('admin.brodcast.data') }}" //数据接口
                    , page: true //开启分页
                    // ,cellMinWidth: 80
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}

                        // , {field: 'id', title: 'ID', sort: true, width: 50}
                        , {field: 'mid', title: '消息ID', sort: true, width: 100}

                        , {field: 'type_name', title: '广播类型', width: 100}
                        , {field: 'broad_name', title: '游戏名称', width: 100}
                        , {field: 'info', title: '信息', width: 700}
                        , {field: 'exit_time', title: '保留时间(秒)'}
                        , {field: 'coins_range', title: '生成金币范围', }
                        , {field: 'time_range', title: '生成时间范围', }
                        , {field: 'target_coins', title: '触发金额', width: 100}

                        // ,{field: 'create_at', title: '创建时间'}
                        // ,{field: 'update_at', title: '更新时间'}

                        , {fixed: 'right', width: 140, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.brodcast.destroy') }}", {
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
                        location.href = '/admin/brodcast/' + data.id + '/edit';
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
                            $.post("{{ route('admin.brodcast.destroy') }}", {
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
                        where: {position_id: positionId, title: title},
                        page:{curr:1}
                    })
                });

                //发送配置
                $("#sendBtn").click(function () {
                    layer.confirm('确认发送吗？', function (index) {
                        $.post("{{ route('admin.brodcast.send') }}", {_method: 'post'}, function (result) {
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