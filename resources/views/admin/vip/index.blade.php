@extends('admin.base')

@section('content')
    <style>
        .laytable-cell-1-privilege_name{
            height: auto;
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('config.vip.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.vip.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.vip.create') }}">添加</a>
                @endcan
                @can('config.vip.send')
                    <a class="layui-btn layui-btn-sm" id="sendBtn" data-href="{{ route('admin.vip.send') }}">发送到服务端配置</a>
                @endcan
            </div>
           
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">

                    @can('config.vip.online')
                        @verbatim
                            {{#  if(d.online == 1){ }}
                            <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="online"
                               data-status="0">下线</a>
                            {{#  } else { }}
                            <a class="layui-btn layui-btn-success layui-btn-sm" lay-event="online"
                               data-status="1">上线</a>
                            {{#  } }}
                        @endverbatim
                    @endcan

                    @can('config.vip.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.vip.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan

                </div>
            </script>

            <script type="text/html" id="icon_border_url">
                <a href="@{{d.icon_border_url}}" target="_blank" title="点击查看"><img src="@{{d.icon_border_url}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="battery_url">
                <a href="@{{d.battery_url}}" target="_blank" title="点击查看"><img src="@{{d.battery_url}}" alt="" width="28" height="28"></a>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('config.vip')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                // var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.vip.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'level', title: 'VIP等级',width:90}
                        ,{field: 'free_num', title: '大抽奖次数'}
                        ,{field: 'week_award_max', title: '周福利上限'}
                        ,{field: 'charge_coins', title: '充值金额'}
                        ,{field: 'privilege_name', title: 'VIP特权',width:600}
                        ,{field: 'icon_border_url', title: '头像框', toolbar:'#icon_border_url'}
                        // ,{field: 'battery_url', title: '专属炮台图片', toolbar:'#battery_url'}
                        // ,{field: 'online', title: '状态'}
                        // ,{field: 'created_at', title: '创建时间'}
                        // ,{field: 'updated_at', title: '更新时间'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.vip.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/vip/'+data.id+'/edit';
                    } else if (layEvent === 'online') {

                        layer.confirm('确认更新状态吗？', function (index) {
                            $.post("{{ route('admin.vip.online') }}", {
                                _method: 'post',
                                id: data.id,
                                status: parseInt(data.online) == 0 ? 1 : 0
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
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.vip.destroy') }}",{_method:'delete',ids:ids},function (result) {
                                if (result.code==0){
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        })
                    }else {
                        layer.msg('请选择删除项',{icon:5})
                    }
                });

                $("#sendBtn").click(function () {

                    var _this = $(this);

                    layer.confirm('确认发送吗？', function (index) {
                        $.post(_this.attr('data-href'), {_method: 'post'}, function (result) {
                            layer.close(index);
                            layer.msg(result.msg, {icon: 6})
                        });
                    })
                });

                //搜索
                // $("#searchBtn").click(function () {
                //     var positionId = $("#position_id").val()
                //     var title = $("#title").val();
                //     dataTable.reload({
                //         where:{position_id:positionId,title:title}
                //     })
                // })
            })
        </script>
    @endcan
@endsection