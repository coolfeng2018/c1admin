{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">错误码语句</label>
    <div class="layui-input-inline">
        <input type="text"  name="error_name" value="{{ $errorCode->error_name ?? '' }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">错误码</label>
    <div class="layui-input-inline">
        <input type="text" name="error_code" value="{{ $errorCode->error_code ?? '' }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<input type="hidden" name="sort" value="10">
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.errorcode')}}" >返 回</a>
    </div>
</div>