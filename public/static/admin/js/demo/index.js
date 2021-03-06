layui.define(['form','common','_table'],function (exports) {
    var common = layui.common
        ,module = common.module
        ,_table = layui._table;

    //表格表头
    _table.tableData.cols = [[
        {type: 'checkbox', fixed: 'left'}
        ,{field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
        ,{field: 'position', title: '名称'}
        ,{field: 'create_time', title: '创建时间',align:'center'}
        ,{field: 'update_time', title: '更新时间',align:'center'}
        ,{field: 'status', title: '状态',align:'center',toolbar: '#DATA-CELL-STATUS',width:100}
        ,{fixed: 'right', title:'操作',align:'center', toolbar: _table.toolColDefault, width:300}
    ]];

    _table.render(_table.tableData);
    exports(module);
})
