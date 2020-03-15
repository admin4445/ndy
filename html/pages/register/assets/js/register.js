//数据交互
var vm = new Vue({
	el:'#app',
	data:{
		register:{
			Corporate_Name:"",
			Corporate_Boss:"",
			Corporate_Tel:"",
			UserName:"",
			UserPwd:""
		}
	},
	methods:{
		addRegister:function(){
			 if(""==this.register.Corporate_Name){
				layui.use(['layer'], function(){
					layer.msg('公司名不能为空',{area:[160,50]});
				});
			}else if(""==this.register.Corporate_Boss){
				layui.use(['layer'], function(){
					layer.msg('联系姓名不能为空',{area:[160,50]});
				});
			}else if(""==this.register.Corporate_Tel){
                layui.use(['layer'], function(){
					layer.msg('联系电话不能为空',{area:[160,50]});
				});
			}else if(""==this.register.UserName){
                layui.use(['layer'], function(){
					layer.msg('注册账号不能为空',{area:[160,50]});
				});
			}else if(""==this.register.UserPwd){
                layui.use(['layer'], function(){
					layer.msg('注册密码不能为空',{area:[160,50]});
				});
			}else{
				this.$http.post(api.Register,this.register,{emulateJSON:true}).then(function(res){
					if(1==res.body.code){
						layui.use(['layer'], function(){
							layer.msg('注册成功！<span name="count" style="color: red;">3</span>秒后跳转', {
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
								window.location.href="/pages/login/Index.html";
							});
						  
						});
					}
					else{
						layui.use(['layer'], function(){
							layer.msg(res.body.msg);
							
				   		});
					}
				},function(res){
					
				});
			}
		},
		upLogin:function(){
			window.location.href="/pages/login/Index.html";
		}
	}
});