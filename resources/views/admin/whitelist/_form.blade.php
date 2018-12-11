{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">IP地址</label>
    <div class="layui-input-block">
        <input type="text" name="address" value="{{ $payInfo->address ?? '' }}" lay-verify="required" placeholder="IP地址" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">备注</label>
    <div class="layui-input-block">
        <input type="text" name="remarks" value="{{ $payInfo->remarks ?? '' }}" placeholder="请输入备注" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.whitelist')}}" >返 回</a>
    </div>
</div>