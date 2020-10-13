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
        ,{field: 'position', title: '菜单名称',search:{alias:"title"}}
        ,{field: 'is_menu', title: '是否菜单',align:'center',width:100
            ,search:{
                type:"select"
                ,data:[
                    {id:"",value:"是否菜单"}
                    ,{id:"1",value:"是"}
                    ,{id:"2",value:"否"}
                ]
            }
            ,templet:function (res) {
                if(res.is_menu == 1){
                    return '<span>是</span>';
                } else {
                    return '<span>否</span>';
                }
            }
        }
        ,{field: 'status', title: '状态',align:'center',toolbar: '#DATA-CELL-STATUS',width:100}
        ,{fixed: 'right', title:'操作',align:'center', toolbar: _table.toolColDefault}
    ]];




    _table.searchInit(form);
    _table.render(_table.tableData);
    exports(module);
})
