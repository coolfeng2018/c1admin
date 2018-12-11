{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">渠道名</label>
    <div class="layui-input-inline">
        <input type="text" name="channel" value="{{ $advert->channel ?? old('channel') }}" lay-verify="required" placeholder="请输入渠道名" class="layui-input" @if(isset($advert->id)) readonly @endif>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">KEY</label>
    <div class="layui-input-inline">
        <input type="text" name="channel_key" value="{{ $advert->channel_key ?? old('channel_key') }}" lay-verify="required" placeholder="请输入渠道名" class="layui-input" @if(isset($advert->id)) readonly @endif>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">图片一</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片一上传</button>
            <div class="layui-upload-list">
                <ul id="layui-upload-box" class="layui-clear uploadPic">
                    @if(isset($advert->pic_one))
                        <li><img src="{{ $advert->pic_one_img }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="pic_one" id="thumb-uploadPic" value="{{ $advert->pic_one ?? '' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">图片一类型</label>
        <div class="layui-input-inline">
            <select name="pic_one_type" id="pic_one_types" lay-verify="required" lay-search="" lay-filter="pic_one_type">
                @foreach($methods as $k=>$v)
                    <option value="{{ $k }}"
                            @if( isset($advert->pic_one_type) &&  $k == $advert->pic_one_type) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <label for="" class="layui-form-label" id="pic_one">URL</label>
        <div class="layui-input-inline" id="pic_one_url">
            <input type="text" name="pic_one_url" value="{{ $advert->pic_one_url ?? old('pic_one_url') }}" lay-verify="" placeholder="URL" class="layui-input">
        </div>
        <div class="layui-input-inline" style="display: none" id="pic_one_jump">
            <select name="pic_one_jump" id="pic_one_jumps" lay-verify="required" lay-search="" lay-filter="pic_one_jump">
                @foreach($jumpName as $k=>$v)
                    <option value="{{ $k }}"
                            @if( isset($advert->pic_one_url) &&  $k == $advert->pic_one_url) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
        </div>

    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">图片二</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic2"><i class="layui-icon">&#xe67c;</i>图片二上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear uploadPic2">
                    @if(isset($advert->pic_two))
                        <li><img src="{{ $advert->pic_two_img }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="pic_two" id="thumb-uploadPic2" value="{{ $advert->pic_two??'' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">图片二类型</label>
        <div class="layui-input-inline">
            <select name="pic_two_type" id="pic_two_types" lay-verify="required" lay-search="" lay-filter="pic_two_type">
                @foreach($methods as $k=>$v)
                    <option value="{{ $k }}"
                            @if( isset($advert->pic_two_type) &&  $k == $advert->pic_two_type) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <label for="" class="layui-form-label" id="pic_two">URL</label>
        <div class="layui-input-inline" id="pic_two_url">
            <input type="text" name="pic_two_url" value="{{ $advert->pic_two_url ?? old('pic_two_url') }}" lay-verify="" placeholder="URL" class="layui-input">
        </div>
        <div class="layui-input-inline" style="display: none" id="pic_two_jump">
            <select name="pic_two_jump" id="pic_two_jumps" lay-verify="required" lay-search="" lay-filter="pic_two_jump">
                @foreach($jumpName as $k=>$v)
                    <option value="{{ $k }}"
                            @if( isset($advert->pic_two_url) &&  $k == $advert->pic_two_url) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">图片三</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic3"><i class="layui-icon">&#xe67c;</i>图片三上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear uploadPic3">
                    @if(isset($advert->pic_three))
                        <li><img src="{{ $advert->pic_three_img }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="pic_three" id="thumb-uploadPic3" value="{{ $advert->pic_three??'' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">图片三类型</label>
        <div class="layui-input-inline">
            <select name="pic_three_type" id="pic_three_types" lay-verify="required" lay-search="" lay-filter="pic_three_type">
                @foreach($methods as $k=>$v)
                    <option value="{{ $k }}"
                            @if( isset($advert->pic_three_type) &&  $k == $advert->pic_three_type) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <label for="" class="layui-form-label" id="pic_three">URL</label>
        <div class="layui-input-inline" id="pic_three_url">
            <input type="text" name="pic_three_url" value="{{ $advert->pic_three_url ?? old('pic_three_url') }}" lay-verify="" placeholder="URL" class="layui-input">
        </div>
        <div class="layui-input-inline" style="display: none" id="pic_three_jump">
            <select name="pic_three_jump" id="pic_three_jumps" lay-verify="required" lay-search="" lay-filter="pic_three_jump">
                @foreach($jumpName as $k=>$v)
                    <option value="{{ $k }}"
                            @if( isset($advert->pic_three_url) &&  $k == $advert->pic_three_url) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.channel')}}" >返 回</a>
    </div>
</div>

