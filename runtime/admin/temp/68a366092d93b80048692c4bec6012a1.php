<?php /*a:2:{s:65:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\permission\edit.html";i:1600754620;s:61:"D:\phpstudy_pro\WWW\mybackend\app\admin\view\common\base.html";i:1600932612;}*/ ?>
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
                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            是否菜单
                        </label>
                        <div class="layui-input-inline">
                            <input type="radio" <?php if(isset($data['is_menu']) && $data['is_menu'] == 1): ?>checked<?php endif; ?> name="is_menu" class="layui-input" value="1" title="是">
                            <input type="radio" <?php if(isset($data['is_menu']) && $data['is_menu'] == 0): ?>checked<?php endif; ?> name="is_menu" class="layui-input" value="0" title="否">
                        </div>
                    </div>

                    <div class="layui-form-item layui-col-md6">
                        <label class="layui-form-label">
                            父级
                        </label>
                        <div class="layui-input-block">
                            <select name="pid" lay-search>
                                <option  value="">无</option>
                                <?php if(isset($menuList)): foreach($menuList as $mkey => $mval): ?>
                                <option <?php if(isset($data['pid']) && $data['pid'] == $mval['id']): ?>selected<?php endif; ?> value="<?php echo htmlentities($mval['id']); ?>"><?php echo $mval['position']; ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item layui-col-md6">
                        <label class="layui-form-label">
                            地址
                        </label>
                        <div class="layui-input-block">
                            <input type="text" value="<?php echo htmlentities((isset($data['url']) && ($data['url'] !== '')?$data['url']:'')); ?>" name="url" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            名称
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" value="<?php echo htmlentities((isset($data['title']) && ($data['title'] !== '')?$data['title']:'')); ?>" name="title" required lay-verify="required" placeholder="名称" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            图标
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" name="icon" value="<?php echo htmlentities((isset($data['icon']) && ($data['icon'] !== '')?$data['icon']:'')); ?>" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                        <span class="layui-btn layui-btn-primary">
                                <i id="icon-privew" class="<?php echo htmlentities((isset($data['icon']) && ($data['icon'] !== '')?$data['icon']:'')); ?>"></i>
                            </span>
                        <span class="layui-btn search-btn" data-url="<?php echo url('admin/icon/index'); ?>"><i class="layui-icon layui-icon-search"></i>选择图标</span>
                    </div>

                    <div class="layui-form-item layui-col-md6">
                        <label class="layui-form-label">
                            备注
                        </label>
                        <div class="layui-input-block">
                            <textarea name="remark" class="layui-textarea" rows="5"><?php echo htmlentities((isset($data['remark']) && ($data['remark'] !== '')?$data['remark']:'')); ?></textarea>
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
    layui.WebConfig = <?php echo json_encode($config); ?>;
    layui.config({
        base: '/static/admin/js/'
    }).use('index');
</script>
</body>
</html>
