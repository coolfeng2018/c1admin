@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>用户引导配置
                <div class="layui-btn-group">
                    {{--<button class="layui-btn layui-btn-sm" id="returnParent" pid="0">返回上级</button>--}}

                    @can('lead.send_user_guide')
                        <a class="layui-btn layui-btn-sm" id="sendBtn"
                           data-href="{{ route('admin.lead.send_user_guide') }}">发送到服务器配置</a>
                    @endcan

                </div>
            </h2>

        </div>
        <div class="layui-card-body">
            <form class="layui-form  layui-form-pane" action="{{route('admin.lead.save_user_guide')}}" method="post">

                {{csrf_field()}}

                @if(count($game_list) > 0)
                    @foreach($game_list as $vv)

                        <div class="layui-form-item">
                            <label for="" class="layui-form-label">{{$vv['name']}}</label>
                            <div class="layui-input-block">
                                <select name="{{$vv['value']}}" id="{{$vv['value']}}" class="layui-input">

                                    <option>请选择</option>

                                    @foreach($game_list as $v)
                                        <option value="{{$v['value']}}" @if( isset($config[$vv['value']]) && $v['value'] == $config[$vv['value']]) selected @endif>{{$v['name']}}</option>
                                    @endforeach



                                </select>
                            </div>
                        </div>

                    @endforeach
                @else
                    服务端没有给数据呀!!!
                @endif

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
    @can('lead.index')
        <script>
            layui.use(['layer'], function () {
                var layer = layui.layer;

                //发送配置
                $("#sendBtn").click(function () {

                    var _this = $(this);

                    layer.confirm('确认发送吗？', function (index) {
                        $.post(_this.attr('data-href'), {_method: 'post'}, function (result) {
                            // if (result.code==0){
                            //     dataTable.reload()
                            // }
                            layer.close(index);
                            layer.msg(result.msg, {icon: 6})
                        });
                    })

                    // var positionId = $("#position_id").val()
                    // var title = $("#title").val();
                    // dataTable.reload({
                    //     where:{position_id:positionId,title:title}
                    // })
                });


            })
        </script>
    @endcan
@endsection