<?php /*a:2:{s:67:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\auth_group\create.html";i:1601362537;s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\common\base.html";i:1601191666;}*/ ?>
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
                            父级
                        </label>
                        <div class="layui-input-block">
                            <select name="pid" lay-search>
                                <option  value="0">无</option>
                                <?php if(isset($list)): foreach($list as $lkey => $lval): ?>
                                    <option <?php if(isset($data['pid']) && $data['pid'] == $lval['id']): ?>selected<?php endif; ?> value="<?php echo htmlentities($lval['id']); ?>"><?php echo $lval['position']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            角色名称<span class="req-color">*</span>
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" value="<?php echo htmlentities((isset($data['name']) && ($data['name'] !== '')?$data['name']:'')); ?>" name="name" required lay-verify="required" placeholder="角色名称" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            权限
                        </label>
                        <div class="layui-input-block">
                            <div id="data-tree"></div>
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
                    <input id="TREE-DATA" type="hidden" value="<?php echo htmlentities(json_encode((isset($roleList) && ($roleList !== '')?$roleList:''))); ?>">

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="admin-ajax-form-frame-btn" data-url="<?php echo url('create'); ?>">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>

                </form>



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
