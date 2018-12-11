{{csrf_field()}}

<div class="layui-form-item" id="uid">
    <label for="" class="layui-form-label">ID</label>
    <div class="layui-input-block">
        <input type="number" name="uid" value="{{$data['uid'] or ''}}" @if(isset($data['uid'])) style="background: #F0F0F0" disabled @endif  width="60" lay-verify="required" placeholder=" " class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">控制金额</label>
    <div class="layui-input-block">
        <input type="number" name="amount" value="{{$data['control_amount'] or ''}}" width="60" lay-verify="required" placeholder="" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">权重值</label>
    <div class="layui-input-block">
        <input type="number" name="weights" value="{{$data['weights'] or ''}}" lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="form">确定</button>
    </div>
</div>
