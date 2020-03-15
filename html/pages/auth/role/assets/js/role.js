var vm_user = new Vue({
     el:'#app',
     components:{
        'dx-component-role-toolbar': dxComponentRoleToolBar,
        'dx-component-role-datatable': dxComponentRoleDataTable,
        'dx-component-role-op' : dxComponentRoleOp,
	 },
     data:{
        user_Role:[],
        ids:[],
        checked:false,
        power:{},
        id:"",
     },
     mounted:function(){
        this.lstRole();
        this.permissionRole();
		this.$refs.navbarop.nav=[
		 	{name:"权限管理",url:"#"},
        	{name:"角色管理",url:"#"}
		]
     },
     updated:function(){
        var that=this;
        this.$nextTick(function(){
           layui.use(['form','layer','element'], function(){
                layui.form.render('checkbox');
                layui.form.render('select');
                layui.form.on('select(roleStatus)',function(res){
                    that.$refs.roleop.Role.Status=parseInt(res.value)-1;
                }); 
           });
        });
    },
     methods:{
        //全选功能/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        selectAll:function(){
            this.checked = !this.checked;
            let _this=this;
            if(_this.checked){
                this.ids = [];
                _this.user_Role.forEach(function(item) {
                    _this.ids.push(item.Role_Id);
                });
            }else{
                _this.ids = [];
            }
        },
        //单选功能/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        selectOne:function(id){
            if(0<=this.ids.indexOf(id)){
                this.ids.splice(this.ids.indexOf(id),1); 
            }else{
                this.ids.push(id);
            }
        },
        //获取权限列表///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        permissionRole:function(){
            this.$http.post(api.permissionRole,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                this.power=res.body.data;
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
        },
        //角色列表////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        lstRole:function(){ 
            var that = this;
            layui.use(['layer'], function(){
                that.$http.post(api.selectRole,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                    if("1"==res.body.code){
                        that.user_Role = res.body.data;
                        layer.msg(res.body.msg);
                    }
                    else{
                        layer.msg(res.body.msg);
                    }
                },function(res){
                    layer.msg("与服务器通讯失败！");
                });
            });
        },
        //添加角色//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        addRole:function(){
            var that=this;
            var role={Role_Name:"",Right_Id:[],Description:""};
            that.$refs.roleop.Role=role;
            layui.form.render('checkbox');
            layer.open({
                type: 1,
                title:"添加角色",
                content: $('.roleTable'),
                area: ['60%','80%'],
                btn: '保存角色',
                btnAlign: 'c',
                shade: 0.3 ,
                yes:function(index,layero){ 
                    that.$refs.roleop.addRoleHandle();
                    layer.close(index);
                }
            });
        },
        //编辑角色操作//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        edtRole:function(role){
            var that = this;
            that.$http.post(api.selectrp,{token:localStorage.token,id:role.Role_Id},{emulateJSON:true}).then(function(res){
                role.Right_Id=[];
                if("1"==res.body.code){
                    for(i=0;i<res.body.data.length;i++){
                        role.Right_Id[i] = res.body.data[i].Right_Id;
                    }
                }
                that.$refs.roleop.Role=JSON.parse(JSON.stringify(role));
                $('option[value="'+(parseInt(role.Status)+1)+'"]').prop("selected",true);
                $('option[value!="'+(parseInt(role.Status)+1)+'"]').prop("selected",false);
                layui.form.render('select');
                layer.open({
                    type: 1,
                    title:"编辑角色",
                    content: $('.roleTable'),
                    area: ['500px','550px'],
                    btn:'保存角色',
                    btnAlign:'c',
                    shade: 0.3,
                    yes:function(index, layero){
                        that.$refs.roleop.edtRoleHandle();
                        layer.close(index);
                    },
                    cancel: function(index, layero){ 
                        layer.close(index);
                        var role={Role_Name:"",Right_Id:[],Description:""};
                        that.$refs.roleop.Role=JSON.parse(JSON.stringify(role));
                    }  
                }); 
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
        },
       //删除角色//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       delRole:function(id){
            var that = this;
            this.ids[0]=id;
            layer.confirm('您确定要删除当前角色吗？', {btn: ['确定','取消']},function(index, layero){
                that.delRoles();
                layer.close(index);
            },function(){
                
            });
        }, 
        //全选删除提交按钮/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        delRoles:function(){
            if(0<this.ids.length){
                var that =this;
                this.$http.post(api.deleteRole,{ids:this.ids,token:localStorage.token},{emulateJSON:true}).then(function(res){
                    if("1"==res.body.code){
                        that.checked=false;
                        that.ids=[];
                        that.lstRole();
                        layer.msg(res.body.msg,function(){that.lstRole(); }); 
                    }else{
                        layer.msg(res.body.msg); 
                    }
                },function(res){
                    layer.msg("与服务器通讯失败!");
                });
            }
            else{
                layer.msg("请选择要删除的角色"); 
            }
        },
        //角色状态开关操作//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        upRoleStatus:function(id,s){
            this.$http.post(api.UpdateroleStatus,{token:localStorage.token,id:id,status:s},{emulateJSON:true}).then(function(res){
                this.lstRole();
                layer.msg(res.body.msg);                    
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
        },
    }
});