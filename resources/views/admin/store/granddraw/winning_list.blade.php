@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                </div>
                <div class="layui-input-inline">
                    <select id="grade" name="grade" lay-verify="required">
                        <option value="">请选择</option>
                        @if (!empty($select))
                        @foreach($select as $key=>$val)
                            <option value="{{$key}}" {{!empty($cur_index) && $key==$cur_index ? 'selected':''}}>{{$val or ''}}</option>
                        @endforeach
                        @endif
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
    @can('operate.granddrawwin')
        <script>
            layui.use(['layer','table','laydate'],function () {
                var table = layui.table;
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url: "{{ route('admin.granddraw.winning_data') }}" //数据接口
                    ,cellMinWidth: 80
                    ,page: false //开启分页
                    ,cols: [[ //表头
                        //{checkbox: true,fixed: true}
                        {field:  'name', title: '玩家昵称', sort: true, align: 'center'}
                        ,{field: 'uid', title: '玩家ID', align: 'center'}
                        ,{field: 'award_count', title: '中奖注数', align: 'center'}
                        ,{field: 'award_coins', title: '中奖金额', align: 'center'}
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
