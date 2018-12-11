{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label"></label>
    <div class="layui-input-inline">
        <a  class="layui-btn layui-btn-sm" href="{{route('admin.activitylist')}}" >返 回</a>
        <a type="submit" class="layui-btn layui-btn-danger layui-btn-sm" lay-submit="" lay-filter="formDemo">保 存</a>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">活动类型</label>
    <div class="layui-input-inline">
        <select name="act_type" lay-verify="required" lay-filter="act_type">
            @foreach($activesTypes as $index => $name)
                <option value="{{$index}}" {{ ($index == ($activityLists->act_type ?? 1 ) ) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">活动名称</label>
    <div class="layui-input-inline">
        <input type="hidden" name="act_id" value="{{ $activityLists->id ?? 0 }}" class="layui-input" >
        <input type="text" name="act_name" value="{{ $activityLists->act_name ?? '' }}" lay-verify="required" placeholder="活动名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">活动状态</label>
    <div class="layui-input-inline">
        <select name="status" lay-verify="required"  lay-filter="status">
            @foreach($statusArrs as $index => $statusName)
                <option value="{{$index}}" {{ ($index == ($activityLists->status ?? 0 ) ) ? 'selected' : '' }}>{{ $statusName }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">活动时间</label>
    <div class="layui-input-inline">
        <input type="text" id="start_time" lay-verify="required" name="start_time" value="{{ $activityLists->start_time ?? date("Y-m-d H:i:s") }}" placeholder="请输入开始时间" class="layui-input" >
    </div>
    <div class="layui-input-inline">
        <input type="text" id="end_time" lay-verify="required"  name="end_time" value="{{ $activityLists->end_time ?? date("Y-m-d H:i:s") }}" placeholder="请输入结束时间" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">延迟关闭</label>
    <div class="layui-input-inline">
        <input type="text" name="act_close_intertval" value="{{ $activityLists->act_close_intertval ?? 0 }}" lay-verify="required" placeholder="延迟关闭" class="layui-input" >
    </div>
    <div class="layui-form-mid"><span class="layui-word-aux">分钟  (活动时间结束后,延迟活动关闭的时间)</span></div>
</div>
<div id="sub-view"></div>