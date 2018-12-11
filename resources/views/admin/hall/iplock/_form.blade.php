{{csrf_field()}}

<div class="layui-form-item" id="uid">
    <label for="" class="layui-form-label">被禁 ip</label>
    <div class="layui-input-block">
        <input type="hidden" name="id" value="{{$data['id'] or ''}}">
        <input type="text" name="lock_data" value="{{$data['lock_data'] or ''}}" @if(isset($data['lock_data'])) style="background: #F0F0F0" disabled @endif  width="60" lay-verify="required" placeholder=" " class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-inline">
        <select name="status" id="status" lay-verify="required" lay-filter="status">
            @foreach($type as $key => $val)
                <option value="{{$key}}" selected>{{$val}}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">备注</label>
    <div class="layui-input-block">
        <input type="text" name="memo" value="{{$data['memo'] or ''}}" lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="form">确定</button>
    </div>
</div>
