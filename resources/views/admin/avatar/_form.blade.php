{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">头像框ID</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="avator_id" value="{{ $advert->avator_id ?? old('avator_id') }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">头像框名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{ $advert->name ?? old('name') }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">头像框期限类型</label>
    <div class="layui-input-block">

        <select name="time_type" id="time_type" class="layui-input">
            <option value="1" @if(isset($advert->time_type) && $advert->time_type == 1) selected @endif>永久</option>
            <option value="2" @if(isset($advert->time_type) && $advert->time_type == 2) selected @endif>实时</option>
        </select>
        
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">使用期限</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="use_time" value="{{ $advert->use_time ?? old('use_time') }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">解锁条件</label>
    <div class="layui-input-block">
        <input type="text" name="condition" value="{{ $advert->condition ?? old('condition') }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">头像框样式</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($advert->icon_border_url))
                        <li><img src="{{ $advert->icon_border_url }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="icon_border_url" id="icon_border_url" value="{{ $advert->icon_border_url??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.avatar')}}" >返 回</a>
    </div>
</div>