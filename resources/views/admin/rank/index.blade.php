@extends('admin.base')

@section('content')

    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-btn-group">

                <a href="{{ route('admin.rank.index', ['type'=>1]) }}"
                   class="layui-btn @if ($type == 1) layui-btn-danger @endif">今日赚金排行</a>
                <a href="{{ route('admin.rank.index', ['type'=>2]) }}"
                   class="layui-btn @if ($type == 2) layui-btn-danger @endif">今日兑换排行</a>
                <a href="{{ route('admin.rank.index', ['type'=>3]) }}"
                   class="layui-btn @if ($type == 3) layui-btn-danger @endif">今日在线排行</a>

            </div>
            {{--<div class="layui-btn-group">--}}
            {{--<button class="layui-btn layui-btn-sm" id="returnParent" pid="0">返回上级</button>--}}
            {{--</div>--}}

            {{--<div class="layui-form">

                <div class="layui-input-inline">
                    <input type="number" min="0" name="uid" id="uid" placeholder="请输入玩家ID" class="layui-input">
                </div>

                <div class="layui-input-inline">
                    <select name="date" id="date">
                        <option value="">请选择日期</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">查找</button>
                </div>
            </div>--}}

        </div>
        <div class="layui-card-body">

            <table class="layui-table">
                <colgroup>
                    <col width="150">
                    <col width="200">
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th>序号</th>
                    <th>玩家昵称</th>
                    <th>玩家ID</th>

                    @switch($type)
                        @case(1)
                        <th>今日赚金</th>
                        @break

                        @case(2)
                        <th>兑换金额</th>
                        @break

                        @case(3)
                        <th>在线时长(秒)</th>
                        @break

                    @endswitch

                    <th>充值金额(元)</th>
                    <th>排名</th>

                </tr>
                </thead>
                <tbody>

                @foreach($data as $k=>$v)
                    <tr>
                        <td>{{++$k}}</td>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['uid']}}</td>

                        <td>{{$v['value']}}</td>

                        <td>{{$v['amount'] or '0.00'}}</td>
                        <td>{{$v['rank']}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>


            {{--<table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('zixun.category')
                        <a class="layui-btn layui-btn-sm" lay-event="children">子分类</a>
                    @endcan
                    @can('zixun.category.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('zixun.category.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>--}}
        </div>
    </div>
@endsection

@section('script')
    @can('rank.index')
        <script>
            // layui.use(['layer', 'table', 'form'], function () {
            // var layer = layui.layer;
            // var form = layui.form;
            // var table = layui.table;
            //用户表格初始化
            // var dataTable = table.render({
            // elem: '#dataTable'
            {{--, height: 500--}}
            {{--, url: "{{ route('admin.rank.data') }}" //数据接口--}}
            {{--, page: true //开启分页--}}
            // , cols: [[ //表头
            //     {checkbox: true, fixed: true}
            //
            //     , {field: 'name', title: '玩家昵称', sort: true}
            //     , {field: 'uid', title: '玩家ID', sort: true}
            //     , {field: 'value', title: '今日赚金/兑换', sort: true}
            //     , {field: 'rank', title: '排名', sort: true}

            // ,{field: 'id', title: 'ID', sort: true,width:80}
            // ,{field: 'name', title: '分类名称'}
            // ,{field: 'sort', title: '排序'}
            // ,{field: 'created_at', title: '创建时间'}
            // ,{field: 'updated_at', title: '更新时间'}
            // ,{fixed: 'right', width: 320, align:'center', toolbar: '#options'}

            //     ]]
            // });

            //监听工具条
            // table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
            // var data = obj.data //获得当前行数据
            //     , layEvent = obj.event; //获得 lay-event 对应的值
            {{--if (layEvent === 'del') {--}}
            {{--layer.confirm('确认删除吗？', function (index) {--}}
            {{--$.post("{{ route('admin.category.destroy') }}", {--}}
            {{--_method: 'delete',--}}
            {{--ids: data.id--}}
            {{--}, function (result) {--}}
            {{--if (result.code == 0) {--}}
            {{--obj.del(); //删除对应行（tr）的DOM结构--}}
            {{--}--}}
            {{--layer.close(index);--}}
            {{--layer.msg(result.msg)--}}
            {{--});--}}
            {{--});--}}
            {{--} else if (layEvent === 'edit') {--}}
            {{--location.href = '/admin/category/' + data.id + '/edit';--}}
            {{--} else if (layEvent === 'children') {--}}
            {{--var pid = $("#returnParent").attr("pid");--}}
            {{--if (data.parent_id != 0) {--}}
            {{--$("#returnParent").attr("pid", pid + '_' + data.parent_id);--}}
            {{--}--}}
            {{--dataTable.reload({--}}
            {{--where: {model: "permission", parent_id: data.id},--}}
            {{--page: {curr: 1}--}}
            {{--})--}}
            {{--}--}}
            // });

            //返回上一级
            // $("#returnParent").click(function () {
            //     var pid = $(this).attr("pid");
            //     if (pid != '0') {
            //         ids = pid.split('_');
            //         parent_id = ids.pop();
            //         $(this).attr("pid", ids.join('_'));
            //     } else {
            //         parent_id = pid;
            //     }
            //     dataTable.reload({
            //         where: {model: "permission", parent_id: parent_id},
            //         page: {curr: 1}
            //     })
            // })
            // })
        </script>
    @endcan
@endsection