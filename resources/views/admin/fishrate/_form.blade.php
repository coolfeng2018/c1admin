{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">玩家账号</label>
    <div class="layui-input-inline">
        <input type="text" id="nickname" name="nickname" value="{{$nickname or ''}}" disabled  class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">玩家Id</label>
    <div class="layui-input-inline">
        <input type="text" id="uid" name="uid" value="{{$uid or ''}}" lay-verify="required" disabled class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">命中系数</label>
    <div class="layui-input-inline">
        <input type="text" id="rate" name="rate" value="{{$rate or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-inline">
        <button type="submit"  class="layui-btn" lay-submit="" lay-filter="form">确 认</button>
    </div>
</div>
