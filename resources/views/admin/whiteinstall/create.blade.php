@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加设备号白名单</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.whiteinstall.store')}}" method="post">
                @include('admin.whiteinstall._form')
            </form>
        </div>
    </div>
@endsection
