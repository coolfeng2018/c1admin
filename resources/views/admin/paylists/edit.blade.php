@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.paylists.update',['id'=>$payInfo->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.paylists._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.paylists._js')
@endsection