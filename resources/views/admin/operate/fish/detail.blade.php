@extends('admin.base')
@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>时间</th>
            <th>子弹总价值</th>
            <th>鱼价值</th>
            <th>收支</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $val)
        <tr>
            <td>{{$val['time']}}</td>
            <td>{{$val['bullet_coins']}}</td>
            <td>{{$val['fish_coins']}}</td>
            <td>{{$val['money']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection


