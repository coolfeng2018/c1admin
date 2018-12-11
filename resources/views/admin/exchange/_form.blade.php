{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">支付方式</label>
    <div class="layui-input-block">
        <select name="method" lay-verify="required">
            <option value=""></option>
            @foreach($methods as $k=>$v)
                <option value="{{ $k }}"
                        @if( isset($exchange->method) &&  $k == $exchange->method) selected @endif>{{ $v }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">最小兑换金额</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="min_money" value="{{ $exchange->min_money ?? 0 }}"
               lay-verify="required|number"
               placeholder="请输入标题" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">最大兑换金额</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="max_money" value="{{ $exchange->max_money ?? 0 }}"
               lay-verify="required|number"
               placeholder="请输入数字" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">状态</label>
    <div class="layui-input-block">
        <select name="status" lay-verify="required">
            <option value="1" @if(isset($exchange->status) && $exchange->status == 1) selected @endif>上线</option>
            <option value="2" @if(isset($exchange->status) && $exchange->status == 2) selected @endif>下线</option>
        </select>
    </div>
    <div class="layui-form-mid"><span class="layui-word-aux">状态:上线、下线</span></div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">角标</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list">
                <ul id="layui-upload-box" class="layui-clear">
                    @if(!empty($exchange->thumb))
                        <li><img src="{{ $exchange->thumb }}"/>
                            <p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="thumb" id="thumb" value="{{ $exchange->thumb??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.exchange')}}">返 回</a>
    </div>
</div>