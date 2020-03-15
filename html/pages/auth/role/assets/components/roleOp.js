var dxComponentRoleOp ={
    data:function () {
        return {
            Role:{
                Role_Name:"",
                Right_Id:[],
                Description:"",
                Status:""
            }
        }
    },
    props:{
        power:Object,
    }, 
    methods:{
        addRoleHandle:function(){
            if(this.Role.Right_Id.length<1){this.Role.Right_Id="";}
            this.$http.post(api.addRole,{token:localStorage.token,Role:this.Role},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstRole();
                    layer.msg(res.body.msg);
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
        edtRoleHandle:function(){
            if(this.Role.Right_Id.length<1){this.Role.Right_Id="";}
            this.$http.post(api.editRole,{token:localStorage.token,Role:this.Role},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstRole(); 
                    layer.msg(res.body.msg); 
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        }
    },
    template:'<div class="layui-form roleTable" style="display:none;margin-right:20px;">'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">角色名称</label>'
    +'    <div class="layui-input-block">'
    +'    <input type="text" name="title" required  lay-verify="required" placeholder="请输入角色名" class="layui-input" v-model="Role.Role_Name">'    
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">角色授权</label>'
    +'    <div class="layui-input-block">'
    +'       <table class="layui-table" lay-size="sm">'
    +'          <tr v-for="item in power">'
    +'              <td width="120" v-text="item.PrivilegeTypeName" style="font-size:12px;font-weight:bolder;color:#f00;"></td>'
    +'              <td v-for="sitem in item.auth">'
    +'                  <input type="checkbox" :value="sitem.Right_Id" lay-filter="addRoleAuth" class="checkbox1" lay-ignore v-model="Role.Right_Id"><lable v-text="sitem.Right_Name"></lable>'
    +'              </td>'
    +'          </tr>'
    +'      </table>'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">角色描述</label>'
    +'    <div class="layui-input-block">'
    +'        <textarea placeholder="请输入角色描述" class="layui-textarea" v-model="Role.Description"></textarea>'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">角色状态</label>'
    +'    <div class="layui-input-block">'
    +'      <select lay-filter="roleStatus">'
    +'          <option value="2">开启</option>'
    +'          <option value="1">关闭</option>'
    +'      </select>'
    +'    </div>'
    +'</div>'
    +'</div>'
}