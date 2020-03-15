var dxComponentUserOp ={
    data:function () {
        return {
           user:{
                Name:"",
                Email:"",
                Tel:"",
                Wechat:"",
                UserName:"",
                UserPwd:"",
                User_Img:"",
                Role_Id:"",
            },
            role:[],
            opstatus:true
        }
    },
    watch:{
        role:function(){
            var that = this;
            layui.use(['form','element'], function(){
				layui.form.on('select(addUserRole)',function(data){
		 			that.usRer.ole_Id=data.value;
		 		});
            });
        },
		"user.User_Img":function(val,oldVal){
            if(0<=val.indexOf("base64")){
                this.$http.post(api.UserImg,{"data":val,token:localStorage.token},{emulateJSON:true}).then(function(res){
                    if(1==res.body.code){
                        this.user.User_Img=res.body.data;
						
                        layer.msg(res.body.msg); 
                    }
                    else{
                        layer.msg(res.body.msg); 
                    }
                },function(res){
                    layer.msg("服务器无响应，请联系技术人员"); 
                });
            }  
		},
    },
    methods:{
        //上传头像
        upAvatar:function(e) {
			var file = e.target.files[0];
			var reader = new FileReader();
			var that = this;
			reader.readAsDataURL(file);
			reader.onload = function(e) {
				that.user.User_Img= this.result;
			}
        },
        //保存用户
        addUserHandle:function(){
            var that = this;
            this.$http.post(api.addUser,{user:this.user,token:localStorage.token},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    layer.msg(res.body.msg,function(){
                        that.$parent.lstUser();
                    }); 
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        },
        //编辑用户
        edtUserHandle:function(){
            this.$http.post(api.updateUser,{user:this.user,token:localStorage.token},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstUser(); 
                    layer.msg(res.body.msg); 
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        },
        //删除用户
        delUserHandle:function(id){
            this.$http.post(api.deletUser,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    layer.msg(res.body.msg);
                    this.$parent.lstUser(); 
                }
                else{
                    layer.msg(res.body.msg);
                }
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        }
    },
    template:'<div class="layui-form userTable" style="display:none;margin-right:30px;">'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">头像</label>'
    +'    <div class="layui-input-block">'
    +'        <img :src="user.User_Img" width="30" height="30" class="add_Img"/>'
    +'        <input @change="upAvatar" type="file" value="上传图片" class="add_Input" accept="image/gif,image/jpeg,image/jpg,image/png" style="display:block;width:30px;height:30px;">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">角色</label>'
    +'    <div class="layui-input-block">'
    +'        <select v-model="user.Role_Id" lay-filter="addUserRole">'
    +'            <option selected disabled>请选择对应角色</option>'
    +'            <option v-for="item in role" :value="item.Role_Id" v-text="item.Role_Name"></option>'
    +'        </select>'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">姓名</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入姓名" class="layui-input" v-model="user.Name">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">邮箱</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入邮箱" class="layui-input" v-model="user.Email">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">电话</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入电话" class="layui-input" v-model="user.Tel">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">微信</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入微信" class="layui-input" v-model="user.Wechat">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" v-if="opstatus" pane>'
    +'    <label class="layui-form-label">账号</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入账户" class="layui-input" v-model="user.UserName">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" v-if="opstatus" pane>'
    +'    <label class="layui-form-label">密码</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="password" name="title" required  lay-verify="required" placeholder="请输入密码" class="layui-input" v-model="user.UserPwd">'
    +'    </div>'
    +'</div>'
    +'</div>'
}