var dxComponentEdtPwd ={
    data:function () {
        return {
            user:{
                UserPwd:"",
                token:localStorage.token,
                Id:""
            }
        }
    },
    watch:{
       
    },
    methods:{
           //修改用户密码
           edtUserPwdHandle:function(){
            this.$http.post(api.UserUpdatepassword,this.user,{emulateJSON:true}).then(function(res){
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
    },
    template:'<div class="layui-form edtPwdTable" style="display:none;margin-right:30px;">'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">新密码:</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="password" name="title" required  lay-verify="required" placeholder="请输入新密码" class="layui-input" v-model="user.UserPwd">'
    +'    </div>'
    +'</div>'
    +'</div>'
}