<script>
    layui.use(['layer', 'upload', 'form','laydate','element'], function () {
        var upload = layui.upload;
        var form = layui.form;
        var laydate = layui.laydate;
        layer = layui.layer;


        var $ = layui.jquery,element = layui.element;

        form.on('radio(radio)', function(){
            if ($(this).val()){
                $(this).nextAll('textarea').val($(this).val());
                $(this).nextAll('textarea').css('display','none');
            }else {
                $(this).nextAll('textarea').css('display','');
            }
        });

        //开始日期
        laydate.render({
            elem: '#release_time'
            ,type:'datetime'
            , format: 'yyyy-MM-dd H:m:s'
        });
        $("#selectFile").click(function(){
            document.getElementById("file").click();
        });
        $("#file").change(function(){
            //var index = layer.load(1, {shade: false});
            var formData = new FormData();
            formData.append("file", document.getElementById("file").files[0]);
            document.getElementById('filename').innerHTML = document.getElementById("file").files[0].name;
            $("#progress").show();
            $.ajax({
                url: '{{ route("admin.version.upload")}}',
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                cache: false,
                xhr: function () {
                    myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function (e) {
                            if (e.lengthComputable) {
                                var percent = Math.floor(e.loaded / e.total * 100);
                                //切换
                                element.progress('progress', percent-10 +'%');
                            }
                        }, false);
                    }
                    return myXhr;
                },

                success: function (rest) {
                    var rest = JSON.parse(rest);
                   //console.log(rest);
                    //var count = Object.keys(json).length;
                    if (rest.code==0){
                        var channel = [];
                        var list = {};
                        element.progress('progress', 100+'%');
                        for (var i in rest.data.list){
                           list[i] = '';
                            for(var j in rest.data.list[i]){
                                list[i] += rest.data.list[i][j].gameCode+'项目配置地址 :' +rest.data.list[i][j].resources_url+'/'+rest.data.list[i][j].manifest_res +'<br>';
                            }
                            $("#"+i).html(list[i]);
                        }
                        setTimeout(function(){$("#progress").hide()}, 200);
                        $("#configDownUrl").css('display','');
                        $("#submit").css('display','');
                        $("#version_num").val(rest.data.version);
                        $("#game_info").val(JSON.stringify(rest.data.list));

                    }else{
                        //layer.close(index);

                        layer.msg(rest.msg);
                        return false;
                    }

                    //layer.close(index);
                }
            });
        });

        form.on('select(update_type)', function (data) {
            if (data.value == 1){
                $("#addres").css('display','none');
                $("#upload").css('display','');
                $("#submit").css('display','none');
            } else {
                $("#addres").css('display','');
                $("#upload").css('display','none');
                $("#submit").css('display','');
            }

        });


        form.on('checkbox(client)', function(){
            var client=''
            $("input:checkbox[name='client_num']:checked").each(function() {
                client += ',' + $(this).val();
            });
            $("#client").val(client.slice(1));
        });

    });

</script>