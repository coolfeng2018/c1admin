<script>
    layui.use(['layer', 'upload', 'form'], function () {
        var form = layui.form;
        var layer = layui.layer;

        //表单提交
        form.on('submit(*)', function (data) {
            $.post($(data.form).attr('action'), data.field, function (result) {
                if (result['code']) {
                    layer.msg(result.msg, {icon: 6});
                    return false;
                }
                console.log(parent.layer.render);
                parent.$('#searchBtn').click();
                // parent.layui.render.reload;
                parent.layer.msg(result.msg);
                parent.layer.close(parent.layer.getFrameIndex(window.name)); //获取窗口索引
                return false;
            }, 'json');
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });

</script>