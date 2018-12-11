<script>
    layui.use(['form','laydate'],function () {
        var form = layui.form;
        //支付方式
        form.on('select(pay_way)', function(data){
            if(data && data.value == 'unioncard'){
                $(".union-card-item").removeClass('layui-hide');
            }else{
                $(".union-card-item").addClass('layui-hide');
            }
            if(data && data.value == 'vip'){
                $("input[name=pay_name]").val('vip充值');
                $("input[name=pay_channel]").val('vip_channel');
            }else{
                $("input[name=pay_name]").val('');
                $("input[name=pay_channel]").val('');
            }
        });
        //自定义金额
        form.on('radio(is_diy)', function(data){
            if(data && data.value == 1){
                $(".diy_max,.diy_min").removeClass('layui-hide');
            }else{
                $(".diy_max,.diy_min").addClass('layui-hide');
            }
        });
    });
</script>