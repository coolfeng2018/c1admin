@extends('admin.base')
@section('content')
    <form class="layui-form layui-form-pane" action="{{route('admin.customer.reback',['uid'=>$uid,'id'=>$id])}}" method="post">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">客服回复</label>
            <div class="layui-input-block">
                <textarea name="reback" placeholder="请输入回复信息" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <a type="submit" class="layui-btn layui-btn-danger layui-btn-sm" lay-submit="" lay-filter="formDemo">回 复</a>
        </div>
    </form>
    <fieldset class="layui-elem-field layui-field-title">
        <ul class="layui-timeline">
            @if(!empty($msgList))
                @foreach($msgList as $key => $item)
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                            <span class="layui-timeline-title">
                                {{$item['FromUid'] or ''}}
                                <span class="layui-badge">{{$item['FromUidStr'] or ''}}</span>
                                <span class="layui-badge layui-bg-black">回复</span>
                                <span class="layui-badge">{{$item['ToUidStr'] or ''}}</span>
                                {{$item['ToUid'] or ''}}
                                &nbsp;&nbsp; {{$item['time'] or ''}}
                            </span>
                            <p>
                                &nbsp;&nbsp;&nbsp;&nbsp;{{$item['message'] or ''}}
                            </p>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </fieldset>
@endsection
@section('script')
    @include('admin.operate.customer._js')
@endsection

