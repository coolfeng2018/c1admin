@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>渠道编辑</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channellist.update',['id'=>$channelList->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.operate.channellist._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.operate.channellist._js')
@endsection
