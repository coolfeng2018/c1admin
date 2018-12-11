@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('config.paylists.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.paylists.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.paylists.create') }}">添加</a>
                @endcan
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
            </div>
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="pay_name" id="pay_name" placeholder="请输入支付名称" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.paylists.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.paylists.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('config.paylists')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.paylists.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true, align: 'center'}
                        ,{field: 'sort_id', title: '排序', align: 'center'}
                        ,{field: 'pay_name', title: '支付名称', align: 'center'}
                        ,{field: 'pay_channel', title: '支付渠道', align: 'center'}
                        ,{field: 'pay_way_str', title: '支付方式', align: 'center'}
                        ,{field: 'money_list', title: '固定金额', align: 'center'}
                        ,{field: 'is_diy_str', title: '充值类型', align: 'center'}
                        ,{field: 'diy_max', title: '自定义最大金额', align: 'center'}
                        ,{field: 'diy_min', title: '可自定义最小金额', align: 'center'}
                        ,{field: 'pay_desc', title: '支付备注', align: 'center'}
                        ,{field: 'o_status_str', title: '是否生效', align: 'center'}
                        ,{field: 'o_activity_str', title: '是否推荐', align: 'center'}
                        ,{field: 'op_name', title: '操作者', align: 'center'}
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
                            $.post("{{ route('admin.paylists.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href ='/admin/paylists/'+data.id+'/edit';
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
                            $.post("{{ route('admin.paylists.destroy') }}",{_method:'delete',ids:ids},function (result) {
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
                    var pay_name = $("#pay_name").val();
                    dataTable.reload({
                        where:{pay_name:pay_name},
                        page:{curr:1}
                    })
                });
            })
        </script>
    @endcan
@endsection