@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加{{$type_name or ''}}信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.package.store')}}" method="post">
                @include('admin.package._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.package._js')
@endsection