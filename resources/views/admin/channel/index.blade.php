@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('config.channel.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                @endcan
                @can('config.channel.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.channel.create') }}">添加</a>
                @endcan
                {{--<button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>--}}
            </div>
            {{--<div class="layui-form" >--}}
                {{--<div class="layui-input-inline">--}}
                    {{--<input type="text" name="title" id="title" placeholder="请输入标题" class="layui-input">--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.channel.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('config.channel.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>

            {{--<script type="text/html" id="thumb">--}}
                {{--<a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>--}}
            {{--</script>--}}
            <script type="text/html" id="pic_one">
                <a href="@{{d.pic_one_img}}" target="_blank" title="点击查看"><img src="@{{d.pic_one_img}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="pic_two">
                <a href="@{{d.pic_two_img}}" target="_blank" title="点击查看"><img src="@{{d.pic_two_img}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="pic_three">
                <a href="@{{d.pic_three_img}}" target="_blank" title="点击查看"><img src="@{{d.pic_three_img}}" alt="" width="28" height="28"></a>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('config.channel')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.channel.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'channel', title: '渠道名'}
                        ,{field: 'channel_key', title: 'KEY'}
                        ,{field: 'pic_one_img', title: '图片一',toolbar:'#pic_one',align: 'center'}
                        ,{field: 'pic_two_img', title: '图片二',toolbar:'#pic_two',align: 'center'}
                        ,{field: 'pic_three_img', title: '图片三',toolbar:'#pic_three',align: 'center'}
                        ,{field: 'updated_at', title: '操作时间'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.channel.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/channel/'+data.id+'/edit';
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
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.channel.destroy') }}",{_method:'delete',ids:ids},function (result) {
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
                })

                //搜索
                $("#searchBtn").click(function () {
                    var positionId = $("#position_id").val()
                    var title = $("#title").val();
                    dataTable.reload({
                        where:{position_id:positionId,title:title},
                        page:{curr:1}
                    })
                })
            })
        </script>
    @endcan
@endsection