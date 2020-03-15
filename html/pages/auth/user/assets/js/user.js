//数据交互
new Vue({
	el:'#app',
	components:{
		'dx-component-user-toolbar':dxComponentUserToolBar,
		'dx-component-user-datatable':dxComponentUserDataTable,
		'dx-component-user-op':dxComponentUserOp,
		'dx-component-edt-pwd':dxComponentEdtPwd
	},
	data:{
		userList:{pageList:[]},
		SelectRole:[],
	},
	watch:{
		"userList.pageList":function(){
			var that = this;
			this.$nextTick(function(){
				layui.use(['form','layer','element'], function(){
					layui.form.render('checkbox');
				});
			});
		}
	},
	mounted:function () {
		this.lstUser(1);
		this.lstRole();
		this.$refs.navbarop.nav=[
		 	{name:"权限管理",url:"#"},
        	{name:"用户管理",url:"#"}
		]
	},
	methods:{
		//列表用户//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		lstUser:function(curPage){
			var that = this;
			layui.use(['layer'],function(){
				that.$http.post(api.selectUser,{token:localStorage.token,page:1,pagenum:10,},{emulateJSON:true}).then(function(res){
					if("1"==res.body.code){
						that.userList.pageList= JSON.parse(JSON.stringify(res.body.data));
						layer.msg(res.body.msg); 
					}
					else{
						layer.msg(res.body.msg); 
					}
				},function(res){
					layer.msg("服务器无响应，请联系技术人员",{offset:'t',icon: 1}); 
				});
			});
		},
		//列表角色///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		lstRole:function(){
			this.$http.post(api.selectRole,{token:localStorage.token},{emulateJSON:true}).then(function(res){
				if("1"==res.body.code){
					this.$refs.userop.role=res.body.data;
				}
			},function(res){
				layer.msg("服务器无响应，请联系技术人员"); 
			});
		},
		//查询用户/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		fndUser:function(id){
			this.$http.post(api.findUser,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
				if(res.body.code){
					this.$refs.userop.user=JSON.parse(JSON.stringify(res.body.data[0]));
					layer.msg(res.body.msg); 
				}else{
					layer.msg(res.body.msg); 
				}
			},function(res){
				layer.msg("服务器无响应，请联系技术人员"); 
			});
		},
		//添加用户////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		addUser:function(){
			var user={ 
				Name:"",
				Email:"",
				Tel:"",
				Wechat:"",
				UserName:"",
				UserPwd:"",
				User_Img:"/assets/imgs/upload_avatar_icon.png"
			};
			this.$refs.userop.opstatus=true;
			this.$refs.userop.user=JSON.parse(JSON.stringify(user));
			var that = this;
			layer.open({
				type:1,
				title:"添加用户",
				content:$('.userTable'),
				area:['500px','580px'],
				btn:'保存用户',
				btnAlign:'c',
				shade: 0.3 ,
				yes:function(index,layero){
					that.$refs.userop.addUserHandle();
					layer.close(index);
				},
				cancel:function(index, layero){ 
					layer.close(index);
				}  
			});
		},
		//编辑用户///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		edtUser:function(id){
			this.fndUser(id);
			var that = this;
			this.$refs.userop.opstatus=false;
			layer.open({
				type: 1,
				title:"修改用户",
				content: $('.userTable'),
				area: ['500px','500px'],
				btn: '保存用户',
				btnAlign: 'c',
				shade: 0.3 ,
				yes:function(index, layero){
					that.$refs.userop.edtUserHandle();
					layer.close(index);
				},
				cancel:function(index, layero){ 
					layer.close(index);
				}  
			});
		},
		//删除用户//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		delUser:function(id){
			var that = this;
			var id = id;
			layer.confirm('您确定要删除当前角色吗？',{btn:['确定','取消']},function(index,layero){
				that.$refs.userop.delUserHandle(id);
            });
		},
		 //用户状态开关操作//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 upUserStatus:function(id,s){
            this.$http.post(api.Updatestatus,{token:localStorage.token,id:id},{emulateJSON:true}).then(function(res){
                this.lstUser();
                layer.msg(res.body.msg);                    
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
		},
		//修改用户密码
		EdtPwd:function(id){
			this.$refs.edtpwd.user.Id=id;
			var that=this;
            layer.open({
				type: 1,
				title:"修改密码",
				content: $('.edtPwdTable'),
				area: ['300px','180px'],
				btn: '保存密码',
				btnAlign: 'c',
				shade: 0.3 ,
				yes:function(index, layero){
					that.$refs.edtpwd.edtUserPwdHandle();
					layer.close(index);
				},
				cancel:function(index, layero){ 
					layer.close(index);
				}  
			});
		}
	}
});