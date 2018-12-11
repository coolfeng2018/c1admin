@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                </div>
                <div class="layui-input-inline">
                    <select id="grade" name="grade" lay-verify="required">
                        @foreach($list as $key=>$val)
                        <option value="{{$key}}" {{$key=='zjh_junior' ? 'selected':''}}>{{$val}}</option>
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
                    ,url: "{{ route('admin.zjhstore.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field: 'today', title: '日期', sort: true, align: 'center'}
                        ,{field: 'base_store', title: '基础库存值', align: 'center'}
                        ,{field: 'base_change', title: '基础库存变化值', align: 'center'}
                        ,{field: 'award_store', title: '奖励库存值', align: 'center'}
                        ,{field: 'award_change', title: '奖励库存变化值', align: 'center'}
                        ,{field: 'fee_store', title: '抽水', align: 'center'}
                        ,{field: 'fee_change', title: '抽水变化值\t', align: 'center',}
                        ,{field: 'rtn', title: '回收金币值\t', align: 'center',}
                    ]]
                });

                //搜索
                $("#search").click(function () {
                    var grade = $('#grade').val();
                    dataTable.reload({
                        where:{grade:grade},
                        page:{curr:1}
                    })
                });

            });
        </script>
    @endcan
@endsection
