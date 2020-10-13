layui.define('common',function (exports) {
    var $ = layui.$
        ,common = layui.common
        ,module = common.module;
    $("input[name='icon']").change(function(){
        alert("文本已被修改");
    });
    exports(module);
})
