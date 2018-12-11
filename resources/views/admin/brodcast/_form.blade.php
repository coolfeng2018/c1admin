{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">ID</label>
    <div class="layui-input-block">
        <input type="text" name="mid" value="{{ $cast->mid ?? old('mid') }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-block">
        <select name="type" id="type" class="layui-input" lay-verify="required">
            @foreach($types as $k=>$v)
            <option value="{{$k}}" @if (isset($cast->type) && $cast->type == $k) selected @endif> {{$v}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">游戏名称</label>
    <div class="layui-input-block">
        <input type="text" name="broad_name" value="{{ $cast->broad_name ?? old('broad_name') }}" lay-verify="required" placeholder="请输入游戏名称" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">公告信息</label>
    <div class="layui-input-block">
        <textarea name="info" placeholder="请输入公告信息" class="layui-textarea" lay-verify="required">{{$cast->info??old('info')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label" title="广播保留时间">广播保留时间</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="exit_time" value="{{ $cast->exit_time ?? old('exit_time') }}" lay-verify="required" placeholder="请输入广播保留时间 xx 秒" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">金币范围</label>
        <div class="layui-input-inline" >
            <input type="number" min="0" name="coins_range_min" placeholder="100" value="{{ $cast->coins_range_min ?? old('coins_range_min') }}"  class="layui-input">
        </div>
        <div class="layui-form-mid">-</div>
        <div class="layui-input-inline" >
            <input type="number" min="0" name="coins_range_max" placeholder="5000" value="{{ $cast->coins_range_max ?? old('coins_range_max') }}"  class="layui-input">
        </div>
        <br>
        <div class="layui-form-mid"><span class="layui-word-aux">生成的金币范围 格式： 100,5000</span></div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">时间范围</label>
        <div class="layui-input-inline" >
            <input type="number" min="0" name="time_range_min" placeholder="100" value="{{ $cast->time_range_min ?? old('time_range_min') }}"  class="layui-input">
        </div>
        <div class="layui-form-mid">-</div>
        <div class="layui-input-inline" >
            <input type="number" min="0" name="time_range_max" placeholder="5000" value="{{ $cast->time_range_max ?? old('time_range_max') }}"  class="layui-input">
        </div>
        <br>
        <div class="layui-form-mid"><span class="layui-word-aux">生成的时间范围 格式：600,1200</span></div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">触发金额</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="target_coins" value="{{ $cast->target_coins ?? old('target_coins') }}" lay-verify="required" placeholder="请输入触发金额" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">时间间隔</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="interval" value="{{ $cast->interval ?? old('interval') }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label" title="是否MOCK数据">是否MOCK数据</label>
    <div class="layui-input-block">
        <select name="is_need_fake" id="is_need_fake" class="layui-input" >
            <option value="1"  @if(isset($cast->is_need_fake) && $cast->is_need_fake == 1) selected @endif >是</option>
            <option value="0" @if(isset($cast->is_need_fake) && $cast->is_need_fake == 0) selected @endif>否</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.brodcast.index')}}" >返 回</a>
    </div>
</div>