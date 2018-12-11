{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">公告标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$stopnotice->title??old('title')}}" lay-verify="required" placeholder="请输入停服公告标题" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">公告内容</label>
    <div class="layui-input-block">
        <textarea name="info" placeholder="请输入公告内容" class="layui-textarea" lay-verify="required">{{$stopnotice->info??old('info')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">公告落款</label>
    <div class="layui-input-block">
        <input type="text" name="inscribe" value="{{$stopnotice->inscribe??old('inscribe')}}" lay-verify="required" placeholder="请输入公告落款" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">通知时间</label>
    <div class="layui-input-block">
        <input type="text" name="notice_time" value="{{ $stopnotice->notice_time ?? old('notice_time') }}" lay-verify="required" placeholder="请输入通知时间" class="layui-input" >
    </div>
    <div class="layui-form-mid"><span class="layui-word-aux">格式：2018年10月20日</span></div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">开始时间</label>
    <div class="layui-input-block">
        <input type="text" id="start_time" name="start_time" value="{{ $stopnotice->start_time ?? date("Y-m-d H:i:s") }}" placeholder="请输入开始时间" lay-verify="required" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">结束时间</label>
    <div class="layui-input-block">
        <input type="text" id="end_time"  name="end_time" value="{{ $stopnotice->end_time ?? date("Y-m-d H:i:s") }}" placeholder="请输入结束时间" lay-verify="required" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.stopnotice.index')}}" >返 回</a>
    </div>
</div>
