@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.errorcode.store')}}" method="post">
                @include('admin.errorcode._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.errorcode._js')
@endsection