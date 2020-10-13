layui.define(['form','common','admin'],function (exports) {
    var common = layui.common
        ,module = common.module
        ,admin = layui.admin;
    $('.search-btn').click(function () {
        var url = $(this).data('url');
        admin.openPopupPage('选择图标',url)
    });

    $("input[name='icon']").change(function(){
        var _val = $(this).val();
        $('#icon-privew').removeClass().addClass(_val);
    });
    exports(module);
})
