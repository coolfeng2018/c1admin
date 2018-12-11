{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">显示排序</label>
    <div class="layui-input-block">
        <input type="number" name="sort_id" value="{{ $payInfo->sort_id ?? old('sort_id') }}" lay-verify="required" placeholder="显示排序" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">支付名称</label>
    <div class="layui-input-block">
        <input type="text" name="pay_name" value="{{ $payInfo->pay_name ?? old('pay_name') }}" lay-verify="required" placeholder="支付名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">支付渠道(小类)</label>
    <div class="layui-input-block">
        <input type="text" name="pay_channel" value="{{ $payInfo->pay_channel ?? old('pay_channel') }}" lay-verify="required" placeholder="支付渠道名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">支付方式(大类)</label>
    <div class="layui-input-block">
        <select name="pay_way" lay-verify="required" lay-filter="pay_way" >
            @foreach($payWaysArrs as $index => $payWay)
                <option value="{{$index}}" {{ ($index == ($payInfo->pay_way ?? '' ) ) ? 'selected' : '' }}>{{ $payWay }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item union-card-item {{ ( \App\Models\SysPayListsModel::PAY_WAY_UNIONCARD == ($payInfo->pay_way ?? '' ) ) ? '' : 'layui-hide' }} ">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>转账银行卡配置</legend>
        <div class="layui-row">
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
                <div class="layui-form-item grid-demo grid-demo-bg1">
                    <label for="" class="layui-form-label">收款人</label>
                    <div class="layui-input-inline">
                        <input type="text" name="rece_name" value="{{ $payInfo->pay_info['rece_name'] ?? old('rece_name') }}" placeholder="收款人" class="layui-input" >
                    </div>
                </div>
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
                <div class="layui-form-item grid-demo grid-demo-bg1">
                    <label for="" class="layui-form-label">卡号</label>
                    <div class="layui-input-inline">
                        <input type="text" name="rece_card_id" value="{{$payInfo->pay_info['rece_card_id'] ?? old('rece_card_id') }}" placeholder="卡号" class="layui-input" >
                    </div>
                </div>
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
                <div class="layui-form-item grid-demo grid-demo-bg1">
                    <label for="" class="layui-form-label">银行名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="rece_bank_name" value="{{ $payInfo->pay_info['rece_bank_name'] ?? old('rece_bank_name') }}" placeholder="银行名称" class="layui-input" >
                    </div>
                </div>
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
                <div class="layui-form-item grid-demo grid-demo-bg1">
                    <label for="" class="layui-form-label">银行支行</label>
                    <div class="layui-input-inline">
                        <input type="text" name="rece_bank_subname" value="{{ $payInfo->pay_info['rece_bank_subname'] ?? old('rece_bank_subname') }}" placeholder="银行支行" class="layui-input" >
                    </div>
                </div>
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
                <div class="layui-form-item grid-demo grid-demo-bg1">
                    <label for="" class="layui-form-label">付款时限</label>
                    <div class="layui-input-inline">
                        <input type="number" name="rece_time_limit" value="{{ $payInfo->pay_info['rece_time_limit'] ?? old('rece_time_limit') }}" placeholder="付款时限" class="layui-input" >
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">自定义金额</label>
    <div class="layui-input-block">
        @foreach($diysArrs as $index => $diy)
            <input type="radio"  lay-filter="is_diy" name="is_diy" value="{{$index}}" title="{{ $diy }}" {{ ($index == ($payInfo->is_diy ?? 0 ) ) ? 'checked' : '' }}>
        @endforeach
    </div>
</div>
<div class="layui-form-item diy_max {{ ( 0 == ($payInfo->is_diy ?? 0 ) ) ? 'layui-hide' : '' }}">
    <label for="" class="layui-form-label">最大自定义金额</label>
    <div class="layui-input-block">
        <input type="number" name="diy_max" value="{{ $payInfo->diy_max ?? 0 }}" placeholder="请输入最大自定义金额" class="layui-input" >
    </div>
</div>
<div class="layui-form-item diy_min {{ ( 0 == ($payInfo->is_diy ?? 0 ) ) ? 'layui-hide' : '' }}">
    <label for="" class="layui-form-label">最小自定义金额</label>
    <div class="layui-input-block">
        <input type="number" name="diy_min" value="{{ $payInfo->diy_min ?? 0 }}" placeholder="请输入最小自定义金额" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">常用充值金额</label>
    <div class="layui-input-block">
        <input type="text" name="money_list" value="{{ $payInfo->money_list ?? '' }}" lay-verify="required" placeholder="请输入充值金额" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">备注</label>
    <div class="layui-input-block">
        <input type="text" name="pay_desc" value="{{ $payInfo->pay_desc ?? 0 }}" placeholder="请输入备注" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">是否推荐</label>
    <div class="layui-input-block">
        @foreach($activitysArr as $index => $activity)
            <input type="radio" name="o_activity" value="{{$index}}" title="{{ $activity }}" {{ ($index == ($payInfo->o_activity ?? 0 ) ) ? 'checked' : '' }}>
        @endforeach
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">是否生效</label>
    <div class="layui-input-block">
        @foreach($statusArrs as $index => $status)
            <input type="radio" name="o_status" value="{{$index}}" title="{{ $status }}" {{ ($index == ($payInfo->o_status ?? 1 ) ) ? 'checked' : '' }}>
        @endforeach
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.paylists')}}" >返 回</a>
    </div>
</div>