@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>GM配置
                <div class="layui-btn-group">
                    {{--<button class="layui-btn layui-btn-sm" id="returnParent" pid="0">返回上级</button>--}}

                    @can('lead.send_personal')
                        <a class="layui-btn layui-btn-sm" id="sendBtn"
                           data-href="{{ route('admin.lead.send_personal') }}">发送到服务器配置</a>
                    @endcan

                </div>
            </h2>

        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.lead.save_personal')}}" method="post">

                {{csrf_field()}}

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">控制概率</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="control_rate" value="{{ $config['control_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label for="" class="layui-form-label">首冲返水率</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="frist_charge_rate" value="{{ $config['frist_charge_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">首冲返水权重</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="frist_charge_weight" value="{{ $config['frist_charge_weight'] or 0 }}"
                               lay-verify="required"  placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">充值返水率</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="charge_rate" value="{{ $config['charge_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">充值返水权重</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="charge_weight" value="{{ $config['charge_weight'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">兑换返水率</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="exchange_rate" value="{{ $config['exchange_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">兑换返水权重</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="exchange_weight" value="{{ $config['exchange_weight'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">新增加返水率</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="new_player_rate" value="{{ $config['new_player_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">新增加返水权重</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" name="new_player_weight" value="{{ $config['new_player_weight'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">用户引导赠送率</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="user_guide_rate" value="{{ $config['user_guide_rate'] or 0 }}"
                               lay-verify="required" placeholder="请输入" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">用户引导权重</label>
                    <div class="layui-input-block">
                        <input type="number" min="0" max="10000" name="user_guide_weight" value="{{ $config['user_guide_weight'] or 0 }}"
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
    @can('lead.personal')
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