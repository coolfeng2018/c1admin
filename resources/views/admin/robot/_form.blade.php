{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">携带金币</label>
    <div class="layui-input-block">

        {{--<input type="text" name="title" value="{{ $advert->title ?? old('name') }}" lay-verify="required" placeholder="请输入标题" class="layui-input" >--}}

        <div class="layui-inline">
            {{--<label class="layui-form-label"></label>--}}
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" min="0" name="min_coins" value="{{$advert->min_coins or 0}}" placeholder="￥" class="layui-input">
            </div>
            <div class="layui-form-mid">-</div>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" min="0" name="max_coins" value="{{$advert->max_coins or 0}}" placeholder="￥" class="layui-input">
            </div>
        </div>

        <p class="help-block">机器人携带金币(左闭右开)</p>
    </div>
</div>
@foreach($rate as $k=>$v)
    <div class="layui-form-item">
        <label for="" class="layui-form-label">{{strtoupper($k)}}</label>
        <div class="layui-input-block">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="number" min="0" name="vip_rate[{{$k}}]" value="{{ $advert->vip_rate[$k] or $v}}" class="layui-input" required>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.robot')}}" >返 回</a>
    </div>
</div>



<script id="rate_tpl" type="text/html">

</script>