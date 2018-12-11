{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">渠道名</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{ $channelList->name ?? '' }}" lay-verify="required" placeholder="渠道名" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">渠道编号</label>
    <div class="layui-input-block">
        <input type="text" name="code" value="{{ $channelList->code ?? '' }}" placeholder="渠道编号" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit lay-filter="*">确 认</button>
    </div>
</div>