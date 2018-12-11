@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" placeholder="请输入用户ID" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <select id="status" name="status" lay-verify="required">
                        @foreach($statusArr as $index => $statusName)
                            <option value="{{$index}}" {{ ($index ==  -1 ) ? 'selected' : '' }}>{{ $statusName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @{{#  if(d.o_status == 0){ }}
                        @can('operate.bankorder.send')
                            <a class="layui-btn layui-btn-sm" lay-event="send">通过并发货</a>
                        @endcan
                        @can('operate.bankorder.refuse')
                            <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="refuse">拒绝</a>
                        @endcan
                    @{{#  } }}
                </div>
            </script>
        </div>
    </div>
@endsection
@section('script')
    @can('operate.bankorder')
        <script>
            layui.use(['layer','table'],function () {
                var layer = layui.layer;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.bankorder.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'id', title: 'ID', sort: true, align: 'center'}
                        ,{field: 'order_id', title: '订单号', align: 'center'}
                        ,{field: 'uid', title: '用户id', align: 'center'}
                        ,{field: 'way_str', title: '转账方式', align: 'center'}
                        ,{field: 'bank_user_name', title: '姓名', align: 'center'}
                        ,{field: 'bank_account', title: '账号', align: 'center'}
                        ,{field: 'money', title: '金额', align: 'center'}
                        ,{field: 'give_money', title: '赠送金额', align: 'center'}
                        ,{field: 'o_status_str', title: '状态', align: 'center'}
                        ,{field: 'inner_order_id', title: '内部订单号', align: 'center'}
                        ,{field: 'o_desc', title: '备注', align: 'center'}
                        ,{field: 'op_name', title: '操作者', align: 'center'}
                        ,{field: 'updated_at', title: '操作时间', align: 'center'}
                        ,{fixed: 'right', width: 150, align:'center', toolbar: '#options'}
                    ]]
                });
                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'refuse'){
                        layer.confirm('确认拒绝吗？', function(index){
                            $.post("{{ route('admin.bankorder.refuse') }}",{ids:[data.id]},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:2})
                                }
                                layer.close(index);
                            });
                        });
                    } else if(layEvent === 'send'){
                        layer.confirm('通过并发货吗？', function(index){
                            $.post("{{ route('admin.bankorder.send') }}",{id:data.id},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:2})
                                }
                                layer.close(index);
                            });
                        });
                    }
                });
                //搜索
                $("#searchBtn").click(function () {
                    var uid = $("#uid").val();
                    var status = $("#status").val();
                    dataTable.reload({
                        where:{uid:uid,status:status},
                        page:{curr:1}
                    })
                });
            })
        </script>
    @endcan
@endsection