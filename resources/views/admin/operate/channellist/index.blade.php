@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('operate.channellist.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('operate.channellist.create')
                    <a id="addBtn" class="layui-btn layui-btn-sm" data-href="{{ route('admin.channellist.create') }}">添加</a>
                @endcan
                    <button class="layui-btn layui-btn-sm" id="searchBtn" style="display: none;">搜索</button>
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('operate.channellist.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('operate.channellist.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('operate.channellist')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.channellist.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true, align: 'center'}
                        ,{field: 'name', title: '渠道名', align: 'center'}
                        ,{field: 'code', title: '代码', align: 'center'}
                        ,{field: 'created_time', title: '创建时间', align: 'center'}
                        ,{field: 'modified_time', title: '修改时间', align: 'center'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.channellist.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        // location.href ='/admin/channellist/'+data.id+'/edit';
                        var edit_url = '/admin/channellist/' + data.id + '/edit';
                        layer.open({
                            type: 2,
                            title: false,
                            area: ['800px', '800px'],
                            shade: 0.8,
                            shadeClose: true,
                            content: edit_url
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
                        layer.confirm('确认批量删除吗？', function(index){
                            $.post("{{ route('admin.channellist.destroy') }}",{_method:'delete',ids:ids},function (result) {
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
                    dataTable.reload();
                    // var address = $("#address").val();
                    // dataTable.reload({
                    //     where:{address:address}
                    // })
                });

                /**
                 * 添加
                 */
                $('#addBtn').click(function () {
                    var add_url = $(this).attr('data-href');
                    layer.open({
                        type: 2,
                        title: false,
                        area: ['800px', '800px'],
                        shade: 0.8,
                        shadeClose: true,
                        content: add_url
                    });
                });
            })
        </script>
    @endcan
@endsection