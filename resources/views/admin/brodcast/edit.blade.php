@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新系统广播</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane" action="{{route('admin.brodcast.update',['id'=>$cast->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.brodcast._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
{{--    @include('admin.advert._js')--}}
@endsection