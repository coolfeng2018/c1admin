<script>
    layui.use(['form','laydate','laytpl'],function () {
        var laydate = layui.laydate
            ,form = layui.form
            ,laytpl = layui.laytpl;

        laydate.render({
            elem: '#start_time'
            ,istime: true
            ,type: 'datetime'
            ,format:'yyyy-MM-dd HH:mm:ss'
        });

        laydate.render({
            elem: '#end_time'
            ,istime: true
            ,type: 'datetime'
            ,format:'yyyy-MM-dd HH:mm:ss'
        });

        //监听提交
        form.on('submit(formDemo)', function(data){
            var action = $(data.form).attr('action');
            if(action){
                layer.confirm('确认保存吗？', function(index){
                    $.post(action,data.field,function (result) {
                        layer.close(index);
                        if(result.code == 0){
                           layer.msg(result.msg,{icon:6});
                           window.location.href="{{route('admin.activitylist')}}";
                        }else{
                            layer.msg(result.msg,{icon:2});
                        }
                    });
                });
            }
        });
        //活动类型变化
        loadSubForm({elem:$('select[name=act_type]')});

        form.on('select(act_type)', function(data){
            if(data){
                loadSubForm(data);
            }
        });

        /**
         * 加载子页面
         * @param data
         */
        function loadSubForm(data) {
            var selected =  $(data.elem).find("option:selected");
            var param = {act_id:$('input[name=act_id]').val(),act_type:selected.val(),act_text:selected.text()};
            $.ajax({
                url:'{{route('admin.activitylist.changesub')}}'
                ,data:param
                ,success:function (result) {
                    laytpl(result.data).render(param, function(html){
                        $('#sub-view').html(html);
                    });
                    form.render();
                }
            });
        }
    });
</script>