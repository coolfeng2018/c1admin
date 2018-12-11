@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新道具信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.package.update',['id'=>$data->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.package._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.package._js')
@endsection