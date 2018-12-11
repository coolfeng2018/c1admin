@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.version.store')}}" method="post">
                @include('admin.version._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.version._js')
@endsection