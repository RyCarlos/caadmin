layui.define(['form','common','_table'],function (exports) {
    var common = layui.common
        ,module = common.module
        ,form = layui.form
        ,_table = layui._table;

    _table.tableData.page = false;

    //表格表头
    _table.tableData.cols = [[
        {type: 'checkbox', fixed: 'left'}
        ,{field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
        ,{field: 'username', title: '用户名',align:'center',width:150,search:true}
        ,{field: 'group_ids', title: '角色组',width:400,templet:function (res) {
            var group_ids = res.group_ids,html = '';
            html += '<div class="layui-btn-container">';
            group_ids.forEach(function (val) {
                html += '<span class="layui-btn layui-btn-xs layui-bg-black">'+val+'</span>';
            });
            html += '</div>';
            return html
        }}
        ,{field: 'email', title: '邮箱',align:'center',width:200,search:true}
        ,{field: 'name', title: '姓名',search:true}
        ,{field: 'create_time', title: '创建时间',align:'center'}
        ,{field: 'update_time', title: '更新时间',align:'center'}
        ,{field: 'last_login_time', title: '更新时间',align:'center'}
        ,{field: 'status', title: '状态',align:'center',toolbar: '#DATA-CELL-STATUS',width:100}
        ,{fixed: 'right', title:'操作',align:'center', toolbar: _table.toolColDefault, width:300}
    ]];


    _table.searchInit(form);
    _table.render(_table.tableData);
    exports(module);
})
