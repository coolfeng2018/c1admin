@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加配置信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane" action="{{route('admin.exchange.store')}}" method="post">
                @include('admin.exchange._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.exchange._js')
@endsection