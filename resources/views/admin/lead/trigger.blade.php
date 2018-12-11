@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>用户触发配置
                <div class="layui-btn-group">
                    {{--<button class="layui-btn layui-btn-sm" id="returnParent" pid="0">返回上级</button>--}}

                    @can('lead.send_user_trigger')
                        <a class="layui-btn layui-btn-sm" id="sendBtn"
                           data-href="{{ route('admin.lead.send_user_trigger') }}">发送到服务器配置</a>
                    @endcan

                </div>
            </h2>

        </div>
        <div class="layui-card-body">
            <form class="layui-form  layui-form-pane" action="{{route('admin.lead.save_user_trigger')}}" method="post">

                {{csrf_field()}}

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">用户引导触发百分比</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" name="trigger_rate" value="{{ $config['trigger_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">分钟/次数</label>
                    <div class="layui-input-block">
                        <input type="text" min="0" name="trigger_limit" value="{{ $config['trigger_limit'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">gm触发概率</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" name="gm_rate" value="{{ $config['gm_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">小时/次</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" name="gm_limit" value="{{ $config['gm_limit'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

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
    @can('lead.trigger')
        <script>
            layui.use(['layer'], function () {
                var layer = layui.layer;

                //发送配置
                $("#sendBtn").click(function () {

                    var _this = $(this) ;

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