@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('config.exchange.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.exchange.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.exchange.create') }}">添加</a>
                @endcan

                @can('config.exchange.money')
                    <button data-method="setTop" class="layui-btn layui-btn-sm layui-btn-success" id="setMoney">保留金额设置
                    </button>
                @endcan


            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.exchange.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.exchange.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                    @can('config.exchange.status')

                        @verbatim
                            {{#  if(d.status == 1){ }}
                            <a class="layui-btn layui-btn-success layui-btn-sm" lay-event="setStatus"
                               data-status="2">下线</a>
                            {{#  } else { }}
                            <a class="layui-btn layui-btn-success layui-btn-sm" lay-event="setStatus"
                               data-status="1">上线</a>
                            {{#  } }}
                        @endverbatim
                    @endcan
                </div>
            </script>

            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28"
                                                                         height="28"></a>
            </script>
        </div>
    </div>

    <div>
        <form class="layui-form" action="{{route('admin.exchange.money')}}" method="post" id="setMoneyForm"
              style="display: none;">
            <br/>
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">保留金额</label>
                <div class="layui-input-inline">
                    <input type="number" min="0" max="10000000" name="money" required lay-verify="required"
                           placeholder="请输入金额" value="{{$keep_money or 0}}"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">金额</div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">确定</button>
                </div>
            </div>

        </form>
    </div>

@endsection

@section('script')
    @can('config.exchange')
        <script>
            layui.use(['layer', 'table', 'form'], function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;


                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , height: 500
                    , url: "{{ route('admin.exchange.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'method_name', title: '兑换方式'}
                        , {field: 'status_name', title: '当前状态'}
                        , {field: 'min_money', title: '兑换最小额度(元)'}
                        , {field: 'max_money', title: '兑换最大额度(元)'}
                        , {field: 'thumb', title: '角标', toolbar: '#thumb'}
                        , {fixed: 'right', width: 220, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.exchange.destroy') }}", {
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

                        location.href = '/admin/exchange/' + data.id + '/edit';

                    } else if (layEvent === 'setStatus') {

                        layer.confirm('确认更新状态吗？', function (index) {

                            if (data.status == 1) {
                                var update_status = 2;
                            } else {
                                var update_status = 1
                            }

                            $.post("{{ route('admin.exchange.status') }}", {
                                _method: 'post',
                                id: data.id,
                                status: update_status
                            }, function (result) {
                                if (result.code == 1) {
                                    obj.update(data.id); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg, {icon: 6});
                                location.reload(true);
                            }, 'json');
                        });

                    }
                });
                //按钮批量删除
                $("#listDelete").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length > 0) {
                        $.each(hasCheckData, function (index, element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length > 0) {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.exchange.destroy') }}", {
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

                //弹窗 设置
                $('#setMoney').click(function () {
                    layer.open({
                        type: 1,
                        title: '设置保留金额',
                        content: $('#setMoneyForm') //这里content是一个普通的String
                    });
                });

                //搜索
                $("#searchBtn").click(function () {
                    var positionId = $("#position_id").val()
                    var title = $("#title").val();
                    dataTable.reload({
                        where: {position_id: positionId, title: title},
                        page:{curr:1}
                    })
                })
            })
        </script>
    @endcan
@endsection