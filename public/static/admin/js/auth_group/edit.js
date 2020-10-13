layui.define(['form','common','admin','tree'],function (exports) {
    var common = layui.common
        ,module = common.module
        ,tree = layui.tree//模拟数据
        ,data = $("#TREE-DATA").val();
    if (data) {
        data = JSON.parse(data);
    }

    common.getFormData = function(data){
        if (data.hasOwnProperty('status')) {
            data.status = data.status =='on'?1:0;
        }
        //获取选中节点的数据
        getChecked(tree.getChecked('ruleIds'));
        for (var i in data) {
            if (i.indexOf('layuiTreeCheck')==0) {
                delete data[i];
            }
        }
        data.rules = rids.join(',');
        return data;
    }

    var rids = [];
    function getChecked(arr,field){
        if (!field) {
            var field = 'id';
        }
        for (var i = 0; i < arr.length; i++) {
            if (arr[i].id) {
                rids.push(arr[i].id)
            }
            if (arr[i].children) {
                getChecked(arr[i].children)
            }
        }
    }

    //基本演示
    tree.render({
        elem: '#data-tree'
        ,data: data
        ,showCheckbox: true  //是否显示复选框
        ,id:"ruleIds"
        ,oncheck: function(obj){
            rids = [];
        }
    });

    exports(module);
})
