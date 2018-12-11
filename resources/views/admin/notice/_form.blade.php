{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">公告内容</label>
    <div class="layui-input-block">
        <textarea name="info" placeholder="请输入公告内容" class="layui-textarea" lay-verify="required">{{$notice->info??old('info')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">时间间隔</label>
    <div class="layui-input-block">
        <input type="text" name="interval" value="{{ $notice->interval ?? old('name') }}" lay-verify="required" placeholder="请输入间隔时间 xx 秒" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否循环</label>
    <div class="layui-input-block">

        <select name="is_circul" id="is_circul" class="layui-input" lay-verify="required">
           <option value="1" @if(isset($notice->is_circul) && $notice->is_circul == 1) selected @endif> 是 </option>
            <option value="0" @if(isset($notice->is_circul) && $notice->is_circul == 0) selected @endif> 否 </option>
        </select>

    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">播放开始</label>
    <div class="layui-input-block">
        <input type="text" name="play_start_time" id="play_start_time" value="{{ $notice->play_end_time ?? '' }}" placeholder="请输入播放开始时间" lay-verify="required" class="layui-input" >

    </div>
    <div class="layui-form-mid"><span class="layui-word-aux">格式：2018-09-19 00:00:00</span></div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">播放结束</label>
    <div class="layui-input-block">
        <input type="text" name="play_end_time" id="play_end_time" value="{{ $notice->play_end_time ?? '' }}" placeholder="请输入播放结束时间" lay-verify="required" class="layui-input" >
    </div>
    <div class="layui-form-mid"><span class="layui-word-aux">格式：2018-09-19 00:00:00</span></div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.notice.index')}}" >返 回</a>
    </div>
</div>
