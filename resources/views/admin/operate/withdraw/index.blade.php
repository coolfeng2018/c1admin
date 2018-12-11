@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid" placeholder="请输入游戏ID" class="layui-input">
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
                    @can('operate.withdraw.send')
                        <a class="layui-btn layui-btn-sm" lay-event="send">通过</a>
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="send_1">拒绝</a>
                        <a class="layui-btn layui-btn-warm layui-btn-sm" lay-event="send_2">驳回</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="#" >@{{d.uid}}</a>
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
                    ,url: "{{ route('admin.withdraw.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'id', title: '编号', sort: true, align: 'center'}
                        ,{field: 'uid', title: '游戏ID', align: 'center',toolbar:'#thumb'}
                        ,{field: 'Amount', title: '申请提现金额', align: 'center'}
                        ,{field: 'Balance', title: '余额', align: 'center'}
                        ,{field: 'trueMoney', title: '需转金额', align: 'center'}
                        ,{field: 'Fees', title: '手续费', align: 'center'}
                        ,{field: 'WithdrawChannel_name', title: '兑换方式', align: 'center'}
                        ,{field: 'CreateAt', title: '申请时间', align: 'center'}
                        ,{field: 'status_name', title: '状态', align: 'center'}
                        ,{field: 'remark', title: '备注', align: 'center'}
                        ,{fixed: 'right', width: 150, align:'center', toolbar: '#options'}
                    ]]
                });
                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值

                    if(layEvent === 'send'){
                        layer.prompt({
                            formType: 2,
                            value: 'ok,审核通过。。。',
                            title: '审核通过备注',
                            area: ['60', '50']
                        }, function(value, index){

                            $.post("{{ route('admin.withdraw.send') }}",{ids:data.id,type:1,desc:value},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:2})
                                }
                                layer.close(index);
                            });
                        });
                    } else if(layEvent === 'send_1'){
                        layer.prompt({
                            formType: 2,
                            value: '',
                            title: '审核拒绝备注',
                            area: ['60', '50']
                        }, function(value, index){

                            $.post("{{ route('admin.withdraw.send') }}",{ids:data.id,type:2,desc:value},function (result) {
                                if (result.code==0){
                                    dataTable.reload();
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:2})
                                }
                                layer.close(index);
                            });
                        });
                    }else if(layEvent === 'send_2'){
                        layer.prompt({
                            formType: 2,
                            value: '',
                            title: '审核驳回备注',
                            area: ['60', '50']
                        }, function(value, index){

                            $.post("{{ route('admin.withdraw.send') }}",{ids:data.id,type:3,desc:value},function (result) {
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