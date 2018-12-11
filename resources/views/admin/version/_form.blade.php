{{ csrf_field() }}
<style>
    .uploadFile{width: 100%;height: 100%;background-color: #0C0C0C;position:fixed;top :0px;opacity:0.6;text-align:center;z-index:1;display: none;}
    .progress{width: 80%;margin: 25% auto;z-index:110;background-color: #3F3F3F;height: 30px;line-height: 30px;font-size: 30px;}
</style>
<div class="uploadFile" id="progress">
    <div class="layui-progress layui-progress-big progress" lay-showpercent="true" lay-filter="progress">
        <div class="layui-progress-bar" style="height: 30px;z-index:150;background-color: #5FB878;" lay-percent="0%"></div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label" style="width:90px;">允许版本更新</label>
    <div class="layui-input-block">
        <input  lay-filter="radio"  type="radio" name="version" value="*" title="所有版本" {{$data['allow_version']=='*'?'checked':''}} >
        <input  lay-filter="radio"  type="radio" name="version" value="" title="自定义" {{$data['allow_version']!='*'?'checked':''}}>
        <textarea style="{{$data['allow_version']=='*'?'display:none':''}}" name="allow_version" placeholder="请输入内容" class="layui-textarea">{{$data['allow_version'] or '*'}}</textarea>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label" style="width:90px;">允许更新渠道</label>
    <div class="layui-input-block">
        <input lay-filter="radio" type="radio" name="channel" value="*" title="所有版本" {{$data['allow_channel']=='*'?'checked':''}}>
        <input lay-filter="radio" type="radio" name="channel" value="" title="自定义" {{$data['allow_channel']!='*'?'checked':''}}>
        <textarea style="{{$data['allow_channel']=='*'?'display:none':''}}" name="allow_channel" placeholder="请输入内容" class="layui-textarea">{{$data['allow_channel'] or '*'}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label" style="width:90px;">不允许更新版本</label>
    <div class="layui-input-block">
        <input lay-filter="radio" type="radio" name="version_not" value="*" title="无" {{$data['deny_version']?'':'checked'}}>
        <input lay-filter="radio" type="radio" name="version_not" value="" title="自定义" {{$data['deny_version']?'checked':''}}>
        <textarea style="{{!$data['deny_version']?'display:none':''}}" name="deny_version" placeholder="请输入内容" class="layui-textarea">{{$data['deny_version'] or ''}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label" style="width:90px;">不允许更新渠道</label>
    <div class="layui-input-block">
        <input lay-filter="radio" type="radio" name="channel_not" value="*" title="无" {{$data['deny_channel']?'':'checked'}}>
        <input lay-filter="radio" type="radio" name="channel_not" value="" title="自定义" {{$data['deny_channel']?'checked':''}}>
        <textarea style="{{!$data['deny_channel']?'display:none':''}}" name="deny_channel" placeholder="请输入内容" class="layui-textarea">{{$data['deny_channel'] or ''}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label" style="width:90px;"> 是否公开</label>
    <div class="layui-input-block">
        <input lay-filter="radio" type="radio" name="public" value="*" title="所有人更新" {{$data['is_public']=='*'?'checked':''}}>
        <input lay-filter="radio" type="radio" name="public" value="" title="内部人更新" {{$data['is_public']!='*'?'checked':''}}>
        <textarea style="{{$data['is_public']=='*'?'display:none':''}}" name="is_public" placeholder="请输入内容" class="layui-textarea">{{$data['is_public'] or '*'}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label" style="width:90px;"> 更新状态</label>
    <div class="layui-input-block">
        <input lay-filter="radio" type="radio" name="status" value="1" title="启用" {{$data['status']=='1'?'checked':''}}>
        <input lay-filter="radio" type="radio" name="status" value="2" title="禁用" {{$data['status']=='2'?'checked':''}}>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label" style="width:90px;">更新客户端</label>
    <div class="layui-input-block">
        @if(!empty($list))
        @foreach($list as $key=>$val)
        <input type="checkbox" lay-filter="client" name="client_num" value="{{$val or ''}}" {{in_array($val,$data['channel'])?'checked':''}} title="{{$key}}">
        @endforeach
        @endif
    </div>
    <input type="hidden" id="client" name="client" value="{{$data['platform'] or '1,2,3'}}">
</div>


<div class="layui-form-item">


<label for="" class="layui-form-label">更新时间</label>
    <div class="layui-input-block">
    <input type="text" name="release_time" id="release_time" value="{{$date or ''}}" placeholder="更新日期"
    class="layui-input" readonly> </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">更新版本号</label>
    <div class="layui-input-block">
        <input type="text" name="version_num" id="version_num" value="{{$data['version'] or ''}}" lay-verify="required" placeholder="版本号"  class="layui-input"  style="background:#CCCCCC" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">更新类型</label>
    <div class="layui-input-block">
        <select name="is_force" id="is_force" lay-filter="type" class="layui-input" lay-verify="required">
            <option value="1" {{$data['is_force']==1?'selected':''}} >强更</option>
            <option value="2" {{$data['is_force']!=1?'selected':''}} >非强更</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">更新方式</label>
    <div class="layui-input-block">
        <select name="update_type" id="update_type" lay-filter="update_type" class="layui-input" lay-verify="required">
            <option value="1" {{$data['update_type']==1?'selected':''}} >热更</option>
            <option value="0" {{$data['update_type']!=1?'selected':''}} >整包更新</option>
        </select>
    </div>
</div>
<div id="addres" style="display: {{$data['update_type']==1?'none':''}}">

    <div class="layui-form-item">
        <label class="layui-form-label" style="width:90px;">备注</label>
        <div class="layui-input-block">
            <textarea name="description" placeholder="请输入内容" class="layui-textarea">{{$data['description'] or ''}}</textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label for="" class="layui-form-label">windows整包地址</label>
        <div class="layui-input-block">
            <input type="text" name="app_windows" id="app_windows" value="{{$app['windows'] or ''}}"  placeholder="URL" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">IOS整包地址</label>
        <div class="layui-input-block">
            <input type="text" name="app_ios" id="app_ios" value="{{$app['ios'] or ''}}"  placeholder="URL" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">android整包地址</label>
        <div class="layui-input-block">
            <input type="text" name="app_android" id="app_android" value="{{$app['android'] or ''}}"  placeholder="URL" class="layui-input" >
        </div>
    </div>
</div>


<div class="layui-form-item" id="upload" style="display: {{$data['update_type']!=1?'none':''}}">
    <label for="" class="layui-form-label">上传资源包</label>
    <div class="layui-input-block">
        <div class="selectfile" id="selectFile">
            <button type="button" class="layui-btn">选择文件</button>
            <span id="filename"></span>
        </div>
        <input style="display: none" type="file"  id="file" name="file" />

    </div>
</div>
<textarea id="game_info" name="game_info" style="display: none">{{$data['game_info'] or ''}}</textarea>
<div style="{{empty($data['game_info'])?'display: none':''}}" id="configDownUrl">
    <div class="layui-form-item">
        <label for="" class="layui-form-label">安卓配置</label>
        <div class="layui-input-block">
            <div id="android"  class="layui-textarea" wrap="hard">{{$str['android'] or ''}}</div>
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">ios配置</label>
        <div class="layui-input-block">
            <div id="ios"  class="layui-textarea" wrap="hard">{{$str['ios'] or ''}}</div>
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">windos配置</label>
            <div class="layui-input-block">
                <div id="windows"  class="layui-textarea" wrap="hard">{{$str['windows'] or ''}}</div>
            </div>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo" id="submit" style="{{$data['is_update']?'':'display:none'}}">确 认</button>
        <a  class="layui-btn" href="{{route('admin.version')}}" >返 回</a>
    </div>
</div>
