@extends('admin.base')
@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th>玩家ID</th>
            <th>玩家昵称</th>
            <th>奖励金币</th>
        </tr>
        </thead>
        <tbody>
            @if($detail)
                @foreach($detail as $val)
                    <tr>
                        <td>{{$val['uid']}}</td>
                        <td>{{$val['nickname'] or '未知'}}</td>
                        <td>{{$val['award_coins']}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection


