<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <hr class="layui-bg-orange">
    <legend>{{$param['act_text'] or ''}}-(额外配置)</legend>

    <div class="layui-row layui-form-item">
        <div class="layui-col-md12">
            <label for="" class="layui-form-label">双倍积分</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="double_start_time" name="double_start_time" value="{{ $activityLists['double_start_time'] ?? date('H:i:s') }}" lay-verify="required" placeholder="开始时间"  >
            </div>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="double_end_time" name="double_end_time" value="{{ $activityLists['double_end_time'] ??  date('H:i:s') }}" lay-verify="required" placeholder="结束时间"  >
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">双倍积分时间</span></div>
        </div>
    </div>

    <div class="layui-row layui-form-item">
        <div class="layui-col-md3">
            <label for="" class="layui-form-label">赠送次数</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" id="bind_add_count" name="bind_add_count" value="{{ $activityLists['bind_add_count'] ?? 0 }}" placeholder="绑定赠送次数" class="layui-input" >
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">次</span></div>
        </div>
        <div class="layui-col-md3">
            <label for="" class="layui-form-label">赠送门槛</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" id="bind_condition"  name="bind_condition" value="{{ $activityLists['bind_condition'] ?? 0 }}" placeholder="绑定赠送门槛" class="layui-input" >
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">金币(分)</span></div>
        </div>
    </div>

    <div class="layui-row layui-form-item">
        <div class="layui-col-md3">
            <label for="" class="layui-form-label">推广赠送</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" id="advert_add_count" name="advert_add_count" value="{{ $activityLists['advert_add_count'] ?? 0 }}" placeholder="推广赠送次数" class="layui-input" >
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">次</span></div>
        </div>
        <div class="layui-col-md3">
            <label for="" class="layui-form-label">推广门槛</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" id="advert_condition"  name="advert_condition" value="{{ $activityLists['advert_condition'] ?? 0 }}" placeholder="推广达标门槛" class="layui-input" >
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">次</span></div>
        </div>
    </div>

    <div class="layui-row layui-form-item">
        <div class="layui-col-md3">
            <label for="" class="layui-form-label">抽奖消耗</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" id="award_cost" name="award_cost" value="{{ $activityLists['award_cost'] ?? 0 }}" placeholder="抽奖消耗" class="layui-input" >
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">金币(分)</span></div>
        </div>
        <div class="layui-col-md3">
            <label for="" class="layui-form-label">库存警报</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" id="store_warn"  name="store_warn" value="{{ $activityLists['store_warn'] ?? 0 }}" placeholder="库存警报" class="layui-input" >
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">金币(分)</span></div>
        </div>
        <div class="layui-col-md6">
            <label for="" class="layui-form-label">实时库存</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" id="store_real"  name="store_real" value="{{ $paramArr['store_real'] ?? 0 }}" placeholder="实时库存" class="layui-input" >
            </div>
            <div class="layui-input-inline">
                <a class="layui-btn layui-btn-danger layui-btn-sm" id="add_pull_new_store">设 置</a>
                <span class="layui-word-aux">金币(分) 线上库存值</span>
            </div>
        </div>
    </div>

    <div class="layui-row layui-form-item">
        <div class="layui-col-md12">
            <label for="" class="layui-form-label">时间范围</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="robot_refresh_time_min" name="robot_refresh_time_min" value="{{ $activityLists['robot_refresh_time_min'] ?? 0 }}" lay-verify="required" placeholder="最小时间">
            </div>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="robot_refresh_time_max" name="robot_refresh_time_max" value="{{ $activityLists['robot_refresh_time_max'] ?? 0 }}" lay-verify="required" placeholder="最大时间">
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">排行榜机器人刷新时间(秒)</span></div>
        </div>
    </div>

    <div class="layui-row layui-form-item">
        <div class="layui-col-md12">
            <label for="" class="layui-form-label">积分范围</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="robot_refresh_score_min" name="robot_refresh_score_min" value="{{ $activityLists['robot_refresh_score_min'] ?? 0 }}" lay-verify="required" placeholder="最小积分">
            </div>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="robot_refresh_score_max" name="robot_refresh_score_max" value="{{ $activityLists['robot_refresh_score_max'] ?? 0 }}" lay-verify="required" placeholder="最大积分">
            </div>
            <div class="layui-form-mid"><span class="layui-word-aux">排行榜机器人积分刷新增值</span></div>
        </div>
    </div>


    <div class="layui-row">
        <hr class="layui-bg-orange">
        <div class="layui-col-md10 layui-card">
            <div class="layui-card-header">
                名次/奖励配置 <a class="layui-btn layui-btn-sm" id="add_rank">添 加</a>
            </div>
            <div id="rank_item" class="layui-card-body">
                @if( isset($activityLists['rank_award']) && !empty($activityLists['rank_award']) )
                    @foreach($activityLists['rank_award'] as $index => $item)
                        <div class="layui-row layui-form-item">
                            <div class="layui-col-md6">
                                <label for="" class="layui-form-label">名次</label>
                                <div class="layui-input-inline">
                                    <input type="text" lay-verify="required" class="layui-input" id="rank_min"  name="rank_min[{{$index}}]" value="{{ $item['rank_min'] ?? '' }}" placeholder="小名次">
                                </div>
                                <div class="layui-input-inline">
                                    <input type="text" lay-verify="required" class="layui-input" id="rank_max"  name="rank_max[{{$index}}]" value="{{ $item['rank_max'] ?? '' }}" placeholder="大名次">
                                </div>
                            </div>
                            <div class="layui-col-md4">
                                <label for="" class="layui-form-label">奖励金币(分)</label>
                                <div class="layui-input-inline">
                                    <input type="text" lay-verify="required" class="layui-input" id="coins"  name="coins[{{$index}}]" value="{{ $item['coins'] ?? '' }}" placeholder="奖励金币">
                                </div>
                                <a class="layui-btn layui-btn-danger layui-btn-sm" id="del_rank">删 除</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="layui-row">
        <hr class="layui-bg-orange">
        <div class="layui-card">
            <div class="layui-card-header">
                概率配置
            </div>
            <div class="layui-card-body">
                @if(!empty($paramArr) && isset($paramArr['card_rate']))
                    @foreach($paramArr['card_rate'] as $card => $item)
                        <div class="layui-row  layui-form-item">
                            <div class="layui-col-md3">
                                <label for="" class="layui-form-label">牌值</label>
                                <div class="layui-input-inline">
                                    <input type="text" lay-verify="required" class="layui-input" name="card[{{$card}}]" value="{{ $item['card'] ?? '' }}" placeholder="牌值" >
                                </div>
                            </div>
                            <div class="layui-col-md3">
                                <label for="" class="layui-form-label">概率</label>
                                <div class="layui-input-inline">
                                    <input type="text" lay-verify="required" class="layui-input" name="rate[{{$card}}]" value="{{ $activityLists['card_rate'][$card]['rate'] ?? $item['rate'] }}" placeholder="概率值">
                                </div>
                            </div>
                            <div class="layui-col-md3">
                                <label for="" class="layui-form-label">奖励积分</label>
                                <div class="layui-input-inline">
                                    <input type="text" lay-verify="required" class="layui-input"  name="award_score[{{$card}}]" value="{{ $activityLists['card_rate'][$card]['award_score'] ?? $item['award_score'] }}" placeholder="奖励积分">
                                </div>
                            </div>
                            <div class="layui-col-md3">
                                <label for="" class="layui-form-label">奖励金币(分)</label>
                                <div class="layui-input-inline">
                                    <input type="text" lay-verify="required" class="layui-input"  name="award_coins[{{$card}}]" value="{{ $activityLists['card_rate'][$card]['award_coins'] ?? $item['award_coins'] }}" placeholder="奖励金币">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</fieldset>
{{--模板--}}
<script id="rank_item_tpl" type="text/html">
    <div class="layui-row layui-form-item">
        <div class="layui-col-md6">
            <label for="" class="layui-form-label">名次</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" class="layui-input" id="rank_min"  name="rank_min[]" value="" placeholder="小名次">
            </div>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" class="layui-input" id="rank_max"  name="rank_max[]" value="" placeholder="大名次">
            </div>
        </div>
        <div class="layui-col-md4">
            <label for="" class="layui-form-label">奖励金币(分)</label>
            <div class="layui-input-inline">
                <input type="text" lay-verify="required" class="layui-input" id="coins"  name="coins[]" value="" placeholder="奖励金币">
            </div>
            <a class="layui-btn layui-btn-danger layui-btn-sm" id="del_rank">删 除</a>
        </div>
    </div>
</script>
<script>
    layui.use(['element','laydate','laytpl','layer'],function (){
        var element = layui.element
            ,laytpl = layui.laytpl
            ,layer = layui.layer
            ,laydate = layui.laydate;

        element.init();

        laydate.render({
            elem: '#double_start_time'
            ,istime: true
            ,type: 'time'
            ,format:'HH:mm:ss'
        });

        laydate.render({
            elem: '#double_end_time'
            ,istime: true
            ,type: 'time'
            ,format:'HH:mm:ss'
        });

        $(document).on('click','#add_pull_new_store',function(){
            var store_real = $('#store_real').val();
            layer.confirm('确认设置库存值吗？', function(index){
                $.post('{{route('admin.pullnew.addstore')}}',{store:store_real},function (result) {
                    layer.close(index);
                    if(result.code == 0){
                        layer.msg(result.msg,{icon:6});
                    }else{
                        layer.msg(result.msg,{icon:2});
                    }
                });
            });
        });


        $(document).on('click','#add_rank',function(){
            laytpl($('#rank_item_tpl').html()).render({}, function(html){
                $('#rank_item').append(html);
            });
        });

        $(document).on('click','#del_rank',function(){
            $(this).parent().parent().remove();
        });
    });
</script>