@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                        @can('operate.note.set')
                            <a class="layui-btn layui-btn-sm" lay-event="set">设置生效</a>
                        @endcan
                </div>
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('operate.userhead')
        <script>
            layui.use(['layer','table'],function () {
                var layer = layui.layer;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.note.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: false //开启分页
                    ,cols: [[ //表头
                        {field: 'options', title: '短信服务商', sort: true, align: 'center'}
                        ,{field: 'status', title: '状态', align: 'center'}
                        ,{fixed: 'right', title: '操作',width: 150, align:'center', toolbar: '#options'}
                    ]]
                });
                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'set'){
                        layer.confirm('确认设置吗？', function(index){
                            $.post("{{ route('admin.note.set') }}",{_method:'post',options:data.options},function (result) {
                                if (result.code==0){
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        })
                    }
                });
            })
        </script>
    @endcan
@endsection