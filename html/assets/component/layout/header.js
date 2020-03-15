Vue.component('dx-component-header', {
	data:function(){
           return{
			   user:{
				Name:"",
				UserPwd:"",
				User_Img:"/assets/imgs/upload_avatar_icon.png",
				token:localStorage.token
			   },
			   info:{
				Corporate_Name:"",
				User_Img:"",
				Role_Name:""
			   }
		   }
	},
    mounted:function () {
		if(!localStorage.getItem("token")){
			window.location.href="/pages/login/";
		}
		this.$nextTick(function () {
			layui.use(['element','layer'], function(){
				layui.layer.open({
					type:1,
					title:"系统消息",
					area:[400,300],
					offset:'rb',
					shade:0,
					content:'<p style="color:#f13e68;">(2019-3-19)更新内容:</br>'
						    +'1、为解决客户应落地页加载过慢的问题，我们在落地页列表页新增了生成静态页的功能按钮（需要每次更换模板或者改变内容的时候点击生成静态页面，如不点击内容则不会同步）.</br>'
							+'2、对于上传图片的大小，我们默认是宽660px;高410px;如果您需要改变图片大小的话，只需要鼠标单击一下你需要修改的图片，然后鼠标右击一下，在弹出的下拉列表选择图片属性，然后你们就可以自定义图片大小了。</br>'
							+'3、此次更新带来的不便，请您多谅解，提出宝贵的意见。</p></br>',
					cancel:function(){
						
					}
				});
			});
		});
		  this.$http.post(api.selectCompanyinfo,{token:localStorage.token},{emulateJSON:true}).then(function(res){
		     if(1==res.body.code){
				this.info.Corporate_Name=res.body.data.Corporate_Name;
				this.info.User_Img=res.body.data.User_Img;
				this.info.Role_Name=res.body.data.Role_Name
			 }
		},function(res){
			layer.msg("服务器无响应，请联系技术人员"); 
		});
	},
	watch:{
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
		gotoLoginPage:function(){
			localStorage.removeItem('token');
			window.location.href="/pages/login/";
		},
		lockSystem:function(){
			layui.use('layer', function(){
				layer.prompt({title:'请设置锁屏密码,并确认',formType:1,btn:['锁屏','取消']}, function(pass,index){
					layer.close(index);
					layer.prompt({
						title:'请输入解锁密码,并确认',
						formType:1,
						closeBtn:0,
						btn:['解锁'],
						shade:[0.8,'#393D49']
						},function(text, index){
							if(text===pass){layer.close(index);
						}else{
							layer.msg('您的口令有误');
						}
					});
				});
			});         
		},
		//修改个人信息
		edtInfo:function(){
			var that =this;
       layui.use('layer', function(){
			layer.open({
				type: 1,
				title:"修改信息",
				content: $('.edtInfoTable'),
				area: ['450px','300px'],
				btn: '保存信息',
				btnAlign: 'c',
				shade: 0.3 ,
				yes:function(index, layero){
					that.$http.post(api.Edtinfo,that.user,{emulateJSON:true}).then(function(res){
						layui.use(['layer'], function(){
							layer.msg('修改成功！<span name="count" style="color: red;">3</span>秒后跳转登陆页面', {
								icon: 1,
								offset: 't',
							    area:[230, 60],
								success: function (layero, index) {
									var countElem = layero.find('span[name="count"]');
									var timer = setInterval(function () {
										var countTemp = parseInt(countElem.text()) - 1;
										countTemp === 0 ? clearInterval(timer):countElem.text(countTemp);
									}, 1000)
								}	
							}, function () {
								localStorage.token="";
								window.location.href="/pages/login/Index.html";
							});
						}); 
					},function(res){
						layer.msg("服务器无响应，请联系技术人员"); 
					});
					layer.close(index);
				},
				cancel:function(index, layero){ 
					layer.close(index);
				}  
			});
           });
		},
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
	},
    template:'<div class="header">'
	+'<div style="float:left;width:200px;height:60px;line-height:60px;color:#fff;text-align:center;font-size:16px;background:#15a589;"><img src="/assets/imgs/logo.png"></div>'
	+'<ul class="layui-nav" style="background:#18bc9c;width:auto;float:right;">'
	+'<li class="layui-nav-item" style="margin-right:20px;">'
    +'  <a href="javascript:void(0);" style="padding:0px;">欢迎<span v-text="info.Role_Name"></span>!</a>'
    +'</li>'
    +'<li class="layui-nav-item" style="margin-right:20px;">'
	+'	<a href="javascript:void(0);" style="padding:0px;"><i class="layui-icon">&#xe735;</i>授权给:<span v-text="info.Corporate_Name"></span>(终生使用)</a>'
	+'</li>'
	+'<li class="layui-nav-item" style="margin-right:30px;">'
    +'  <a href="javascript:void(0);" style="padding:0px;">消息中心<span class="layui-badge">99+</span></a>'
    +'</li>'
    +'<li class="layui-nav-item">'
    +'  <a href="javascript:void(0);"><img :src="info.User_Img" class="layui-nav-img">个人中心</a>'
    +'  <dl class="layui-nav-child">'
    +'    <dd><a href="javascript:void(0);" @click="edtInfo"><i class="layui-icon">&#xe66f;</i> 修改信息</a></dd>'
    +'    <dd><a href="javascript:void(0);" @click="lockSystem"><i class="layui-icon">&#xe673;</i> 安全锁屏</a></dd>'
    +'    <dd><a href="javascript:void(0);" @click="gotoLoginPage"><i class="layui-icon">&#x1006;</i> 安全退出</a></dd>'
    +'  </dl>'
    +'</li>'
	+'</ul>'
	+'<div class="layui-form edtInfoTable" style="display:none;margin-right:30px;">'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">头像</label>'
    +'    <div class="layui-input-block">'
    +'        <img :src="user.User_Img" width="30" height="30" class="add_Img" style="position: absolute;width:30px;height:30px;cursor: pointer;padding: 0px;color:white;border-radius: 3px;"/>'
    +'        <input @change="upAvatar" type="file" value="上传图片" class="add_Input" accept="image/gif,image/jpeg,image/jpg,image/png" style="display:block;width:30px;height:30px;opacity: 0;">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">姓名</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="text" name="title" required  lay-verify="required" placeholder="请输入姓名" class="layui-input" v-model="user.Name">'
    +'    </div>'
    +'</div>'
    +'<div class="layui-form-item" pane>'
    +'    <label class="layui-form-label">密码</label>'
    +'    <div class="layui-input-block">'
    +'        <input type="password" name="title" required  lay-verify="required" placeholder="请输入密码" class="layui-input" v-model="user.UserPwd">'
    +'    </div>'
    +'</div>'
    +'</div>'
	+'</div>'

});