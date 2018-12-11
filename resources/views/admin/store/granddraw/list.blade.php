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
                    ,url: "{{ route('admin.granddraw.data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field:  'cur_index', title: '期数', sort: true, align: 'center'}
                        ,{field: 'fee_coins', title: '抽水值', align: 'center'}
                        ,{field: 'store_coins', title: '库存值', align: 'center'}
                        ,{field: 'store_system_add', title: '库存系统资助', align: 'center'}
                        ,{field: 'award_pool_coins', title: '奖金值', align: 'center'}
                        ,{field: 'award_pool_system_add', title: '奖金系统资助', align: 'center'}
                        ,{field: 'fee_store', title: '回收金币值', align: 'center'}
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
