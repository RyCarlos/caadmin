<?php /*a:2:{s:63:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\index\welcome.html";i:1599805101;s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\common\base.html";i:1601191666;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlentities((isset($webTitle) && ($webTitle !== '')?$webTitle:'后台管理中心')); ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- css引入 -->
    <link rel="stylesheet" type="text/css" href="/static/lib/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/static/lib/awesome/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="/static/admin/css/common.css" />

    <!-- 基本库引入 -->
    <script type="text/javascript" src="/static/lib/jquery.min.js"></script>
    <script type="text/javascript" src="/static/lib/layui/layui.js"></script>
</head>

<body class="layui-layout-body">



    <div class="layui-row">
        <div class="layui-fluid">
            <div class="layui-card">
                <div class="layui-card-body">
                    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                        <legend>卡片面板</legend>
                    </fieldset>

                    <div style="padding: 20px; background-color: #F2F2F2;">
                        <div class="layui-row layui-col-space15">
                            <div class="layui-col-md6">
                                <div class="layui-card">
                                    <div class="layui-card-header">卡片面板</div>
                                    <div class="layui-card-body">
                                        卡片式面板面板通常用于非白色背景色的主体内<br>
                                        从而映衬出边框投影
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-md6">
                                <div class="layui-card">
                                    <div class="layui-card-header">卡片面板</div>
                                    <div class="layui-card-body">
                                        结合 layui 的栅格系统<br>
                                        轻松实现响应式布局
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-md12">
                                <div class="layui-card">
                                    <div class="layui-card-header">标题</div>
                                    <div class="layui-card-body">
                                        内容
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                        <legend>常规折叠面板</legend>
                    </fieldset>
                    <div class="layui-collapse" lay-filter="test">
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">为什么JS社区大量采用未发布或者未广泛支持的语言特性？</h2>
                            <div class="layui-colla-content">
                                <p>有不少其他答案说是因为JS太差。我下面的答案已经说了，这不是根本性的原因。但除此之外，我还要纠正一些对JS具体问题的误解。JS当初是被作为脚本语言设计的，所以某些问题并不是JS设计得差或者是JS设计者的失误。比如var的作用域问题，并不是“错误”，而是当时绝大部分脚本语言都是这样的，如perl/php/sh等。模块的问题也是，脚本语言几乎都没有模块/命名空间功能。弱类型、for-in之类的问题也是，只不过现在用那些老的脚本语言的人比较少，所以很多人都误以为是JS才有的坑。另外有人说JS是半残语言，满足不了开发需求，1999年就该死。半残这个嘛，就夸张了。JS虽然有很多问题，但是设计总体还是优秀的。——来自知乎@贺师俊</p>
                            </div>
                        </div>
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">为什么前端工程师多不愿意用 Bootstrap 框架？</h2>
                            <div class="layui-colla-content">
                                <p>因为不适合。如果希望开发长期的项目或者制作产品类网站，那么就需要实现特定的设计，为了在维护项目中可以方便地按设计师要求快速修改样式，肯定会逐步编写出各种业务组件、工具类，相当于为项目自行开发一套框架。——来自知乎@Kayo</p>
                            </div>
                        </div>
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">layui 更适合哪些开发者？</h2>
                            <div class="layui-colla-content">
                                <p>在前端技术快速变革的今天，layui 仍然坚持语义化的组织模式，甚至于模块理念都是采用类AMD组织形式，并非是有意与时代背道而驰。layui 认为以jQuery为核心的开发方式还没有到完全消亡的时候，而早期市面上基于jQuery的UI都普通做得差强人意，所以需要有一个新的UI去重新为这一领域注入活力，并采用一些更科学的架构方式。
                                    <br><br>
                                    因此准确地说，layui 更多是面向那些追求开发简单的前端工程师们，以及所有层次的服务端程序员。</p>
                            </div>
                        </div>
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">贤心是男是女？</h2>
                            <div class="layui-colla-content">
                                <p>man！ 所以这个问题不要再出现了。。。</p>
                            </div>
                        </div>
                    </div>

                    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
                        <legend>手风琴折叠</legend>
                    </fieldset>
                    <div class="layui-collapse" lay-accordion="">
                        <div class="layui-colla-item">
                            <div class="layui-colla-content layui-show">
                                <p>在前端技术快速变革的今天，layui 仍然坚持语义化的组织模式，甚至于模块理念都是采用类AMD组织形式，并非是有意与时代背道而驰。layui 认为以jQuery为核心的开发方式还没有到完全消亡的时候，而早期市面上基于jQuery的UI都普通做得差强人意，所以需要有一个新的UI去重新为这一领域注入活力，并采用一些更科学的架构方式。
                                    <br>
                                    因此准确地说，layui 更多是面向那些追求开发简单的前端工程师们，以及所有层次的服务端程序员。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!--状态-->
<script type="text/html" id="DATA-CELL-STATUS">
    {{# if(d.status == 1){ }}
        <button class="layui-btn layui-btn-xs">{{d.statusText?d.statusText:'正常'}}</button>
    {{# } else { }}
        <button class="layui-btn layui-btn-primary layui-btn-xs">{{d.statusText?d.statusText:'禁用'}}</button>
    {{# } }}
</script>

<!-- 基本库引入 -->
<script type="text/javascript" src="/static/lib/jquery.min.js"></script>
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script>
    layui.WebConfig = <?php echo json_encode($config); ?>;
    layui.config({
        base: '/static/admin/js/'
    }).use('index');
</script>
</body>
</html>
