@extends('admin.base')
@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th style="width: 150px">时间</th>
            <th>玩家账号</th>
            <th>玩家ID</th>
            <th>命中系数</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $val)
        <tr>
            <td>{{$val['created_at']}}</td>
            <td>{{$val['nickname']}}</td>
            <td>{{$val['uid']}}</td>
            <td>{{$val['rate']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection


