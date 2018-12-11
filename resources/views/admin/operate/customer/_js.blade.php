<script>
    layui.use(['layer','form'],function () {
        var form = layui.form;
        var layer = layui.layer;
        //监听提交
        form.on('submit(formDemo)', function(data){
            var action = $(data.form).attr('action');
            if(action){
                $.post(action,data.field,function (result) {
                    if(result.code == 0){
                        layer.msg(result.msg,{icon:6});
                        window.location.href="{{route('admin.customer.send')}}"+"?id={{$id}}&uid={{$uid}}";
                    }else{
                        layer.msg(result.msg,{icon:2});
                    }
                });
            }
        });
    });
</script>