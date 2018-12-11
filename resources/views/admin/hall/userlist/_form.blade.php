{{csrf_field()}}

<div class="layui-form-item" id="uid">
    <label for="" class="layui-form-label">ID</label>
    <div class="layui-input-block">
        <input type="number" name="uid" value="{{$uid or ''}}" @if(isset($uid)) style="background: #F0F0F0" disabled @endif  width="60" lay-verify="required"  class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">原因</label>
    <div class="layui-input-block">
        <input type="text" name="desc" value="" width="60" lay-verify="required" placeholder="" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">时间</label>
    <div class="layui-input-block">
        <input type="text" name="etime" id="etime" value="{{$date or ''}}" placeholder="开始日期"
               class="layui-input" readonly>    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="form">确定</button>
    </div>
</div>
