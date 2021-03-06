@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.paylists.store')}}" method="post">
                @include('admin.paylists._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.paylists._js')
@endsection