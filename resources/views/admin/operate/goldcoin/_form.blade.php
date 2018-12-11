{{csrf_field()}}


<div class="layui-form-item">
    <label for="" class="layui-form-label">玩家ID</label>
    <div class="layui-input-block">
        <input type="number" name="uid" value="{{$icon->uid ?? ''}}" lay-verify="required" autocomplete="off" placeholder="玩家ID" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">修改类型</label>
    <div class="layui-input-block">
        <select name="type" lay-filter="type" lay-verify="required">
            @foreach($typeName as $k => $v)
                <option value="{{$k}}">{{ $v }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">修改数量</label>
    <div class="layui-input-block">
        <input type="number" name="value" value="{{$icon->value ?? ''}}" lay-verify="required" autocomplete="off" placeholder="修改数量" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">备注</label>
    <div class="layui-input-block">
        <input type="text" name="remarks" value="{{$icon->remarks ?? ''}}" lay-verify="required" autocomplete="off" placeholder="备注" class="layui-input">
    </div>
</div>



<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.goldcoin')}}" >返 回</a>
    </div>
</div>

@section('script')
    <script>
        layui.use(['element','laydate','laytpl','layer','form'],function (){
            var element = layui.element
                ,laytpl = layui.laytpl
                ,form = layui.form
                ,layer = layui.layer
                ,laydate = layui.laydate;

            element.init();

            laydate.render({
                elem: '#double_start_time'
                ,istime: true
                ,type: 'time'
                ,format:'HH:mm:ss'
            });

            laydate.render({
                elem: '#double_end_time'
                ,istime: true
                ,type: 'time'
                ,format:'HH:mm:ss'
            });

        });
    </script>
@endsection