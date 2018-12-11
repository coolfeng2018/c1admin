@extends('admin.base')
@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="80">
            <col width="120">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>玩家Id</th>
            <th>玩家昵称</th>
            <th>游戏前的金币</th>
            <th>游戏后的金币</th>
            <th>输赢金额</th>
            <th>税收</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $val)
        <tr>
            <td>{{$val['uid']}}</td>
            <td>{{$val['nickname']}}</td>
            <td>{{$val['before_score']}}</td>
            <td>{{$val['left_score']}}</td>
            <td>{{$val['add_score']}}</td>
            <td>{{$val['pay_fee']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection


