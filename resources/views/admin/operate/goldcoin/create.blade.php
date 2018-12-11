@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>修改玩家金币</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.goldcoin.store')}}" method="post">
                @include('admin.operate.goldcoin._form')
            </form>
        </div>
    </div>
@endsection

