<style>
    #layui-upload-box li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    #layui-upload-box li img{
        width: 100%;
    }
    #layui-upload-box li p{
        width: 100%;
        height: 22px;
        font-size: 12px;
        position: absolute;
        left: 0;
        bottom: 0;
        line-height: 22px;
        text-align: center;
        color: #fff;
        background-color: #333;
        opacity: 0.6;
    }
    #layui-upload-box li i{
        display: block;
        width: 20px;
        height:20px;
        position: absolute;
        text-align: center;
        top: 2px;
        right:2px;
        z-index:999;
        cursor: pointer;
    }
</style>
<script>
    layui.use(['upload','laydate'],function () {
        var upload = layui.upload
            ,laydate = layui.laydate;

        //执行一个laydate实例
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

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#uploadPic'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#layui-upload-box').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });
            }
            ,done: function(res){
                if(res.code == 0){
                    $("#act_mark").val(res.data.path);
                    $('#layui-upload-box li p').text(res.msg);
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
    });
</script>