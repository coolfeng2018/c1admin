{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">ID</label>
    <div class="layui-input-block">
        <input type="number" name="prop_id" value="{{ $data->prop_id or '' }}" lay-verify="required" placeholder="请道具ID" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">道具</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{ $data->name or '' }}" lay-verify="required" placeholder="请道具名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <input type="text" name="describe" value="{{ $data->describe or '' }}" lay-verify="required" placeholder="请输入描述" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">金额</label>
    <div class="layui-input-block">
        <input type="number" name="value" value="{{ $data->value or '' }}"  placeholder="金额" class="layui-input" >
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">商品类型</label>
    <div class="layui-input-block">
        <select name="type" id="selectType" class="layui-input" lay-verify="required">
            @if(!empty($type))
            @foreach($type as $key=>$val)
            <option value="{{$key}}" {{($data->type ?? 1)==$key?'selected':''}}>{{$val or ''}}</option>
            @endforeach
            @endif
        </select>
    </div>
</div>



<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($data->url))
                        <li><img src="{{$path}}{{ $data->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="url" id="url" value="{{ $data->url or '' }}">
            </div>

            {{--<div class="face">--}}
                {{--<button type="button" class="layui-btn" onclick="fileSelect();"><i class="layui-icon">&#xe67c;</i>图片上传</button>--}}
                {{--<ul id="layui-upload-box" class="layui-clear">--}}
                    {{--@if(isset($data->url))--}}
                        {{--<li><img src="{{ $data->url}}" /><p>上传成功</p></li>--}}
                    {{--@endif--}}
                {{--</ul>--}}
                {{--<input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" style="display:none;">--}}
            {{--</div>--}}


        </div>
    </div>
</div>

{{--<script type="text/javascript">--}}
    {{--function fileSelect() {--}}
        {{--document.getElementById("fileToUpload").click();--}}
    {{--}--}}
    {{--function fileSelected() {--}}
        {{--var formData = new FormData();--}}
        {{--formData.append("file", document.getElementById("fileToUpload").files[0]);--}}
        {{--$.ajax({--}}
            {{--url: '{{ route("uploadImg") }}',--}}
            {{--type: "POST",--}}
            {{--data: formData,--}}
            {{--contentType: false,--}}
            {{--processData: false,--}}
            {{--success: function (data) {--}}
                {{--console.log(data);--}}
            {{--}--}}
        {{--});--}}
    {{--}--}}
{{--</script>--}}


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.package')}}" >返 回</a>
    </div>
</div>