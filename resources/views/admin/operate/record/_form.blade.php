{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">用户Id</label>
    <div class="layui-input-inline">
        <input type="text" id="uid" name="uid" value="" lay-verify="required" placeholder="请输入用户ID" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">付款方式</label>
    <div class="layui-input-inline">
        <input type="text" id="payname" name="payname" value="" placeholder="人工充值" class="layui-input" disabled="disabled">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">平台</label>
    <div class="layui-input-inline">
        <select id="channel" name="channel" lay-verify="required">
            <option value ="z" selected>请选择</option>
            <option value ="ios">ios</option>
            <option value ="window">window</option>
            <option value ="android">安卓</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">商品类型</label>
    <div class="layui-input-inline">
        <select id="product_id" value="z" name="product_id" lay-verify="required">
            <option value ="1001" selected>金币</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">数量</label>
    <div class="layui-input-inline">
        <input type="number" id="quantity" name="quantity" value="" lay-verify="required" placeholder="0" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">金额</label>
    <div class="layui-input-inline">
        <input type="number" id="amount" name="amount" value="" lay-verify="required" placeholder="0" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">购买时间</label>
    <div class="layui-input-inline">
        <input type="text"  value="{{date('Y-m-d H:i:s',time())}}" class="layui-input" disabled="disabled">
    </div>
</div>
<input type="hidden" name="pay_channel" value="gm">
<input type="hidden" name="create_time" value="{{date('Y-m-d H:i:s',time())}}">
<div class="layui-form-item">
    <div class="layui-input-inline">
        <button type="submit"  class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.order')}}" >返 回</a>
    </div>
</div>
