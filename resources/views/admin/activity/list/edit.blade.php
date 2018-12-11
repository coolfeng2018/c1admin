@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h3>更新活动</h3>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.activitylist.update',['id'=>$activityLists->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.activity.list._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.activity.list._js')
@endsection