<?php /*a:2:{s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\index\index.html";i:1601198729;s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\common\base.html";i:1601191666;}*/ ?>
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



<div class="layui-layout layui-layout-admin">

    <!-- 头部 -->
    <div class="layui-header">
        <ul class="layui-nav layui-layout-left">

            <li class="layui-nav-item left-open layui-nav-li">
                <a href="javascript:;" title="侧边伸缩">
                    <i class="layui-icon layui-icon-shrink-right" style="color: #333;font-size: 16px;"></i>
                </a>
            </li>

            <li class="layui-nav-item refresh layui-nav-li">
                <a href="javascript:;" title="侧边伸缩">
                    <i class="layui-icon layui-icon-refresh-3" style="color: #333;font-size: 16px;"></i>
                </a>
            </li>

        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="/static/admin/img/avatar.jpg" class="layui-nav-img">
                    Carlos
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="<?php echo url('admin/admin/loginOut'); ?>">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <!-- 页面 -->
    <div class="layui-tab layui-admin-tab" lay-allowClose="true" lay-filter="layui-admin-tab-header">
        <ul class="layui-tab-title" id="ADMIN_APP_TABS">
            <li lay-id="home" class=""><i class="layui-icon layui-icon-home"></i></li>
        </ul>
    </div>

    <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black layui-side-menu">
        <div class="layui-side-scroll">

            <!--后台logo-->
            <div class="layui-logo">
                <span>Admin</span>
            </div>


            <!-- 左侧导航区域-->
            <ul class="layui-nav layui-nav-tree left-nav">
                <?php foreach($menus as $mkey => $mval): ?>
                <li class="layui-nav-item left-nav-li">
                    <a data-layid="<?php echo htmlentities($mval['id']); ?>" data-is-href="<?php if(!isset($mval['sub'])): ?>1<?php endif; ?>" data-url="<?php if(!empty($mval['url'])): ?><?php echo url($mval['url']); ?><?php endif; ?>" class="" href="javascript:;">
                        <i lay-tips="<?php echo htmlentities($mval['title']); ?>" class="<?php echo htmlentities($mval['icon']); ?>"></i>
                        <cite><?php echo htmlentities($mval['title']); ?></cite>
                        <?php if(isset($mval['sub'])): ?>
                        <span class="layui-nav-more"></span>
                        <?php endif; ?>
                    </a>
                    <?php if(isset($mval['sub'])): ?>
                        <dl class="layui-nav-child">
                        <?php foreach($mval['sub'] as $skey => $sval): ?>
                            <dd>
                                <a data-layid="<?php echo htmlentities($sval['id']); ?>" data-is-href="<?php if(!isset($sval['sub'])): ?>1<?php endif; ?>" data-url="<?php if(!empty($sval['url'])): ?><?php echo url($sval['url']); ?><?php endif; ?>" href="javascript:;" >
                                    <?php echo htmlentities($sval['title']); if(isset($sval['sub'])): ?>
                                    <span class="layui-nav-more"></span>
                                    <?php endif; ?>
                                </a>
                                <?php if(isset($sval['sub'])): ?>
                                <dl class="layui-nav-child">
                                    <?php foreach($sval['sub'] as $sskey => $ssval): ?>
                                    <dd>
                                        <a style="padding-left: 60px;" data-is-href="<?php if(!isset($ssval['sub'])): ?>1<?php endif; ?>" data-layid="<?php echo htmlentities($ssval['id']); ?>" data-url="<?php if(!empty($ssval['url'])): ?><?php echo url($ssval['url']); ?><?php endif; ?>" href="javascript:;">
                                            <?php echo htmlentities($ssval['title']); if(isset($ssval['sub'])): ?>
                                            <span class="layui-nav-more"></span>
                                            <?php endif; ?>
                                        </a>
                                    </dd>
                                    <?php endforeach; ?>
                                </dl>
                                <?php endif; ?>
                            </dd>
                        <?php endforeach; ?>
                        </dl>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- 内容 -->
    <div class="layui-body" id="ADMIN-APP-BODY">
        <div class="layadmin-tabsbody-item layui-show">
            <iframe src="<?php echo url('admin/index/welcome'); ?>" class="layadmin-iframe" frameborder="0"></iframe>
        </div>
    </div>

    <!-- 底部固定区域 -->
    <div class="layui-footer">
        © layui.com - 底部固定区域
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
