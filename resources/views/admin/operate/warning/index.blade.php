@extends('admin.base')
@section('content')
    <div class="layui-card">

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
                    ,url: "{{ route('admin.warning.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                         {field:  'time', title: '时间', sort: true, align: 'center'}
                        ,{field: 'uid', title: '角色id', align: 'center'}
                        ,{field: 'average_count', title: '每秒发包总数', align: 'center'}
                        ,{field: 'pack_count', title: '五分钟发包总数', align: 'center'}
                        ,{field: 'period_traffic_KB', title: '五分钟流量', align: 'center'}
                        ,{field: 'ip', title: 'ip', align: 'center'}
                    ]]
                });



            });
        </script>
    @endcan
@endsection
