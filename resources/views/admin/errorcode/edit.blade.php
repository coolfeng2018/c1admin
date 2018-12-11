@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.errorcode.update',['id'=>$errorCode->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.errorcode._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.errorcode._js')
@endsection