@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加人工订单</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form layui-form layui-form-pane" action="{{route('admin.order.add')}}" method="post">
                @include('admin.operate.order._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    {{--@include('admin.advert._js')--}}
@endsection
















{{--
@section('script')

    @can('operate.order')

        <script type="text/javascript">
            $(function(){
                $("#save").click(function(){
                    a = beforeSave();
                    if ( ! a) {
                        return;
                    }
                    $.ajax( {
                        type : "post",
                        url : "/order/save",
                        dataType : 'json',
                        data : {'_token':'{{csrf_token()}}',uid:a.uid,channel:a.channel,amount:a.amount,pay_channel:a.pay_channel,create_time:a.create_time},
                        success : function(data) {
                            if(data.status){
                                alert('添加成功');
                                $('#goback').click();
                            }else{
                                alert('添加失败');
                            }
                        }
                    });
                });

                beforeSave = function() {
                    uid = $('#uid').val();
                    channel = $('#channel').val(); // 平台
                    amount = $('#amount').val(); // 金额
                    pay_channel = 'gm';
                    create_time = $('#create_time').val(); // 创建订单时间
                    // if (uid == '') {
                    //     alert('用户id不能为空');
                    //     return false;
                    // }
                    // if (channel == 'z') {
                    //     alert('请选择平台');
                    //     return false;
                    // }
                    // if (amount == '0' || amount == '') {
                    //     alert('金额不能为0');
                    //     return false;
                    // }
                    return {'uid':uid, 'channel':channel, 'amount':amount, 'pay_channel':pay_channel, 'create_time':create_time};
                }

                $('#uid').change(function(){
                    uid = $(this).val();
                    //if (uid.length == 6 && /^\d{6}$/.test(uid)) {
                    if (uid.length > 10 || ! /^\d+$/.test(uid)) {
                        alert("请输入10位以内数字");
                        return;
                    }
                    if (/^\d+$/.test(uid)) {
                        $.ajax( {
                            type : "post",
                            url : "/order/getUser",
                            dataType : 'json',
                            data : {'_token':'{{csrf_token()}}',uid:uid},
                            success : function(data) {
                                if(data.success){
                                    if (data.channel == 'ios' || data.channel == 'iphone') {
                                        $('#channel').val(data.channel);
                                    } else if(data.channel == 'android') {
                                        $('#channel').val(data.channel);
                                    }else {
                                        $('#channel').val('z'); // 获取不到平台
                                    }
                                } else {
                                    $('#channel').val('z'); // 获取不到平台
                                }
                                //$('#order_id').val(data.orderId);
                            }
                        });
                    } else if(uid == "") {
                        alert('用户id不能为空');
                    }
                })

                $('#amount').change(function(){
                    num = $(this).val();
                    if (/^\d+$/.test(num)) {
                        quantity = num*100;
                        $('#quantity').val(quantity);
                    } else {
                        alert('请输入纯阿拉伯数字');
                    }
                })
            })
        </script>

    @endcan
@endsection--}}
