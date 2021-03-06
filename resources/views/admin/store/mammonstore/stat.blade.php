@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                </div>
                <div class="layui-input-inline">
                    <select id="grade" name="table_type" lay-verify="required">
                        @foreach($list as $key=>$val)
                            <option value="{{$key}}" {{$key=='hhdz_normal' ? 'selected':''}}>{{$val}}</option>
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
                    ,url: "{{ route('admin.mammonstore.statdata') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field:  'days', title: '日期', sort: true, align: 'center'}
                        ,{field: 'trigger', title: '触发次数', align: 'center'}
                        ,{field: 'buy_num', title: '购买次数', align: 'center'}
                        ,{field: 'buy_usr', title: '购买人数', align: 'center'}
                        ,{field: 'award_num', title: '中奖次数', align: 'center'}
                        ,{field: 'award_usr', title: '中奖人数', align: 'center'}
                    ]]
                });

                //搜索
                $("#search").click(function () {
                    var grade = $('#grade').val();
                    dataTable.reload({
                        where:{table_type:grade}
                    })
                });

            });
        </script>
    @endcan
@endsection
