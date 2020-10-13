<?php /*a:2:{s:66:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\permission\index.html";i:1600932360;s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\common\base.html";i:1600932612;}*/ ?>
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

            <!--搜索-->
            <div class="layui-card-body">
                <div class="layui-form">

                    <div class="layui-inline">
                        <input class="layui-input" placeholder="输入名称" autocomplete="off">
                    </div>

                    <div class="layui-inline">
                        <input class="layui-input" placeholder="输入地址" autocomplete="off">
                    </div>

                    <button class="layui-btn layui-inline" data-type="reload">搜索</button>

                </div>
            </div>

            <!--数据列表-->
            <div class="layui-card-body">
                <table class="layui-hide" id="DATA-PAGE-TABLE"  data-url="<?php echo url('index'); ?>" lay-filter="DATA-PAGE-TABLE-FILTER" data-operate-edit="<?php echo $auth->check(); ?>" data-operate-edit=""></table>
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
    layui.WebConfig = <?php echo json_encode($config); ?>;
    layui.config({
        base: '/static/admin/js/'
    }).use('index');
</script>
</body>
</html>
