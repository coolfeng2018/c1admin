@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('hall.email.create')
                <button class="layui-btn layui-btn-sm" id="add"> 写邮件 </button>
                @endcan
                @can('hall.email.send')
                <a class="layui-btn layui-btn-sm" id="send">发送邮件</a>
                @endcan
            </div>
            <div class="layui-form" >
                <div class="layui-input-inline">ID</div>
                <div class="layui-input-inline">
                    <input type="text" name="id" id="id"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">收件人</div>
                <div class="layui-input-inline">
                    <input type="text" name="range" id="range"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">标题</div>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="title"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">状态</div>
                <div class="layui-input-inline">
                    <select name="status" id="status" lay-verify="required" lay-filter="status" >
                            <option value="0" selected></option>
                            @foreach($status as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="search" data-href="">查找</button>
                </div>

            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>

            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('hall.email.edit')
                        @{{ d.receive_state ?'':
                        '<a class="layui-btn  layui-btn-sm" lay-event="edit">编辑</a>'
                        }}
                    @endcan
                        <a class="layui-btn  layui-btn-sm" lay-event="detail">详情</a>
                </div>
            </script>
            <script type="text/html" id="status">
                <div class="layui-btn-group">
                        <a class="layui-btn  layui-btn-sm" lay-event="edit">@{{$status_name}}</a>
                </div>
            </script>

        </div>


    </div>
@endsection

@section('script')
    @can('operate.order')
        <script>
            layui.use(['layer','table','laydate'],function () {
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化

                var html = $("#dataTable").html();
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.email.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                         {field: 'id', title: '日记序号', sort: true, align: 'center'}
                        ,{field: 'create_at', title: '时间', align: 'center'}
                        ,{field: 'op_user', title: '操作人', align: 'center'}
                        ,{field: 'range', title: '收件人', align: 'center'}
                        ,{field: 'title', title: '邮件标题', align: 'center'}
                        ,{field: 'coins', title: '邮件道具(金币)', align: 'center'}
                        ,{field: 'status_name', title: '邮件状态', align: 'center'}
                        ,{field: '', title: '操作', align: 'right', toolbar: '#options'}
                    ]]
                });
                var search = {
                    submit: function () {
                        var id = $('#id').val();
                        var range = $("#range").val();
                        var title = $("#title").val();
                        var status = $("#status").val();
                        dataTable.reload({
                            where:{id:id,range:range,title:title,status:status},
                            page:{curr:1}
                        })
                    }
                };
                //监听工具条
                table.on('tool(dataTable)', function(obj){   //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data                      //获得当前行数据
                        ,layEvent    = obj.event;            //获得 lay-event 对应的值
                        var uid      = data.id;
                        // var stime = $("#stime").val();
                        // var etime = $("#etime").val();

                        if (layEvent =='detail'){
                            var index = layer.open({
                                title: '邮件详情',
                                type: 2,
                                skin: 'layui-layer-rim',  //加上边框
                                area: ['60%', '60%'],    //宽高
                                content: "email/detail?id="+uid,
                                shadeClose: true,       //点击遮罩关闭
                            });
                        }else if(layEvent == 'edit'){
                            var index = layer.open({
                                title: '编辑',
                                type: 2,
                                skin: 'layui-layer-rim', //加上边框
                                area: ['60%', '60%'],    //宽高
                                content: "email/edit?id="+uid,
                                shadeClose: true,       //点击遮罩关闭
                                end:function(){
                                    //location.reload()
                                    search.submit();
                                }
                            });
                        }
                });

                $("#add").click(function(){
                    var index = layer.open({
                        title: '记录',
                        type: 2,
                        skin: 'layui-layer-rim',  //加上边框
                        area: ['60%', '60%'],    //宽高
                        content: "email/create",
                        shadeClose: true,       //点击遮罩关闭
                    });
                });


                $("#send").click(function(){
                    $.post("{{route('admin.email.send')}}",{},function (result) {
                        if(result.code==0){
                            layer.msg(result.msg,{icon:1});
                            // setTimeout(function(){
                            //     var index = parent.layer.getFrameIndex(window.name);
                            //     parent.layer.close(index);
                            // },2000);
                        }else {
                            layer.msg(result.msg,{icon:2});
                        }
                       // layer.close(index);
                    });
                });


                //搜索
                $("#search").click(function () {
                    search.submit();
                });
            });

        </script>
    @endcan
@endsection
