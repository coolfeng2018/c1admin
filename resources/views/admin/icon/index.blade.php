@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('config.icon.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.icon.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.icon.create') }}">添加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.icon.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                        <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="edit_one">上移</a>
                        <a class="layui-btn layui-btn-warm layui-btn-sm" lay-event="edit_two">下移</a>
                    @endcan
                    @can('config.icon.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('config.icon')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.icon.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'sort_id', title: '排序顺序'}
                        ,{field: 'name', title: '入口名称'}
                        ,{field: 'key_id', title: '活动key值'}
                        ,{field: 'auth', title: '操作者'}
                        ,{fixed: 'right', title:'操作', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.icon.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/icon/'+data.id+'/edit';
                    } else if(layEvent === 'edit_one'){
                        layer.confirm('确认上移吗？', function(index){
                            $.post("{{ route('admin.icon.move') }}",{id:data.id,type:1},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                }
                                layer.close(index);
                            });
                        });
                    }else if(layEvent === 'edit_two'){
                        layer.confirm('确认下移吗？', function(index){
                            $.post("{{ route('admin.icon.move') }}",{id:data.id,type:2},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                }
                                layer.close(index);
                            });
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
                            $.post("{{ route('admin.icon.destroy') }}",{_method:'delete',ids:ids},function (result) {
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

            })
        </script>
    @endcan
@endsection