var dxComponentGroupOp={
    data:function(){
        return {
            group:{
                Name:""
            },
            id:""
        }
    },
    methods:{
        //添加组
        addGroupHandle:function(id){
            this.$http.post(api.AddGroup,{token:localStorage.token,Name:this.group},{emulateJSON:true}).then(function(res){
                    if("1"==res.body.code){
                        this.$parent.SelectGroup();
                        layer.msg(res.body.msg); 
                    }else{
                        layer.msg(res.body.msg); 
                    }    
                },function(res){ 
                    layer.msg("与服务器通讯失败!"); 
                });
            },
         //编辑组
        edtGroupHandle:function(id){
            this.$http.post(api.UpdateGroup,{token:localStorage.token,id:this.id,Name:this.group.Name},{emulateJSON:true}).then(function(res){
                    if("1"==res.body.code){
                        this.$parent.SelectGroup(); 
                        layer.msg(res.body.msg); 
                    }else{
                        layer.msg(res.body.msg); 
                    }    
                },function(res){ 
                    layer.msg("与服务器通讯失败!"); 
                });
                },
        },
    template:'<table class="layui-table addplug" style="display:none;">'
    +'<colgroup>'
    +'  <col width="120">'
    +'  <col>'
    +'</colgroup>'
    +'<tbody>'
    +'  <tr><td width="80">分组名:</td><td><div class="layui-form"><input type="text" class="layui-input" placeholder="分组名" v-model="group.Name"></div></td></tr>'
    +'</tbody>'
    +'</table>'
}