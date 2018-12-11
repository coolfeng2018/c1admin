@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新IP白名单</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.whitelist.update',['id'=>$payInfo->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.whitelist._form')
            </form>
        </div>
    </div>
@endsection
