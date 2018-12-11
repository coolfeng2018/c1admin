@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>排行榜配置

                <div class="layui-btn-group">
                    @can('rank.send')
                        <a class="layui-btn layui-btn-sm" id="sendBtn"
                           data-href="{{ route('admin.rank.send') }}">发送到服务器配置</a>
                    @endcan
                </div>
            </h2>

        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.rank.store')}}" method="post">
                {{csrf_field()}}

                @foreach($rank_field as $k=>$v)

                    <div class="layui-form-item">
                        <label for="" class="layui-form-label">{{$v['title']}}</label>
                        <div class="layui-input-block">

                            @switch($v['type'])

                                @case('text')
                                <input type="{{$v['type']}}" name="{{$v['name']}}" value="{{ $v['value'] ?? old('') }}"
                                       lay-verify="required" placeholder="请输入{{$v['title']}}" class="layui-input">
                                @break

                                @case('number')
                                @if(isset($v['flag']))
                                    <div class="layui-input-inline">
                                        <input type="{{$v['type']}}" name="{{$v['name']}}_min" placeholder="0"
                                               class="layui-input" value="{{$rank_config['robot_change_min'] or 0}}"
                                               @if(isset($v['option']['min'])) min="{{ $v['option']['min']}}" @endif
                                               @if(isset($v['option']['max'])) max="{{ $v['option']['max']}}" @endif
                                        >
                                    </div>
                                    <div class="layui-form-mid">-</div>
                                    <div class="layui-input-inline">
                                        <input type="{{$v['type']}}" name="{{$v['name']}}_max" placeholder="0"
                                               class="layui-input" value="{{$rank_config['robot_change_max'] or 0}}"
                                               @if(isset($v['option']['min'])) min="{{ $v['option']['min']}}" @endif
                                               @if(isset($v['option']['max'])) max="{{ $v['option']['max']}}" @endif
                                        >
                                    </div>

                                @else
                                    <input type="{{$v['type']}}" name="{{$v['name']}}"
                                           value="{{ $v['value'] ?? old('') }}"
                                           lay-verify="required" placeholder="请输入{{$v['title']}}" class="layui-input"
                                           @if(isset($v['option']['min'])) min="{{ $v['option']['min']}}" @endif
                                           @if(isset($v['option']['max'])) max="{{ $v['option']['max']}}" @endif
                                    >

                                @endif
                                @break

                                @case('checkbox')
                                @foreach($v['option'] as $kk=>$vv)
                                    <input type="{{$v['type']}}" name="{{$v['name']}}[{{$kk}}]" title="{{$vv}}"
                                           @if(isset($v['value'][$kk]) && $v['value'][$kk] == 'on') checked @endif>
                                    <div class="layui-unselect layui-form-checkbox layui-form-checked">
                                        <span>{{$vv}}</span><i class="layui-icon layui-icon-ok"></i></div>
                                @endforeach
                                @break

                            @endswitch

                        </div>

                        <div class="layui-form-mid"><span class="layui-word-aux">{{$v['help']}}</span></div>
                    </div>

                @endforeach


                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        {{--<a class="layui-btn" href="{{route('admin.rank.index')}}">返 回</a>--}}
                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection
@section('script')
<script>
    layui.use(['layer', 'form'], function () {

        //发送配置
        $("#sendBtn").click(function () {

            var _this = $(this);

            layer.confirm('确认发送吗？', function (index) {
                $.post(_this.attr('data-href'), {_method: 'post'}, function (result) {
                    layer.close(index);
                    layer.msg(result.msg, {icon: 6})
                });
            })
        });

    });

</script>
@endsection