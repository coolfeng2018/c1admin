@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新设备号白名单</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.whiteinstall.update',['id'=>$payInfo->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.whiteinstall._form')
            </form>
        </div>
    </div>
@endsection
