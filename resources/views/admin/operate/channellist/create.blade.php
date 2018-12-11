@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>渠道添加</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channellist.store')}}" method="post">
                @include('admin.operate.channellist._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.operate.channellist._js')
@endsection