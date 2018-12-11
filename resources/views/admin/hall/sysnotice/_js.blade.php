<style>
    #layui-upload-box li {
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border: 1px solid #ddd;
    }

    #layui-upload-box li img {
        width: 100%;
    }

    #layui-upload-box li p {
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

    #layui-upload-box li i {
        display: block;
        width: 20px;
        height: 20px;
        position: absolute;
        text-align: center;
        top: 2px;
        right: 2px;
        z-index: 999;
        cursor: pointer;
    }
</style>
<script>
    layui.use(['layer', 'upload', 'form'], function () {
        var upload = layui.upload;
        var form = layui.form;

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#uploadPic'
            , url: '{{ route("uploadImg") }}'
            , multiple: false
            , data: {"_token": "{{ csrf_token() }}"}
            , before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#layui-upload-box').html('<li><img src="' + result + '" /><p>上传中</p></li>')
                });
            }
            , done: function (res) {
                console.log(res);
                //如果上传失败
                if (res.code == 0) {
                    $("#url").val(res.data.path);
                    $('#layui-upload-box li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });

    });


    $(function () {

        $("#selectType").change(function () {
            var name = $(this).find("option:selected").val();

            console.log(name) ;
        });

    });


</script>