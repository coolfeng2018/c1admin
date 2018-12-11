@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>排行榜机器人随机概率
                <div class="layui-btn-group">

                    @can('config.robot.send_rank')
                        <a class="layui-btn layui-btn-sm" id="sendBtn" data-href="{{ route('admin.robot.send_rank') }}">发送到服务端配置</a>
                    @endcan

                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.robot') }}">返回上级</a>
                </div>
            </h2>

        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.robot.rank')}}" method="post">
                {{csrf_field()}}

                @foreach($rate as $k=>$v)
                    <div class="layui-form-item">
                        <label for="" class="layui-form-label">{{strtoupper($k)}}</label>
                        <div class="layui-input-block">
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="number" min="0" name="{{$k}}" value="{{ $config[$k] or $v}}" class="layui-input" required>
                                </div>
                            </div>
                        </div>
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