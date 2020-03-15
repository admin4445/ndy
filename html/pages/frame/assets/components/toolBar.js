 var dxComponentOrderToolBar ={
    data:function(){return {
      Contacts:""
    }},
    watch:{
        Contacts:function(){
            this.$http.post(api.Filtrateorder,{Contacts:this.Contacts,token:localStorage.token},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.orderList= res.body.data;
                    layer.msg(res.body.msg); 
                }
			},function(res){
                layer.msg("服务器出错，请联系技术人员",{offset:'t',icon: 1}); 
			});
        },
    },
    template:'<div class="layui-row layui-form" style="background:#e3e3e3;height:40px;line-height:40px;">'
    +'<div style="float:left;width:80px;text-align:center;">订单筛选</div>'
    +'<input  type="text" v-model="Contacts" name="username" lay-verify="required" placeholder="请输入联系人" autocomplete="off" class="layui-input" style="float:left;width:220px;">'
    +'<button class="layui-btn layui-btn-sm" @click="this.$parent.addOrder" style="float:right;margin-top:5px;margin-right:10px;"><i class="layui-icon">&#xe608;</i>添加</button>'
    +'</div>'
}