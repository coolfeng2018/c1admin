@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    玩家ID
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="uid" id="uid"  class="layui-input" value="">
                </div>
                <div class="layui-input-inline">
                    玩家账号
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="nickname" id="nickname"  class="layui-input" value="">
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
                    @can('config.fishrate.edit')
                        <a class="layui-btn  layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                        <a class="layui-btn  layui-btn-sm" lay-event="detail">记录</a>

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
                    ,url: "{{ route('admin.fishrate.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'nickname', title: '玩家账号', sort: true, align: 'center'}
                        ,{field: 'uid', title: '玩家ID', align: 'center'}
                        ,{field: 'rate', title: '命中系数', align: 'center'}
                        ,{field: '', title: '操作', align: 'center', toolbar: '#options'}
                    ]]
                });
                var search = {
                    submit: function () {
                        var nickname = $('#nickname').val();
                        var uid = $("#uid").val();
                        var stime = $("#stime").val();
                        var etime = $("#etime").val();
                        dataTable.reload({
                            where:{uid:uid,nickname:nickname,stime:stime,etime:etime},
                            page:{curr:1}
                        })
                    }
                };
                //监听工具条
                table.on('tool(dataTable)', function(obj){   //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data                      //获得当前行数据
                        ,layEvent    = obj.event;            //获得 lay-event 对应的值
                        var nickname = data.nickname;
                        var uid      = data.uid;
                        var rate     = data.rate;
                        // var stime = $("#stime").val();
                        // var etime = $("#etime").val();

                        if (layEvent == 'detail'){
                            var index = layer.open({
                                title: '记录',
                                type: 2,
                                skin: 'layui-layer-rim',  //加上边框
                                area: ['60%', '50%'],    //宽高
                                content: "fishrate/detail?uid="+uid+'&nickname='+nickname,
                                shadeClose: true,       //点击遮罩关闭
                            });
                        }else if(layEvent == 'edit'){
                            var index = layer.open({
                                title: '编辑',
                                type: 2,
                                skin: 'layui-layer-rim', //加上边框
                                area: ['30%', '50%'],    //宽高
                                content: "fishrate/edit?uid="+uid+'&nickname='+nickname+'&rate='+rate,
                                shadeClose: true,       //点击遮罩关闭
                                end:function(){
                                    //location.reload()
                                    search.submit();
                                }
                            });
                        }
                });

                //搜索
                $("#search").click(function () {
                    search.submit();
                });

                //开始日期
                laydate.render({
                    elem: '#stime'
                    , format: 'yyyy-MM-dd'
                });
                //结束日期
                laydate.render({
                    elem: '#etime'
                    , format: 'yyyy-MM-dd'
                });
            });

        </script>
    @endcan
@endsection
