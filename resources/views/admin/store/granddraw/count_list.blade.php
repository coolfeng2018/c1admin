@extends('admin.base')
@section('content')
    <div class="layui-card">
        {{--<div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                </div>
                <div class="layui-input-inline">
                    <select id="grade" name="grade" lay-verify="required">
                        @foreach($list as $key=>$val)
                            <option value="{{$key}}" {{$key=='fruit_nomal' ? 'selected':''}}>{{$val or ''}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="search" data-href="">查找</button>
                </div>

            </div>
        </div>--}}
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
        </div>


    </div>
@endsection

@section('script')
    @can('operate.order')
        <script>
            layui.use(['layer','table','laydate'],function () {
                var table = layui.table;
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.granddraw.data_count_get') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field:  'date', title: '日期', sort: true, align: 'center', width:120}
                        ,{field: 'add_count', title: '抽奖次数', align: 'center', width:120}
                        ,{field: 'add_num', title: '抽奖人数', align: 'center', width:120}
                        ,{field: 'pay_count', title: '抽奖付费次数', align: 'center', width:140}
                        ,{field: 'free_count', title: '抽奖免费次数', align: 'center', width:140}
                        ,{field: 'count_bd', title: '领取绑定免费次数', align: 'center', width:150}
                        ,{field: 'count_vip', title: '领取VIP免费次数', align: 'center', width:150}
                        ,{field: 'count_tg', title: '领取推广免费次数', align: 'center', width:150}
                        ,{field: 'binding_count', title: '绑定人数(玩家)', align: 'center', width:150}
                        ,{field: 'binding_count_gm', title: '绑定人数(官方)', align: 'center', width:150}
                        ,{field: 'cp_count_true', title: '彩票张数(有效)', align: 'center', width:150}
                        ,{field: 'cp_count_false', title: '彩票张数(无效)', align: 'center', width:150}
                    ]]
                });

                //搜索
                $("#search").click(function () {
                    var grade = $('#grade').val();
                    dataTable.reload({
                        where:{grade:grade}
                    })
                });

            });
        </script>
    @endcan
@endsection
