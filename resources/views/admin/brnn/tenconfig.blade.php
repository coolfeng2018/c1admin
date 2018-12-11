@extends('admin.base')
<style>
    .banker_rate_form_only {
        margin-top:10px;
    }
    .banker_round_form_only {
        margin-top:10px;
    }
</style>
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>百人牛牛十倍场机器人控制

                <div class="layui-btn-group">
                    @can('config.brnnten.send')
                        <a class="layui-btn layui-btn-sm" id="sendBtn"
                           data-href="{{ route('admin.brnnten.send') }}">发送到服务器配置</a>
                    @endcan
                </div>
            </h2>

        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.brnnten.store')}}" method="post">
                {{csrf_field()}}

                @foreach($brnn_field as $k=>$v)

                    <div class="layui-form-item">
                        @switch($v['name'])

                            @case('banker_rate')
                            <br>
                            {{$v['help']}}
                            <button class="layui-btn" id="banker_rate_add">
                                <i class="layui-icon">&#xe608;</i> 添加
                            </button>
                            <hr class="layui-bg-blue banker_rate">
                            <div id="banker_rate_form">
                                @if(isset($v['value']))
                                    @for ($i = 0; $i < count($v['value']['banker_rate_people_min']); $i++)
                                        <div class="layui-row banker_rate_form_only">
                                            <label for="" class="layui-form-label">人数范围:</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_rate_people_min[]" placeholder="" class="layui-input" value="{{$v['value']['banker_rate_people_min'][$i]}}" min="0">
                                            </div>
                                            <div class="layui-form-mid">-</div>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_rate_people_max[]" placeholder="0" class="layui-input" value="{{$v['value']['banker_rate_people_max'][$i]}}" min="0">
                                            </div>
                                            <label for="" class="layui-form-label">概率值:</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_rate_rate_min[]" placeholder="0" class="layui-input" value="{{$v['value']['banker_rate_rate_min'][$i]}}" min="0">
                                            </div>
                                            <label for="" class="layui-form-label">上庄人数:</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_rate_people_num_min[]" placeholder="0" class="layui-input" value="{{$v['value']['banker_rate_people_num_min'][$i]}}" min="0" max="5">
                                            </div>
                                            <div class="layui-input-inline"><button onclick="del(this);return false;" class="layui-btn layui-btn">删除</button></div>
                                        </div>
                                    @endfor

                                @else
                                    <div class="layui-row banker_rate_form_only">
                                        @foreach($v['option'] as $ok=>$ov)
                                            <label for="" class="layui-form-label">{{ $ok  }}</label>
                                            @if(isset($ov['max']))
                                                <div class="layui-input-inline">
                                                    <input type="{{$v['type']}}" name="{{$v['name']}}_{{$ov['name']}}_min[]" placeholder="0"
                                                           class="layui-input" value="{{$brnn_config['robot_change_min'] or 0}}"
                                                           @if(isset($ov['min'])) min="{{ $ov['min']}}" @endif
                                                           @if(isset($ov['max'])) max="{{ $ov['max']}}" @endif
                                                    >
                                                </div>
                                                <div class="layui-form-mid">-</div>
                                                <div class="layui-input-inline">
                                                    <input type="{{$v['type']}}" name="{{$v['name']}}_{{$ov['name']}}_max[]" placeholder="0"
                                                           class="layui-input" value="{{$brnn_config['robot_change_max'] or 0}}"
                                                           @if(isset($ov['min'])) min="{{ $ov['min']}}" @endif
                                                           @if(isset($ov['max'])) max="{{ $ov['max']}}" @endif
                                                    >
                                                </div>
                                            @else
                                                <div class="layui-input-inline">
                                                    <input type="{{$v['type']}}" name="{{$v['name']}}_{{$ov['name']}}_min[]" placeholder="0"
                                                           class="layui-input" value="{{$brnn_config['robot_change_min'] or 0}}"
                                                           @if(isset($ov['min'])) min="{{ $ov['min']}}" @endif
                                                           @if(isset($ov['max'])) max="{{ $ov['max']}}" @endif
                                                    >
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="layui-input-inline"><button onclick="del(this);return false;" class="layui-btn layui-btn">删除</button></div>
                                    </div>
                                @endif
                            </div>
                            @break

                            @case('banker_round')
                            <br>
                            {{$v['help']}}
                            <button class="layui-btn" id="banker_round_add">
                                <i class="layui-icon">&#xe608;</i> 添加
                            </button>
                            <hr class="layui-bg-orange banker_rate">
                            <div id="banker_round_form">
                                @if(isset($v['value']))
                                    @for ($i = 0; $i < count($v['value']['banker_round_coin_min']); $i++)
                                        <div class="layui-row banker_round_form_only">
                                            <label for="" class="layui-form-label">金币范围:</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_round_coin_min[]" placeholder="0" class="layui-input" value="{{$v['value']['banker_round_coin_min'][$i]}}" min="0">
                                            </div>
                                            <div class="layui-form-mid">-</div>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_round_coin_max[]" placeholder="0" class="layui-input" value="{{$v['value']['banker_round_coin_max'][$i]}}" min="0">
                                            </div>
                                            <label for="" class="layui-form-label">上庄局数:</label>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_round_round_range_min[]" placeholder="0" class="layui-input" value="{{$v['value']['banker_round_round_range_min'][$i]}}" min="0" max="100">
                                            </div>
                                            <div class="layui-form-mid">-</div>
                                            <div class="layui-input-inline">
                                                <input type="number" name="banker_round_round_range_max[]" placeholder="0" class="layui-input" value="{{$v['value']['banker_round_round_range_max'][$i]}}" min="0" max="100">
                                            </div>
                                            <div class="layui-input-inline"><button onclick="del(this);return false;" class="layui-btn layui-btn">删除</button></div>
                                        </div>
                                    @endfor
                                @else
                                    <div class="layui-row banker_round_form_only">
                                        @foreach($v['option'] as $ok=>$ov)
                                            <label for="" class="layui-form-label">{{ $ok  }}</label>
                                            @if(isset($ov['max']))
                                                <div class="layui-input-inline">
                                                    <input type="{{$v['type']}}" name="{{$v['name']}}_{{$ov['name']}}_min[]" placeholder="0"
                                                           class="layui-input" value="{{$brnn_config['robot_change_min'] or 0}}"
                                                           @if(isset($ov['min'])) min="{{ $ov['min']}}" @endif
                                                           @if(isset($ov['max'])) max="{{ $ov['max']}}" @endif
                                                    >
                                                </div>
                                                <div class="layui-form-mid">-</div>
                                                <div class="layui-input-inline">
                                                    <input type="{{$v['type']}}" name="{{$v['name']}}_{{$ov['name']}}_max[]" placeholder="0"
                                                           class="layui-input" value="{{$brnn_config['robot_change_max'] or 0}}"
                                                           @if(isset($ov['min'])) min="{{ $ov['min']}}" @endif
                                                           @if(isset($ov['max'])) max="{{ $ov['max']}}" @endif
                                                    >
                                                </div>
                                            @else
                                                <div class="layui-input-inline">
                                                    <input type="{{$v['type']}}" name="{{$v['name']}}_{{$ov['name']}}_min[]" placeholder="0"
                                                           class="layui-input" value="{{$brnn_config['robot_change_min'] or 0}}"
                                                           @if(isset($ov['min'])) min="{{ $ov['min']}}" @endif
                                                           @if(isset($ov['max'])) max="{{ $ov['max']}}" @endif
                                                    >
                                                </div>
                                            @endif
                                        @endforeach
                                            <div class="layui-input-inline"><button onclick="del(this);return false;" class="layui-btn layui-btn">删除</button></div>
                                    </div>
                                @endif
                                @break

                            @case('banker_interval')
                                <br>
                                {{$v['help']}}
                                <hr class="layui-bg-red banker_rate">
                                <label for="" class="layui-form-label">{{ $v['title']  }}</label>
                                <div class="layui-input-inline">
                                    <input type="{{$v['type']}}" name="{{$v['name']}}" placeholder="0"
                                           class="layui-input" value="{{$v['value'] or 0}}"
                                           @if(isset($v['option']['min'])) min="{{ $v['option']['min']}}" @endif
                                           @if(isset($v['option']['max'])) max="{{ $v['option']['max']}}" @endif
                                    >
                                </div>
                            </div>
                            @break

                            @case('banker_cancel')
                            <br>
                            {{$v['help']}}
                            <hr class="layui-bg-green banker_rate">
                            <label for="" class="layui-form-label">{{ $v['title']  }}</label>
                            <div class="layui-input-inline">
                                <input type="{{$v['type']}}" name="{{$v['name']}}" placeholder="0"
                                       class="layui-input" value="{{$v['value'] or 0}}"
                                       @if(isset($v['option']['min'])) min="{{ $v['option']['min']}}" @endif
                                       @if(isset($v['option']['max'])) max="{{ $v['option']['max']}}" @endif
                                >
                            </div>
                            @break


                        @endswitch

                        {{--</div>--}}

                        {{--<div class="layui-form-mid"><span class="layui-word-aux">{{$v['help']}}</span></div>--}}
                    </div>

                @endforeach


                <div class="layui-form-item">
                    <div class="layui-input-block">
                        @can('config.brnnten.send')
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        @endcan
                        {{--<a class="layui-btn" href="{{route('admin.brnn.index')}}">返 回</a>--}}
                    </div>
                </div>


            </form>
            <div id="add_form_banker_rate" hidden>
                <div class="layui-row banker_rate_form_only">
                    <label for="" class="layui-form-label">人数范围:</label>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_rate_people_min[]" placeholder="0" class="layui-input" value="0" min="0">
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_rate_people_max[]" placeholder="0" class="layui-input" value="0" min="0">
                    </div>
                    <label for="" class="layui-form-label">概率值:</label>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_rate_rate_min[]" placeholder="0" class="layui-input" value="0" min="0">
                    </div>
                    <label for="" class="layui-form-label">上庄人数:</label>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_rate_people_num_min[]" placeholder="0" class="layui-input" value="0" min="0" max="5">
                    </div>
                    <div class="layui-input-inline"><button onclick="del(this);return false;" class="layui-btn layui-btn">删除</button></div>
                </div>
            </div>
            <div id="add_form_banker_round" hidden>
                <div class="layui-row banker_round_form_only">
                    <label for="" class="layui-form-label">金币范围:</label>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_round_coin_min[]" placeholder="0" class="layui-input" value="0" min="0">
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_round_coin_max[]" placeholder="0" class="layui-input" value="0" min="0">
                    </div>
                    <label for="" class="layui-form-label">上庄局数:</label>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_round_round_range_min[]" placeholder="0" class="layui-input" value="0" min="0" max="100">
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline">
                        <input type="number" name="banker_round_round_range_max[]" placeholder="0" class="layui-input" value="0" min="0" max="100">
                    </div>
                    <div class="layui-input-inline"><button onclick="del(this);return false;" class="layui-btn layui-btn">删除</button></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['layer', 'form'], function () {
            /**
             * 牌局添加按钮
             */
            $("#banker_rate_add").click(function () {
                var content = $("#add_form_banker_rate").html();
                $("#banker_rate_form").append(content);
                return false;
            });

            /**
             * 上庄添加按钮
             */
            $("#banker_round_add").click(function () {
                var content = $("#add_form_banker_round").html();
                // content = '<div class="layui-input-block banker_round_form_only">'+content+'</div><br>';
                $("#banker_round_form").append(content);
                return false;
            });


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

        /**
         * 删除表单
         * @param obj
         */
        function del(obj){
            $(obj).parent().parent().remove();return false;
        }
    </script>
@endsection