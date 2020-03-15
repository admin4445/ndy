 var dxComponentUserToolBar ={
    data:function(){return {
        scrUser_Name:"",
    }},
    watch:{
        scrUser_Name:function(){
            this.$http.post(api.scrUser,{"Name":this.scrUser_Name,token:localStorage.token},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){this.$parent.userList.pageList= res.body.data;}
			},function(res){
                layer.msg("服务器出错，请联系技术人员",{offset:'t',icon: 1}); 
			});
        },
    },
    template:'<div class="layui-row layui-form" style="background:#e3e3e3;height:40px;line-height:40px;">'
    +'<div style="float:left;width:80px;text-align:center;">数据查询</div>'
    +'<input  type="text" v-model="scrUser_Name" name="username" lay-verify="required" placeholder="请输入用户姓名" autocomplete="off" class="layui-input" style="float:left;width:220px;">'
    +'<button class="layui-btn layui-btn-sm" @click="this.$parent.addUser" style="float:right;margin-top:5px;margin-right:10px;"><i class="layui-icon">&#xe608;</i>添加</button>'
    +'</div>'
}