//一般直接写在一个js文件中
layui.define(['layer', 'form','common'], function(exports){
    var layer = layui.layer
        ,form = layui.form
        ,$ = layui.$
        ,common = layui.common;

    common.reqCallback = function (res) {
        if (!res.hasOwnProperty('returnCode')) {
            this.successMsg('参数错误！');
            return false;
        }
        if (res.returnCode == 200) {
            location.href=$(this.fromBtnElem).data('href');
        } else {
            this.errorMsg(res.msg);
        }
    }

    exports('admin/login');
});
