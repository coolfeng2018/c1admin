@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('activity.pullnew.addrobot')
                    <a class="layui-btn layui-btn-danger layui-btn-sm" id="addrobot">添加机器人</a>
                @endcan
                <button class="layui-btn layui-btn-sm" id="searchBtn">刷 新</button>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>

            <script type="text/html" id="add-input-robot">
                <span>机器人昵称 </span>
                <input type="text" id="robot_name" class="layui-layer-input" placeholder="机器人昵称"/>
                <br/>
                <span>机器人积分 (eg:尾数必须为0或者5) </span>
            </script>

            <script type="text/html" id="index-inc">
                @{{d.LAY_TABLE_INDEX+1}}
            </script>

            <script type="text/html" id="robot">
                <div class="layui-input-inline">@{{# if(d.is_robot){ }} 是 @{{# }else{ }} 否 @{{# } }}</div>
            </script>

            <script type="text/html" id="options">
                @{{# if(d.is_robot){ }}
                    <div class="layui-btn-group">
                        @can('activity.pullnew.addscore')
                            <a class="layui-btn layui-btn-sm" lay-event="edit">添加积分</a>
                        @endcan
                    </div>
                @{{# } }}
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('activity.pullnew')
        <script>
            layui.use(['table','laytpl'],function () {
                var table = layui.table
                    ,laytpl = layui.laytpl;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.pullnew.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: false //开启分页
                    ,cols: [[ //表头
                        // {checkbox: true,fixed: true}
                        {field: 'id', title: 'ID',align: 'center',templet: '#index-inc'}
                        ,{field: 'uid', title: '玩家id', align: 'center'}
                        ,{field: 'name', title: '玩家名称', align: 'center'}
                        ,{field: 'value', title: '积分', align: 'center'}
                        ,{field: 'is_robot', title: '是否机器人', align: 'center', toolbar: '#robot'}
                        ,{fixed: 'right', width: 200, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'edit'){
                        layer.prompt({
                            value: 10,
                            title: '积分设置'
                        }, function(value, index){
                            $.post("{{ route('admin.pullnew.addscore') }}",{uid:data.uid,score:value},function (result) {
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

                //添加机器人
                $("#addrobot").click(function () {
                    layer.prompt({
                        value: 10,
                        title: '添加机器人'
                    },function(val, index){
                        var name = $("#robot_name").val();
                        if(name ===""){
                            layer.tips("请填写机器人昵称",$("#robot_name"));
                            return;
                        }
                        $.post("{{ route('admin.pullnew.addrobot') }}",{name:name,score:val},function (result) {
                            layer.close(index);
                            if (result.code == 0){
                                layer.msg(result.msg,{icon:6})
                                dataTable.reload();
                            }else{
                                layer.msg(result.msg,{icon:2})
                            }
                        });
                    });
                    //渲染表单
                    laytpl($("#add-input-robot").html()).render({}, function(html){
                        $(".layui-layer-content").prepend(html);
                    });
                });

                //搜索
                $("#searchBtn").click(function () {
                    dataTable.reload()
                });
            })
        </script>
    @endcan
@endsection