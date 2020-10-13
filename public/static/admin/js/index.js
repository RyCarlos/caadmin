var REQUEST_DOMAIN = window.location.host
    ,Config = layui.WebConfig
    ,REQUEST_API_PREFIX = 'http://'+REQUEST_DOMAIN + '/'+Config.adminModuleName+'/';

layui.define('common',function(exports){
    var common = layui.common;
    //加载公共模块
    layui.use(common.module);
    //对外输出
    exports('index');
});
