layui.define(['element','layer','md5','admin'],function (exports) {
    var element = layui.element
        ,layer = layui.layer
        ,admin = layui.admin
        ,md5 = layui.md5
        ,$ = layui.$

    var left_tips_index = null;

    //鼠标移入导航显示tips
    $('.left-nav').on('mouseenter', '.left-nav-li> a > i', function (event) {
        if ($('.left-nav').css('width') != '220px') {
            var tips = $(this).attr('lay-tips');
            left_tips_index = layer.tips(tips, $(this));
        }
    })

    //鼠标离开导航隐藏tips
    $('.left-nav').on('mouseout', '.left-nav-li> a > i', function (event) {
        layer.close(left_tips_index);
    });

    // 隐藏左侧
    $('.left-open').click(function (event) {
        if ($('.layui-side-menu').css('width') == '220px') {
            $('.layui-side-menu').animate({width: '60px'}, 100);
            $('.layui-layout-left,.layui-footer,.layui-admin-tab,#ADMIN-APP-BODY').animate({left:'60px'}, 100);

            $('.left-nav cite,.left-nav .nav_right,.layui-nav-itemed > .layui-nav-child').hide();
        } else {
            $('.layui-side-menu').animate({width: '220px'}, 100);
            $('.layui-layout-left,.layui-footer,.layui-admin-tab,#ADMIN-APP-BODY').animate({left:'220px'}, 100);

            $('.layui-nav-itemed > .layui-nav-child,.left-nav cite,.left-nav .nav_right').show();
        }
    });

    // 点击导航 展开
    $(".left-nav  a").click(function () {
        if ($('.layui-side-menu').css('width') == '60px') {
            $('.layui-side-menu').animate({width: '220px'}, 100);
            $('.layui-layout-left,.layui-footer,.layui-admin-tab,#ADMIN-APP-BODY').animate({left: '220px'}, 100);
            $('.left-nav cite,.left-nav .nav_right,.layui-nav-itemed > .layui-nav-child').show();
        }
        var _url = $(this).data('url'),_layId = $(this).data('layid'),isHref = $(this).data('is-href');
        if (_url && isHref) {
            var _id = md5(_layId);
            var _title = $(this).text();
            admin.openTabsPage(_id,_title,_url);
        }
    });

    //刷新页面
    $(".refresh").click(function () {
        admin.refreshPage(admin.tabsLastPage.index);
    });

    exports('index/index');
})
