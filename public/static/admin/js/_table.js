layui.define(['table','layer','common','admin','laydate'],function (exports) {
    var layuiTable = layui.table
        ,layer = layui.layer
        ,admin = layui.admin
        ,laydate = layui.laydate
        ,common = layui.common
        ,_table = {}
        ,TABLE_ELEM = '#DATA-PAGE-TABLE'
        ,TABLE_FILTER = 'DATA-PAGE-TABLE-FILTER'
        ,SEARCH_ELEM = "#DATA-PAGE-SEARCH"
        ,url = $(TABLE_ELEM).data('url');

    if (!url) {
        layer.msg('表格请求地址不能为空！');
        return false
    }

    _table = {

        //table容器实例
        tableIns:{},

        //初始化table基础数据
        tableData:{
            elem: TABLE_ELEM
            ,toolbar: _table.toolTopDefault //开启头部工具栏，并为其绑定左侧模板
            ,defaultToolbar:['filter']
            ,title: '用户数据表'
            ,url: url //数据接口
            ,page: true //开启分页
            ,cols: null,//表头字段
            parseData:function (res) {
                return {
                    "code": res.returnCode == 200?0:1, //解析接口状态
                    "msg": res.msg, //解析提示文本
                    "count": res.count, //解析数据长度
                    "data": res.data //解析数据列表
                };
            }
        },

        config:{
            btn:{
                add:"ca-add-btn",
                edit:"ca-edit-btn",
                editone:"ca-editone-btn",
                del:"ca-del-btn",
                delone:"ca-delone-btn",
                disabled:"layui-btn-disabled"
            }
        },

        //搜索初始化
        searchInit:function(form){
            var searchHtml = "",searchElem = $(SEARCH_ELEM),searchData = [],dateArr = [];
            this.tableData.cols[0].forEach(function (item) {
                if (item.search) {
                    var name = item.search.alias?item.search.alias:item.field
                        ,condition = item.search.condition?item.search.condition:'='
                        ,type = item.search.type?item.search.type:'input.text';
                    if (type == 'input.text') {
                        searchHtml += "<div class='layui-inline ml-10'>" +
                                      "<input data-condition='"+condition+"' class='layui-input' name='"+(name)+"' placeholder='"+item.title+"' autocomplete='off' type='text'>" +
                                      "</div>";
                    }
                    else if (type == 'select') {
                        searchHtml += "<div class='layui-inline ml-10'>";
                        searchHtml += "<select data-condition='"+condition+"' name='"+(name)+"'>";

                        if (item.search.data) {
                            item.search.data.forEach(function (ii) {
                                searchHtml += "<option value='"+ii.id+"'>"+ii.value+"</option>";
                            })
                        }

                        searchHtml += "</select>";
                        searchHtml += "</div>";
                    } else if (type == 'timerange') {
                        searchHtml += "<div class='layui-inline ml-10'>" +
                                      "<input type='text' name='"+name+"' class='layui-input ca-time-range' id='cainput-"+name+"' placeholder='"+item.title+"'>" +
                                      "</div>";
                        dateArr.push(name);
                    }

                    searchData.push({
                        key:name,
                        val:'',
                        condition:condition
                    });
                }

            });
            searchHtml += "<button class='layui-btn' lay-submit lay-filter='ca-search-form-btn'>搜索</button>";
            searchHtml += "<button type='reset' class='layui-btn layui-btn-primary'>重置</button>";

            searchElem.html(searchHtml);

            //绑定日期选择事件
            dateArr.forEach(function (item) {
                //日期时间范围
                laydate.render({
                    elem: '#cainput-'+item
                    ,type: 'datetime'
                    ,range: true
                });
            });


            //重新渲染form表单
            form.render();

            // 提交搜索
            form.on('submit(ca-search-form-btn)', function(data){
                var _data = data.field;
                common.fromBtnElem = this;
                searchData.forEach(function (item) {
                    item.val = _data[item.key];
                });
                _table.tableIns.reload({
                    where:{searchData:JSON.stringify(searchData)}
                });
                return false;
            });

            //重置搜索
            searchElem.find('button[type="reset"]').click(function () {
                _table.tableIns.reload({where:{searchData:{}}});
            })
        },
        //顶部按钮配置
        topButtons:[
            {
                name:'add',
                icon:'layui-icon layui-icon-add-circle ca-add-btn',
                title:'添加',
                className:'layui-btn'
            },
            {
                name:'edit',
                icon:'layui-icon layui-icon-edit',
                title:'编辑',
                className:'layui-btn layui-btn-primary ca-edit-btn'
            },
            {
                name:'del',
                icon:'layui-icon layui-icon-delete',
                title:'删除',
                className:'layui-btn layui-btn-danger ca-del-btn'
            },
        ],
        createTopButtons:function () {
            var html = '';
            html += '<div class="layui-btn-container ca-top-btn">';
            _table.topButtons.forEach(function (item) {
                var attr = $(TABLE_ELEM).data('operate-'+item.name);
                if (['edit', 'del'].indexOf(item.name) > -1) {
                    item.className += ' '+_table.config.btn.disabled;
                }
                if (attr) {
                    html += '<button type="button" data-title="'+item.title+'" class="'+item.className+'" lay-event="'+item.name+'">';
                    html += '<i class="'+item.icon+'"></i>'+item.title;
                    html += '</button>';
                }
            });
            html += '</div>';
            return html;
        },

        //Col按钮配置
        colButtons:[
            // {
            //     name:'add',
            //     icon:'layui-icon layui-icon-add-1',
            //     title:'添加',
            //     className:'layui-btn layui-btn-xs'
            // },
            {
                name:'edit',
                icon:'layui-icon layui-icon-edit',
                title:'编辑',
                className:'layui-btn layui-btn-primary layui-btn-xs'
            },
            {
                name:'del',
                icon:'layui-icon layui-icon-delete',
                title:'删除',
                className:'layui-btn layui-btn-danger layui-btn-xs'
            }
        ],
        createColButtons:function () {
            var html = '';
            html += '<div class="layui-btn-container ca-col-btn">';
            _table.colButtons.forEach(function (item) {
                var attr = $(TABLE_ELEM).data('operate-'+item.name);
                if (attr) {
                    html += '<button type="button" data-title="'+item.title+'" class="'+item.className+'" lay-event="'+item.name+'">';
                    html += '<i class="'+item.icon+'"></i>'+item.title;
                    html += '</button>';
                }
            });
            html += '</div>';
            return html;
        },

        //渲染表格
        render:function(){
            _table.tableIns = layuiTable.render(_table.tableData);
            //监听头工具栏事件
            layuiTable.on('toolbar('+ TABLE_FILTER +')', _table.toolBarCallBack);
            //监听行工具事件
            layuiTable.on('tool('+ TABLE_FILTER +')', _table.toolCallBack);
            //监听复选框选择
            layuiTable.on('checkbox('+ TABLE_FILTER +')', function(obj){
                var checkStatus = layuiTable.checkStatus(_table.tableIns.config.id)
                    ,data = checkStatus.data;
                _table.topButtons.forEach(function (item) {
                    if (['edit', 'del'].indexOf(item.name) > -1) {
                        if (data.length > 0) {
                            $('.'+_table.config.btn[item.name]).removeClass(_table.config.btn.disabled);
                        } else {
                            $('.'+_table.config.btn[item.name]).addClass(_table.config.btn.disabled);
                        }
                    }
                });
            });
        },
        //表格头工具栏事件回调
        toolBarCallBack:function(obj){
            var checkStatus = layuiTable.checkStatus(obj.config.id)
                ,isAll = checkStatus.isAll
                ,data = checkStatus.data
                ,ids = []
                ,url;
            for (var i =0;i < data.length; i++) {
                ids.push(data[i].id);
            }
            if (obj.event != 'add' && !ids.length) {
                    return false;
            }
            switch(obj.event){
                case 'add':
                    var title = $(this).data('title');
                    url = REQUEST_API_PREFIX + common.controller + '/create';
                    admin.openPopupPage(title,url);
                    break;
                case 'edit':
                    var title = $(this).data('title');
                    ids.forEach(function (item) {
                        url = REQUEST_API_PREFIX + common.controller + '/create?id='+item;
                        admin.openPopupPage(title,url);
                    });
                    break;
                case 'del':
                    url = REQUEST_API_PREFIX + common.controller + '/delete';
                    layer.confirm('确认要删除吗？', {icon: 0, title:'提示',skin:'layui-layer-molv'}, function(index){
                        common.reqCallback = function(res){
                            if (!res.hasOwnProperty('returnCode')) {
                                common.successMsg('返回数据格式错误！');
                                return false;
                            }
                            if (res.returnCode == 200) {
                                _table.tableIns.reload();
                                common.successMsg(res.msg);
                            } else {
                                common.errorMsg(res.msg);
                            }
                        }
                        common.request(url,{ids:ids});
                        layer.close(index);
                    });


                    break;
            }
        },
        //表格行工具栏事件回调
        toolCallBack:function(obj){
            var data = obj.data
                ,layEvent = obj.event//获得 lay-event 对应的值
                ,tr = obj.tr//获得当前行 tr 的 DOM 对象（如果有的话）
                ,url;
            switch(obj.event){
                case 'add':
                    var title = $(this).data('title');
                    url = REQUEST_API_PREFIX + common.controller + '/create?id='+data.id;
                    admin.openPopupPage(title,url);
                    break;
                case 'edit':
                    var title = $(this).data('title');
                    url = REQUEST_API_PREFIX + common.controller + '/edit?id='+data.id;
                    admin.openPopupPage(title,url);
                    break;
                case 'del':
                    url = REQUEST_API_PREFIX + common.controller + '/delete';
                    layer.confirm('确认要删除吗？', {icon: 0, title:'提示',skin:'layui-layer-molv'}, function(index){
                        common.reqCallback = function(res){
                            if (!res.hasOwnProperty('returnCode')) {
                                common.successMsg('返回数据格式错误！');
                                return false;
                            }
                            if (res.returnCode == 200) {
                                _table.tableIns.reload();
                                common.successMsg(res.msg);
                            } else {
                                common.errorMsg(res.msg);
                            }
                        }
                        common.request(url,{ids:[data.id]});
                        layer.close(index);
                    });
                    break;
            }
        },
    }


    _table.tableData.toolbar = _table.createTopButtons();

    _table.toolColDefault = _table.createColButtons();

    exports('_table',_table)
})
