{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">位置排序</label>
    <div class="layui-input-inline">
        <input type="number" min="1" name="position" value="{{ $gameListData->position ?? 1 }}" lay-verify="required" placeholder="请输入" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">游戏</label>
    <div class="layui-input-inline">
        <select name="game_type" lay-verify="required" lay-filter="game_type">
            @foreach($gameList as $index => $name)
                <option value="{{$index}}" {{ ($name == ($gameListData->game_type ?? 1 ) ) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-inline">
        <select name="shown_type" lay-verify="required" lay-filter="shown_type">
            @foreach($shownType as $index => $name)
                <option value="{{$index}}" {{ ($name == ($gameListData->shown_type ?? 1 ) ) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">角标</label>
    <div class="layui-input-inline">
        <select name="notice_type" lay-verify="" lay-filter="notice_type">
            @foreach($noticeType as $index => $name)
                <option value="{{$index}}" {{ ($name == ($gameListData->notice_type ?? 0 ) ) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">状态</label>
    <div class="layui-input-inline">
        <select name="status" lay-verify="required" lay-filter="status">
            @foreach($status as $index => $name)
                <option value="{{$index}}" {{ ($name == ($gameListData->status ?? 0 ) ) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">是否强引导</label>
    <div class="layui-input-inline">
        <select name="guide_status" lay-verify="required" lay-filter="status">
            @foreach($guide_status as $index => $name)
                <option value="{{$index}}" {{ ($index == ($gameListData->guide_status ?? 2 ) ) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>



<input type="hidden" name="sort" value="10">
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.gamelist')}}" >返 回</a>
    </div>
</div>