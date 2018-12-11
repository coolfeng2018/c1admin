{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">活动名称</label>
    <div class="layui-input-block">
        <input type="text" name="act_name" value="{{ $activityPays->act_name ?? old('act_name') }}" lay-verify="required" placeholder="活动名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">活动关键字</label>
    <div class="layui-input-block">
        <input type="text" name="act_key" value="{{ $activityPays->act_key ?? old('act_key') }}" lay-verify="required" placeholder="活动关键字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">活动状态</label>
    <div class="layui-input-block">
        <select name="status" lay-verify="required">
            @foreach($statusArrs as $index => $statusName)
                <option value="{{$index}}" {{ ($index == ($activityPays->status ?? 0 ) ) ? 'selected' : '' }}>{{ $statusName }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">赠送比例</label>
    <div class="layui-input-block">
        <input type="number" name="act_point" value="{{ $activityPays->act_point ?? 0 }}" lay-verify="required|number" placeholder="请输入赠送比例" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">背景图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>背景图上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($activityPays->act_mark))
                        <li><img src="{{ $activityPays->act_mark }}" /><p>预览中</p></li>
                    @endif
                </ul>
                <input type="hidden" name="act_mark" id="act_mark" value="{{ $activityPays->act_mark ??'' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">适用于支付</label>
    <div class="layui-input-block">
        @foreach($activesArrs as $index => $active)
            <input type="checkbox" name="pay_ways[{{$index}}]" title="{{$active}}" {{ in_array($index,($activityPays->act_info['pay_ways'] ?? [])) ? 'checked' : '' }}>
        @endforeach
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">开始时间</label>
    <div class="layui-input-block">
        <input type="text" id="start_time" name="start_time" value="{{ $activityPays->start_time ?? date("Y-m-d H:i:s") }}" placeholder="请输入开始时间" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">结束时间</label>
    <div class="layui-input-block">
        <input type="text" id="end_time"  name="end_time" value="{{ $activityPays->end_time ?? date("Y-m-d H:i:s") }}" placeholder="请输入结束时间" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.activitypay')}}" >返 回</a>
    </div>
</div>