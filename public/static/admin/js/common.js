layui.define(['layer','form'],function (exports){
    var layer = layui.layer
        ,$ = layui.$
        ,form = layui.form
        ,urlPath = window.location.pathname;
    var common = {
            module:'',
            controller:'',
            fromBtnElem:{},
            reqCallback:null,
            msgTime:700,
            getFormData:function(data){
                if (data.hasOwnProperty('status')) {
                    data.status = data.status =='on'?1:0;
                }
                return data;
            },
            ajaxFormFrameSubmit:function(eventObj,data){
                var url = $(eventObj).data('url')
                    ,_data = common.getFormData(data.field)
                    ,method = $(eventObj).data('method')?$(eventObj).data('method'):'post';
                common.fromBtnElem = this;
                common.reqCallback = function(res){
                    if (!res.hasOwnProperty('returnCode')) {
                        common.successMsg('返回数据格式错误！');
                        return false;
                    }
                    if (res.returnCode == 200) {
                        common.successMsg(res.msg);
                        setTimeout(function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                            parent.location.reload();
                        },common.msgTime)
                    } else {
                        common.errorMsg(res.msg);
                    }
                }
                common.request(url,_data,method);
            },
            successMsg:function (msg) {
                layer.msg(msg, {icon: 1, time: this.msgTime});
            },
            errorMsg:function (msg) {
                layer.msg(msg, {icon: 2, time: this.msgTime});
            },
            request:function (url,data,method,dataType) {
                var _self = this;

                if (!url) {
                    layer.msg('请求地址不能为空！', {icon: 5, time: 2000});
                    return  false;
                }
                if (!method) method = 'get';
                if (!dataType) dataType = 'json';
                if (!data) data = {};
                if (typeof url !== 'string'
                    || typeof data !== 'object'
                    || typeof method !== 'string'
                    || typeof dataType !== 'string') {
                    layer.msg('参数错误！', {icon: 5, time: 2000});
                    return  false;
                }

                //加载层
                var loadIndex = layer.load(0, {shade: 0.3}); //0代表加载的风格，支持0-2

                $.ajax({
                    url:url,
                    type:method,
                    data:data,
                    dataType:dataType,
                    success:function (res) {
                        if (_self.reqCallback) {
                            _self.reqCallback(res);
                        } else {
                            if (!res.hasOwnProperty('returnCode')) {
                                _self.successMsg('返回数据格式错误！');
                                return false;
                            }
                            if (res.returnCode == 200) {
                                _self.successMsg(res.msg);
                            } else {
                                _self.errorMsg(res.msg);
                            }
                        }
                        return false;
                    },
                    error:function (error) {
                        _self.errorMsg('系统错误！');
                    },
                    complete:function () {
                        if (loadIndex) {
                            layer.close(loadIndex);
                        }
                    }
                });
            }
        }

    common.module = urlPath.replace('/'+Config.adminModuleName+'/','').replace('.html','');
    common.controller = common.module.split('/')[0];
    //监听提交【目前仅有登录页面使用】
    form.on('submit(admin-ajax-form-btn)', function(data){
        var url = $(this).data('url')
            ,_data = data.field
            ,method = $(this).data('method')?$(this).data('method'):'post';
        common.fromBtnElem = this;

        if (_data.hasOwnProperty('status')) {
            _data.status = _data.status =='on'?1:0;
        }

        common.request(url,_data,method);
        return false;
    });

    //子页面表单提交监听
    form.on('submit(admin-ajax-form-frame-btn)', function(data){
        common.ajaxFormFrameSubmit(this,data);
        return false;
    });

    exports('common',common);
})
