layui.define(['form','common','admin','tree','xmSelect'],function (exports) {
    var common = layui.common
        ,module = common.module
        ,xmSelect = layui.xmSelect;
    var data = JSON.parse($("#rules").val());

    xmSelect.render({
        el: '#group',
        name: 'group_ids',
        layVerify: 'required',
        layVerType: 'msg',
        data: data
    })
    // $(".xm-label-block>span").each(function (item,key) {
    //     $(this).html($(this).text());
    // })
    exports(module);
})
