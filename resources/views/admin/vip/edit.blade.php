@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.vip.update',['id'=>$advert->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.vip._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.vip._js')
@endsection