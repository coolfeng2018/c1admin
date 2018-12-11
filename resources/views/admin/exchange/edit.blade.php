@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新配置信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.exchange.update',['id'=>$exchange->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.exchange._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.exchange._js')
@endsection