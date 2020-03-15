var dxComponentProvinceToolBar={
    data:function(){
        return {
        selected:"",
        }
    },
    template:'<div class="layui-row layui-form" style="background:#e3e3e3;height:40px;line-height:40px;">'
    +'<button class="layui-btn layui-btn-sm"@click="this.$parent.addprovince" style="float:right;margin:5px 18px"><i class="layui-icon">&#xe608;</i>添加</button>'
    +'</div>'
}