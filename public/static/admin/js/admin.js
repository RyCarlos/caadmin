layui.define(['element','layer'],function (exports) {
    var $ = layui.jquery
    ,win = $(window)
    ,layer = layui.layer
    ,element = layui.element
    ,ADMIN_APP_BODY = 'ADMIN-APP-BODY',ADMIN_APP_TABS = 'ADMIN_APP_TABS'
    ,TABS_HEADER_FILTER = 'layui-admin-tab-header',TAB_BODY_SHOW = 'layui-show'
    ,TABS_BODY = 'layadmin-tabsbody-item'
    ,admin = {
        v:'1.0'

        //记录最近一次点击的页面标签数据
        ,tabsLastPage:{index:0}

        //获取标签主体元素
        ,tabsBody:function(index){
            return $('#' + ADMIN_APP_BODY).find('.' + TABS_BODY).eq(index || 0);
        }

        //切换标签主体
        ,tabsBodyChange:function(index){
            var tabsBody = admin.tabsBody(index);
            tabsBody.addClass(TAB_BODY_SHOW).siblings().removeClass(TAB_BODY_SHOW);
            tabsBody.find('iframe').show();
            tabsBody.siblings().find('iframe').hide();
        }

        //打开标签页
        ,openTabsPage:function (id,title,url) {
            var tabs = $('#' + ADMIN_APP_TABS + '>li'),isNewTab = true;
            tabs.each(function (index) {
                var layId = $(this).attr('lay-id');
                if (id === layId) {
                    admin.tabsLastPage.index = index;
                    isNewTab = false;
                }
            });
            if (isNewTab) {
                $('#' + ADMIN_APP_BODY).append([
                    '<div class="layadmin-tabsbody-item layui-show">'
                    , '<iframe src="' + url + '" frameborder="0" class="layadmin-iframe"></iframe>'
                    , '</div>'
                ].join(''));
                element.tabAdd(TABS_HEADER_FILTER, {
                    title: title
                    , id: id
                });
                admin.tabsLastPage.index = tabs.length;
            } else {
                var iframe = admin.tabsBody(admin.tabsLastPage.index).find('.layadmin-iframe');
                iframe[0].contentWindow.location.href = url;
            }
            //定位当前tabs
            element.tabChange(TABS_HEADER_FILTER, id);
            admin.tabsBodyChange(admin.tabsLastPage.index);
        }

        //刷新标签页
        ,refreshPage:function (index) {
            var iframe = admin.tabsBody(index).find('.layadmin-iframe');
            iframe[0].contentWindow.location.href = iframe[0].src;
        }

        //打开子页面(弹出页面iframe)
        ,openPopupPage:function (title,url,w,h,full) {

            if (title == null || title == '') var title = false;
            if (url == null || url == '') var url = "404.html";
            if (w == null || w == '') var w = (win.width() * 0.9);
            if (h == null || h == '') var h = (win.height() - 50);

            var index = layer.open({
                type: 2,
                area: [w + 'px', h + 'px'],
                fix: false, //不固定
                maxmin: true,
                shadeClose: true,
                shade: 0.4,
                title: title,
                content: url
            });
            if (full) {
                layer.full(index);
            }
        }
    }

    //监听tabs关闭
    element.on('tabDelete('+TABS_HEADER_FILTER+')', function(data){
        var id,thisIndex= data.index,changeIndex
            ,tabs = $('#' + ADMIN_APP_TABS + '>li');
        admin.tabsBody(thisIndex).remove();
        if (tabs.length === data.index) {
            changeIndex = thisIndex - 1;
        } else {
            changeIndex = thisIndex + 1;
        }
        tabs.each(function (index) {
            if (index == changeIndex) {
                id = $(this).attr('lay-id');
            }
        });
        element.tabChange(TABS_HEADER_FILTER, id);
        admin.tabsBodyChange(changeIndex);
        admin.tabsLastPage.index = changeIndex;
    });

    //监听tabs切换
    element.on('tab('+TABS_HEADER_FILTER+')', function(data){
        admin.tabsLastPage.index = data.index;
        admin.tabsBodyChange(data.index);
    });



    exports('admin',admin);
})
