@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新活动配置</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.activitypay.update',['id'=>$activityPays->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.activity.pay._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.activity.pay._js')
@endsection