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
                        @can('operate.userhead.send')
                            <a class="layui-btn layui-btn-sm" lay-event="send">审核通过</a>
                        @endcan
                        @can('operate.userhead.refuse')
                            <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="refuse">拒绝</a>
                        @endcan
                    @{{#  } }}
                </div>
            </script>
            <script type="text/html" id="head_url">
                <a href="@{{ d.head_url_str }} " target="_blank" title="点击查看">
                    <img src="@{{ d.head_url_str }}" alt="" width="28" height="28">
                </a>
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
                    ,url: "{{ route('admin.userhead.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'id', title: 'ID', sort: true, align: 'center'}
                        ,{field: 'uid', title: '用户id', align: 'center'}
                        ,{field: 'head_url_str', title: '头像',toolbar:'#head_url', align: 'center'}
                        ,{field: 'o_status_str', title: '状态', align: 'center'}
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
                        layer.prompt({
                            formType: 2,
                            value: '亲爱的玩家，您上传的头像涉嫌违规，不符合社会主义价值核心观，请重新上传合法合规的头像，期待您酷炫的个性头像哦~',
                            title: '审核拒绝备注',
                            area: ['60', '50']
                        }, function(value, index){

                            $.post("{{ route('admin.userhead.refuse') }}",{ids:[data.id],desc:value},function (result) {
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
                        layer.prompt({
                            formType: 2,
                            value: 'ok,审核通过...',
                            title: '审核通过备注',
                            area: ['60', '50']
                        }, function(value, index){

                            $.post("{{ route('admin.userhead.send') }}",{id:data.id,desc:value},function (result) {
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