{{csrf_field()}}


<div class="layui-form-item">
    <label for="" class="layui-form-label">排序</label>
    <div class="layui-input-block">
        <input type="number" name="sort_id" value="{{$icon->sort_id ?? ''}}" lay-verify="required" autocomplete="off" placeholder="0" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">入口名称</label>
    <div class="layui-input-block">
        <select name="name_id" lay-filter="type" lay-verify="required">
            @foreach($name as $k => $v)
                <option value="{{$k}}" @if(isset($icon->name_id) && $icon->name_id == $k)) selected @endif>{{ $v }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">对应活动</label>
    <div class="layui-input-block">
        <select name="key_id" lay-filter="type" lay-verify="required">
            <option value="0" selected>永久有效</option>
            @foreach($activityData as $v)
                <option value="{{$v['id']}}" @if(isset($icon->key_id) && $icon->key_id == $v['id'])) selected @endif>{{ $v['act_name'] }}</option>
            @endforeach
        </select>
    </div>
</div>



<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.icon')}}" >返 回</a>
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