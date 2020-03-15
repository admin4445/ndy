var dxComponentCustomerOp={
    data:function(){
        return {
            userCustomer:true,
            customer:{
                User_Img:"",
                User_Qrcode:"",
                Status:"",
                User_Id:"",
                CustomerService_Name:"",
                CustomerService_Sex:"",
            }
        }
    },
    updated:function(){
        var that=this;
        this.$nextTick(function () {
            layui.use(['form','element','layer'], function(){
                layui.form.render('select');
            layui.form.on('select(sexvalue)',function(data){
                that.customer.CustomerService_Sex= data.value;
            });
            layui.form.on('select(user)', function(data){
                that.customer.User_Id= data.value;
            });
            });
        });
    },
    watch:{
		//监听图像
		"customer.User_Img":function(val,oval){
			if(0<=val.indexOf("base64")){
				this.$http.post(api.UserImg,{"data":val,token:localStorage.token},{emulateJSON:true}).then(function(res){
					if(1==res.body.code){
                        this.customer.User_Img=res.body.data;
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
        //监听二维码
        "customer.User_Qrcode":function(val,oval){
			if(0<=val.indexOf("base64")){
				this.$http.post(api.UserImg,{"data":val,token:localStorage.token},{emulateJSON:true}).then(function(res){
					if(1==res.body.code){
                        this.customer.User_Qrcode=res.body.data;
                        layer.msg(res.body.msg); 
					}
					else{
                        layer.msg(res.body.msg); 
					}
				},function(res){
				});
			}
        },
        "customer.Status":function(){
            var that=this;
            that.$nextTick(function () {
                layui.use(['form','element','layer'], function(){
                    layui.form.render('select');
                layui.form.on('select(customerstatus)',function(data){
                    that.customer.Status=data.value;
                });
                });
            });
        },
    }, 
    methods:{
         //上传头像
         onUpload:function(e) {
			var file = e.target.files[0];
			var reader = new FileReader();
			var that = this;
			reader.readAsDataURL(file);
			reader.onload=function(e){
				that.customer.User_Img= this.result;
			}
        },
        //上传二维码
        onUploadQrcod:function(e){
            var file = e.target.files[0];
			var reader = new FileReader();
			var that = this;
			reader.readAsDataURL(file);
			reader.onload = function(e) {
                that.customer.User_Qrcode= this.result;
			}
        },
        //添加客服
        addCustomerHandle:function(id){
            this.$http.post(api.AddCustomerService,{token:localStorage.token,id:localStorage.selects,customer:this.customer,},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    layer.msg(res.body.msg); 
                    this.$parent.lstCustomer(); 
                }else{
                    layer.msg(res.body.msg); 
                }    
                },function(res){ 
                    layer.msg("与服务器通讯失败!"); 
                });
            },
        //编辑客服
        edtCustomerHandle:function(id){
            this.$http.post(api.UpdateCustomerService,{token:localStorage.token,id:localStorage.selects,customer:this.customer},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstCustomer();
                    layer.msg(res.body.msg); 
                }else{
                    layer.msg(res.body.msg); 
                }    
                },function(res){ 
                    layer.msg("与服务器通讯失败!"); 
                });
                },
        },
    template:'<div class="layui-table">'
    +'<table class="addCustomerServices" style="display:none;">'
    +'<thead>'
    +'  <colgroup>'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col>'
    +'  </colgroup>'
    +'</thead>'
    +'<tbody> '
    +'  <tr>'
    +'    <td>头像:</td>'
    +'    <td>'
    +'      <img :src="customer.User_Img"  class="CustomerServices_Img" style="width:30px;height:30px;"/>'
    +'      <input type="file" name="img" @change="onUpload" class="CustomerServices_Input" accept="image/gif,image/jpeg,image/jpg,image/png" />'
    +'    </td>'
    +'  </tr>'
    +'  <tr>'
    +'    <td width="80">二维码:</td>'
    +'    <td>'
    +'      <img :src="customer.User_Qrcode"  class="CustomerServices_Img" style="width:30px;height:30px;"/>'
    +'      <input type="file" name="avatar" @change="onUploadQrcod" class="CustomerServices_Input"  accept="image/gif,image/jpeg,image/jpg,image/png" />'
    +'    </td>'
    +'  </tr>'
    +'  <tr><td width="80">名称:</td><td><input placeholder="请输入名称" v-model="customer.CustomerService_Name"  class="layui-input" ></td></tr>'
    +'  <tr style="height:20px;">'
    +'    <td width="80">性别:</td>'
    +'    <td>'
    +'      <div class="layui-form" v-model="customer.CustomerService_Sex">'
    +'        <select lay-filter="sexvalue">'
    +'          <option seleced>请选择性别</option>'
    +'          <option value=1>男</option>'
    +'          <option value=0>女</option>'
    +'        </select>'
    +'      </div>'
    +'    </td>'
    +'  </tr>'
    +'  <tr v-if="userCustomer">'
    +'    <td width="80">用户:</td>'
    +'    <td>'
    +'      <select v-model="customer.User_Id" lay-filter="user">'
    +'        <option disabled value="">请选择用户</option>'
    +'        <option v-for="item in this.$parent.UserLst" v-text="item.UserName" :value="item.User_Id"></option>'
    +'      </select> '
    +'    </td>'
    +'  </tr>'
    +'  <tr style="height:20px;">'
    +'    <td width="80">状态:</td>'
    +'    <td>'
    +'      <div class="layui-form" v-model="customer.Status">'
    +'        <select lay-filter="customerstatus">'
    +'          <option seleced>请选择状态</option>'
    +'          <option value=1>正常</option>'
    +'          <option value=0>冻结</option>'
    +'        </select>'
    +'      </div>'
    +'    </td>'
    +'  </tr>'
    +'  <tr><td width="80">电话:</td><td><input placeholder="请输入电话" v-model="customer.CustomerService_Tel"  class="layui-input" ></td></tr>'
    +'  <tr><td width="80">微信:</td><td><input  placeholder="请输入微信" v-model="customer.CustomerService_Wechat"  class="layui-input"></td></tr>'
    +'</tbody>'
    +'</table>'
    +'</div>'
}