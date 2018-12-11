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
    layui.use(['upload'],function () {
        var upload = layui.upload;

        //图片上传一
        upload.render({
            elem: '#uploadPic'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('.uploadPic').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#thumb-uploadPic").val(res.data.path);
                    $('.uploadPic li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });

        //图片上传二
        upload.render({
            elem: '#uploadPic2'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('.uploadPic2').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#thumb-uploadPic2").val(res.data.path);
                    $('.uploadPic2 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });

        //图片上传三
        upload.render({
            elem: '#uploadPic3'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('.uploadPic3').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#thumb-uploadPic3").val(res.data.path);
                    $('.uploadPic3 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });



    });
</script>
<script>
    layui.use(['element','laydate','laytpl','layer','form'],function (){
        var element = layui.element
            ,laytpl = layui.laytpl
            ,form = layui.form
            ,layer = layui.layer
            ,laydate = layui.laydate;

        element.init();
        var pic_one_type = {{$advert->pic_one_type or 5}} ;
        var pic_two_type = {{$advert->pic_two_type or 5}} ;
        var pic_three_type = {{$advert->pic_three_type or 5}} ;
        if (pic_one_type == 4)
        {
            $('#pic_one').text('跳转位置');
            document.getElementById("pic_one_url").style.display="none";
            document.getElementById("pic_one_jump").style.display="";
        }
        if (pic_two_type == 4)
        {
            $('#pic_two').text('跳转位置');
            document.getElementById("pic_two_url").style.display="none";
            document.getElementById("pic_two_jump").style.display="";
        }
        if (pic_three_type == 4)
        {
            $('#pic_three').text('跳转位置');
            document.getElementById("pic_three_url").style.display="none";
            document.getElementById("pic_three_jump").style.display="";
        }
        form.on('select(pic_one_type)', function(){
            var dd = {elem:$('select[name=pic_one_type]')} ;
            var selected =  $(dd.elem).find("option:selected");

            if (selected.val() == 4)
            {
                $('#pic_one').text('跳转位置');
                document.getElementById("pic_one_url").style.display="none";
                document.getElementById("pic_one_jump").style.display="";
            } else {
                $('#pic_one').text('URL');
                document.getElementById("pic_one_url").style.display="";
                document.getElementById("pic_one_jump").style.display="none";
            }
        });

        form.on('select(pic_two_type)', function(){
            var dd = {elem:$('select[name=pic_two_type]')} ;
            var selected =  $(dd.elem).find("option:selected");
            if (selected.val() == 4)
            {
                $('#pic_two').text('跳转位置');
                document.getElementById("pic_two_url").style.display="none";
                document.getElementById("pic_two_jump").style.display="";
            } else {
                $('#pic_two').text('URL');
                document.getElementById("pic_two_url").style.display="";
                document.getElementById("pic_two_jump").style.display="none";
            }
        });

        form.on('select(pic_three_type)', function(){
            var dd = {elem:$('select[name=pic_three_type]')} ;
            var selected =  $(dd.elem).find("option:selected");
            if (selected.val() == 4)
            {
                $('#pic_three').text('跳转位置');
                document.getElementById("pic_three_url").style.display="none";
                document.getElementById("pic_three_jump").style.display="";
            } else {
                $('#pic_three').text('URL');
                document.getElementById("pic_three_url").style.display="";
                document.getElementById("pic_three_jump").style.display="none";
            }
        });


    });
</script>
