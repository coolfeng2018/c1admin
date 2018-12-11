@extends('admin.base')
@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th> 时间 </th>
            <th> 创建类型 </th>
            <th> 个人库存变化量 </th>
            <th> 变化前个人库存值 </th>
            <th> 变化后个人库存值 </th>
            <th> 变化前权重值 </th>
            <th> 变化后权重值 </th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $val)
        <tr>
            <td>{{$val['create_at'] or ''}}</td>
            <td>{{$val['creation_type'] or ''}}</td>
            <td>{{$val['change_personal_inventory'] or ''}}</td>
            <td>{{$val['before_personal_inventory'] or ''}}</td>
            <td>{{$val['after_personal_inventory'] or ''}}</td>
            <td>{{$val['before_weights'] or ''}}</td>
            <td>{{$val['after_weights'] or ''}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection


