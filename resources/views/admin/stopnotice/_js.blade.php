<script>

    layui.use(['laydate'],function () {

        var laydate = layui.laydate;

        laydate.render({
            elem: '#start_time'
            ,istime: true
            ,type: 'datetime'
            //,value: new Date()
            ,format:'yyyy-MM-dd HH:mm:ss'
        });

        laydate.render({
            elem: '#end_time'
            ,istime: true
            ,type: 'datetime'
            //,value: new Date()
            ,format:'yyyy-MM-dd HH:mm:ss'
        });

    });
</script>