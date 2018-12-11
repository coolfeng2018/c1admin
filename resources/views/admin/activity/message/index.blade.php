@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('activity.pullmessage.deleteall')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">批量删除</button>
                @endcan
                @can('activity.pullmessage.editall')
                    <a class="layui-btn layui-btn-sm" id="edit-all">批量处理</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @{{# if(d.status != 2 ){ }}
                        <div class="layui-btn-group">
                            @can('activity.pullmessage.editstatus')
                                <a class="layui-btn layui-btn-sm" lay-event="edit">处理</a>
                            @endcan
                        </div>
                    @{{# } }}
                </div>
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('activity.pullmessage')
        <script>
            layui.use(['layer','table'],function () {
                var layer = layui.layer;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.pullmessage.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID编号',sort: true,align: 'center'}
                        ,{field: 'name', title: '姓名', align: 'center'}
                        ,{field: 'phone', title: '电话', align: 'center'}
                        ,{field: 'content', title: '内容', align: 'center'}
                        ,{field: 'status_name', title: '状态', align: 'center'}
                        ,{field: 'remarks', title: '备注', align: 'center'}
                        ,{field: 'created_at', title: '处理时间', align: 'center'}
                        ,{fixed: 'right',title: '操作', width: 200, align:'center', toolbar: '#options'}
                    ]]
                });
                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'edit'){
                        layer.prompt({
                            value: '备注',
                            title: '填写备注'
                        }, function(value, index){
                            $.post("{{ route('admin.pullmessage.editstatus') }}",{id:data.id,desc:value},function (result) {
                                layer.close(index);
                                if (result.code==0){
                                    dataTable.reload();
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:2})
                                }
                            });
                        });
                    }

                });

                //按钮批量处理
                $("#edit-all").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.prompt({
                            value: '备注',
                            title: '填写备注'
                        }, function(value, index){
                            $.post("{{ route('admin.pullmessage.editall') }}",{ids:ids,desc:value},function (result) {
                            layer.close(index);
                            if (result.code==0){
                            dataTable.reload();
                            layer.msg(result.msg,{icon:6})
                            }else{
                            layer.msg(result.msg,{icon:2})
                            }
                            });
                        })
                    }else {
                        layer.msg('请选择批量处理项',{icon:5})
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
                    //console.log(ids);
                    if (ids.length>0){
                        layer.confirm('确认批量删除吗？', function(index){
                            $.post("{{ route('admin.pullmessage.deleteall') }}",{ids:ids},function (result) {
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