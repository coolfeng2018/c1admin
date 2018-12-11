@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('config.activitypay.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.activitypay.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.activitypay.create') }}">添加</a>
                @endcan
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
            </div>
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="act_name" id="act_name" placeholder="请输入活动名称" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.activitypay.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.activitypay.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="act_mark">
                <a href="@{{d.act_mark}}" target="_blank" title="点击查看"><img src="@{{d.act_mark}}" alt="" width="28" height="28"></a>
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('config.activitypay')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.activitypay.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true, align: 'center'}
                        ,{field: 'act_name', title: '活动名称', align: 'center'}
                        ,{field: 'act_key', title: '活动关键字', align: 'center'}
                        ,{field: 'status_str', title: '活动状态', align: 'center'}
                        ,{field: 'act_mark', title: '背景图',toolbar:'#act_mark', align: 'center'}
                        ,{field: 'start_time', title: '活动开始时间', align: 'center'}
                        ,{field: 'end_time', title: '活动结束时间', align: 'center'}
                        ,{field: 'act_point', title: '活动赠送比例', align: 'center'}
                        ,{field: 'auth', title: '操作者', align: 'center'}
                        ,{field: 'updated_at', title: '操作时间', align: 'center'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });
                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.activitypay.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href ='/admin/activitypay/'+data.id+'/edit';
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
                        layer.confirm('确认批量删除吗？', function(index){
                            $.post("{{ route('admin.activitypay.destroy') }}",{_method:'delete',ids:ids},function (result) {
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

                //搜索
                $("#searchBtn").click(function () {
                    var act_name = $("#act_name").val();
                    dataTable.reload({
                        where:{act_name:act_name}
                    })
                });
            })
        </script>
    @endcan
@endsection