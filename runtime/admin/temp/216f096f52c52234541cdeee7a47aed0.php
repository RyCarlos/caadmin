<?php /*a:1:{s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\admin\login.html";i:1602583180;}*/ ?>
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
    <link rel="stylesheet" type="text/css" href="/static/admin/css/common.css" />

    <link rel="stylesheet" type="text/css" href="/static/admin/css/user/login.css" />
</head>
<body>
<div class="bg pos-rel">
    <div class="login-form layui-form">
        <div class="layui-form-item avatar-box">
            <div class="avatar">
                <img src="/static/admin/img/avatar.jpg" alt="">
            </div>
        </div>

        <div class="layui-form-item pos-rel">
            <label class="user-login-icon layui-icon layui-icon-username color-666"></label>
            <input type="text" name="username" value="" class="layui-input pl-38" placeholder="用户名" required lay-verify="required">
        </div>

        <div class="layui-form-item pos-rel">
            <label class="user-login-icon layui-icon layui-icon-password color-666"></label>
            <input type="password" value="" name="password" class="layui-input pl-38" placeholder="密码" required lay-verify="required">
        </div>

        <div class="layui-form-item pos-rel">
            <input type="checkbox" name="remberPass" title="记住密码"  lay-skin="primary" class="color-666">
            <a class="color-666 forget-pass" href="<?php echo url('admin/user/forgetPass'); ?>">忘记密码</a>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid bg-333" data-url="<?php echo url('admin/admin/login'); ?>" data-href="<?php echo url('admin/index/index'); ?>" data-method="post" lay-submit lay-filter="admin-ajax-form-btn">登录</button>
        </div>
    </div>
</div>


<!-- 基本库引入 -->
<script type="text/javascript" src="/static/lib/jquery.min.js"></script>
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script>
    layui.WebConfig = <?php echo json_encode($config); ?>;
    layui.config({
        base: '/static/admin/js/' //假设这是你存放拓展模块的根目录
    }).use('index');
</script>
</body>
</html>
