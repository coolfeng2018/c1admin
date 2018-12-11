{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">VIP等级</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="level" value="{{ $advert->level ?? 0 }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">特权列表</label>
    <div class="layui-input-block">

        @foreach($privilege as $k=>$v)
            <input type="checkbox" name="privilege[{{$k}}]" value="{{$k}}" title="{{$v}}" @if(isset($advert->privilege[$k])) checked @endif>
            <div class="layui-unselect layui-form-checkbox layui-form-checked">
                <span>{{$v}}</span><i class="layui-icon layui-icon-ok"></i></div>
        @endforeach

    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">所需累充金额</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="charge_coins" value="{{ $advert->charge_coins ?? 0 }}" lay-verify="required" placeholder="请输入" class="layui-input" >
        <p class="help-block">充值金额(单位是分)</p>
    </div>
</div>



<div class="layui-form-item">
    <label for="" class="layui-form-label">周福利上限</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="week_award_max" value="{{ $advert->week_award_max ?? 0 }}" lay-verify="required" placeholder="请输入" class="layui-input" >
        <p class="help-block">周福利上限(单位是分)</p>
    </div>
</div>



<div class="layui-form-item">
    <label for="" class="layui-form-label">VIP进场提示语</label>
    <div class="layui-input-block">
        <input type="text" name="enter_word" value="{{ $advert->enter_word ?? '' }}" placeholder="请输入" class="layui-input" >
        <p class="help-block">VIP进场提示语</p>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">大抽奖免费次数</label>
    <div class="layui-input-block">
        <input type="number" name="free_num" value="{{ $advert->free_num ?? 0 }}" placeholder="0" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">财神驾到触发概率加成</label>
    <div class="layui-input-block">
        <input type="number" min="0" name="caishen_base_rate" value="{{ $advert->caishen_base_rate ?? 0 }}" lay-verify="required" placeholder="请输入" class="layui-input" >
        <p class="help-block">财神驾到触发概率加成</p>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">头像框</label>
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
    <label for="" class="layui-form-label">专属炮台图片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadIcon"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box1" class="layui-clear">
                    @if(isset($advert->battery_url))
                        <li><img src="{{ $advert->battery_url }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="battery_url" id="battery_url" value="{{ $advert->battery_url??'' }}">
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="sort" value="10">
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.vip')}}" >返 回</a>
    </div>
</div>