@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>兑换信息编辑</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.version.update',['id'=>$data['id']])}}" method="post">
                @include('admin.version._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.version._js')
@endsection