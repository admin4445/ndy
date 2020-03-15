//数据交互
 new Vue({
	el:'#app',
	components:{
        'dx-component-customer-toolbar':dxComponentCustomerToolBar,
        'dx-component-customer-datatable':dxComponentCustomerDataTable,
        'dx-component-customer-customerop':dxComponentCustomerOp
    },
	data:{
        CustomerLst:[],
        UserName:"",  
        UserLst:[],
    },
    mounted:function(){
        this.lstCustomer();
		this.$refs.navbarop.nav=[
			{name:"落地页",url:"/pages/addon/wenda/question.html"},
			{name:"客服",url:"/pages/addon/wenda/service.html"}
		]
	}, 
    watch:{
        CustomerLst:function(){
            var that= this;
            that.$nextTick(function(){
                layui.use(['form','element','layer'], function(){
                    layui.form.render('checkbox');
                    layui.form.render('select');
                    layui.form.on('select(customerstatus)', function(data){
                        that.$refs.customerop.customer.Status= data.value;
                    });  
                });
            });
        } 
    },
	methods:{
        //查询客服列表接口
        lstCustomer:function(curPage){
            var that=this;
            layui.use(['layer'],function(){
				that.$http.post(api.CustomerService,{token:localStorage.token,floorid:localStorage.selects},{emulateJSON:true}).then(function(res){
					if("1"==res.body.code){
						that.CustomerLst= res.body.data;
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
        //添加客服弹出框
        addbtn:function(){
            var that=this;
            var customer={
                User_Img:"/assets/imgs/upload_avatar_icon.png",
                User_Qrcode:"/assets/imgs/Qrcode.png",
                CustomerService_Sex:"",
                User_Id:"",
                CustomerService_Name:"",
                CustomerService_Tel:"",
                CustomerService_Wechat:"",
            };
            that.$refs.customerop.customer=JSON.parse(JSON.stringify(customer));
            that.$refs.customerop.userCustomer=true;
            that.$http.post(api.selectUser,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                that.UserLst=res.body.data;
            }),
            layui.use(['layer','form'], function(){
				layer.open({
					type:1,
					title:"添加客服",
					content:$('.addCustomerServices'),
					area:['450px','540px'],
					btn:'确定',
					btnAlign:'c',
                    shade:0.3 ,
					yes:function(index,layero){
                        that.$refs.customerop.addCustomerHandle();
						layer.close(index);
					},
					cancel: function(index, layero){ 
						layer.close(index);
					}  
				});
			});
        },
        //编辑客服弹出框
        edtCustomer:function(id){
            this.$http.post(api.FindCustomerService,{token:localStorage.token,id:id,ids:localStorage.selects},{emulateJSON:true}).then(function(res){
                this.$refs.customerop.customer.User_Img=res.body.data.Photo;
                this.$refs.customerop.customer.User_Qrcode=res.body.data.QrCode;
                this.$refs.customerop.customer.Status=res.body.data.Status;
                this.$refs.customerop.customer.User_Id=res.body.data.Pid;
                this.$refs.customerop.customer.CustomerService_Name=res.body.data.CustomerService_Name;
                this.$refs.customerop.customer.CustomerService_Sex=res.body.data.CustomerService_Sex;
                this.$refs.customerop.customer.CustomerService_Tel=res.body.data.CustomerService_Tel;
                this.$refs.customerop.customer.CustomerService_Wechat=res.body.data.CustomerService_Wechat;
                this.$refs.customerop.userCustomer=false;
                var that=this;
                layui.use(['layer','form'], function(){
                layer.open({
                    type:1,
                    itle:"修改客服信息",
                    content: $('.addCustomerServices'),
                    area: ['450px','540px'],
                    btn:'确定',
                    btnAlign:'c',
                    shade: 0.3 ,
                    yes:function(index,layero){
                    that.$http.post(api.UpdateCustomerService,{token:localStorage.token,id:id,ids:localStorage.selects,customer:that.$refs.customerop.customer},{emulateJSON:true}).then(function(res){   
                        if("1"==res.body.code){
                            that.lstCustomer();
                            layer.msg(res.body.msg); 
                        }else{
                            layer.msg(res.body.msg); 
                        }    
                    },function(res){
                        layer.msg("与服务器通讯失败!"); 
                    });
                    layer.close(index);
                },
                cancel: function(index,layero){ 
                    layer.close(index);
                }  
            });
            });
            },function(res){
            });
        },
        //修改状态
        edtStatus:function(id){
            this.$http.post(api.UpdateroleStatuss,{token:localStorage.token,id:id,ids:localStorage.selects},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    layui.use(['layer'], function(){layer.msg(res.body.msg);});
                }
                else{
                    layui.use(['layer'], function(){layer.msg(res.body.msg);});
                }
            },function(res){
                layui.use(['layer'], function(){layer.msg("服务器无响应，请联系技术人员");});
            });
        },
        //删除客服
        delCustomer:function(id){
            var that = this;
            layui.use(['layer','form'], function(){
                layer.confirm('您确定要删除当前客服吗？',
                {btn: ['确定','取消']},
                function(index,layero){
                    that.$http.post(api.DeleteCustomerService,{token:localStorage.token,id:id,ids:localStorage.selects},{emulateJSON:true}).then(function(res){
                        if("1"==res.body.code){
                            that.lstCustomer();
                            layer.close(index);
                            layer.msg(res.body.msg);
                        }
                        else{
                            layer.msg(res.body.msg);
                        }
                    },function(res){
                        layer.msg("服务器无响应，请联系技术人员"); 
                    });
                });
            });
         },
    },
});