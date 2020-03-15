var dxComponentSpotToolBar ={
    data:function(){return {
        scrUser_Name:"",
    }},
    methods:{
        parentAddSpot:function(){
            this.$parent.addSpot();
        }
    },
    template:'<div class="layui-row layui-form" style="background:#e3e3e3;height:40px;line-height:40px;">'
    +'<button class="layui-btn layui-btn-sm" @click="parentAddSpot" style="float:right;margin:5px 18px"><i class="layui-icon">&#xe608;</i>添加</button>'
    +'</div>'
}