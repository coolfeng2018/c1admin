@extends('admin.base')

@section('content')
    <div class="layui-row layui-col-space15">

        <div class="layui-col-md12">

            <div class="layui-row layui-col-space15">

                <div class="layui-col-md12">

                    <div class="layui-card">

                        <div class="layui-card-header">快捷方式</div>

                        <div class="layui-card-body">


                            <div class="layui-carousel layadmin-carousel layadmin-shortcut">

                                <div carousel-item>

                                    <ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs3">

                                            <a lay-href="home/homepage1.html">

                                                <i class="layui-icon layui-icon-console"></i>

                                                <cite>主页一</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="home/homepage2.html">

                                                <i class="layui-icon layui-icon-chart"></i>

                                                <cite>主页二</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="component/layer/list.html">

                                                <i class="layui-icon layui-icon-template-1"></i>

                                                <cite>弹层</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a layadmin-event="im">

                                                <i class="layui-icon layui-icon-chat"></i>

                                                <cite>聊天</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="component/progress/index.html">

                                                <i class="layui-icon layui-icon-find-fill"></i>

                                                <cite>进度条</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="app/workorder/list.html">

                                                <i class="layui-icon layui-icon-survey"></i>

                                                <cite>工单</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="user/user/list.html">

                                                <i class="layui-icon layui-icon-user"></i>

                                                <cite>用户</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/system/website.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>设置</cite>

                                            </a>

                                        </li>

                                    </ul>

                                    <ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="set/user/info.html">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>我的资料</cite>

                                            </a>

                                        </li>

                                    </ul>


                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')
    <script>
        layui.use(['index', 'console']);
    </script>
@endsection