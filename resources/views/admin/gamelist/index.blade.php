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
                @can('config.gamelist.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.gamelist.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.gamelist.create') }}">添加</a>
                @endcan
                @can('config.gamelist.send')
                    <a class="layui-btn layui-btn-sm" id="sendBtn" data-href="{{ route('admin.gamelist.send') }}">发送到服务端配置</a>
                @endcan
            </div>
           
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.gamelist.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.gamelist.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan

                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('config.gamelist')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                // var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.gamelist.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'position', title: '大厅位置排序', sort: true,width:150}
                        ,{field: 'game_type', title: '游戏',width:90}
                        ,{field: 'notice_type', title: '角标'}
                        ,{field: 'guide_status_str', title: '是否强引导'}
                        ,{field: 'shown_type', title: '类型',width:600}
                        ,{field: 'status', title: '状态'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.gamelist.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/gamelist/'+data.id+'/edit';
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
                            $.post("{{ route('admin.gamelist.destroy') }}",{_method:'delete',ids:ids},function (result) {
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

            })
        </script>
    @endcan
@endsection