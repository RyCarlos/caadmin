<?php /*a:2:{s:59:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\user\edit.html";i:1600845484;s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\common\base.html";i:1600844195;}*/ ?>
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



                <!--表单内容-->
                <form class="layui-form">

                    <div class="layui-form-item layui-col-md6">
                        <label class="layui-form-label">
                            所属角色
                        </label>
                        <div class="layui-input-block">
                            <div id="role"></div>
                            <input id="roleList" type="hidden" value="<?php echo htmlentities((json_encode($list) ?: '')); ?>">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            用户名
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" value="<?php echo htmlentities((isset($data['username']) && ($data['username'] !== '')?$data['username']:'')); ?>" name="username" required lay-verify="required" placeholder="用户名" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            密码
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" value="" name="password" placeholder="密码" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item layui-col-md6">
                        <label class="layui-form-label">
                            姓名
                        </label>
                        <div class="layui-input-block">
                            <input type="text" value="<?php echo htmlentities((isset($data['name']) && ($data['name'] !== '')?$data['name']:'')); ?>" name="name" required lay-verify="required" placeholder="姓名" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            邮箱
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" value="<?php echo htmlentities((isset($data['email']) && ($data['email'] !== '')?$data['email']:'')); ?>" name="email" required lay-verify="required" placeholder="名称" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" <?php if(isset($data['status']) && $data['status'] == 1): ?>checked<?php endif; ?> name="status" lay-skin="switch" lay-text="正常|禁用">
                        </div>
                    </div>

                    <!--隐藏input-->
                    <input type="hidden" name="id" value="<?php echo htmlentities((isset($data['id']) && ($data['id'] !== '')?$data['id']:'')); ?>">

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="admin-ajax-form-frame-btn" data-url="<?php echo url('edit'); ?>">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>

                </form>



            </div>
        </div>
    </div>
</div>


<!--表格左侧头部工具栏-->
<script type="text/html" id="DATA-PAGE-TABLE-TOOLBAR">
    <div class="layui-btn-container">
        <button class="layui-btn" lay-event="addData" data-title="添加" data-url="<?php echo url('create'); ?>">
            <i class="layui-icon layui-icon-add-circle"></i>添加
        </button>
        <button class="layui-btn layui-btn-danger" data-title="删除" lay-event="deleteData" data-url="<?php echo url('delete'); ?>">
            <i class="layui-icon layui-icon-delete"></i>
            删除
        </button>
    </div>
</script>

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
    layui.config({
        base: '/static/admin/js/'
    }).use('index');
</script>
</body>
</html>
