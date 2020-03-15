new Vue({
	el:'#app',
	data:{
		username:"",
		userpwd:"",
	},
	methods:{
		login:function(){
			//判断账号是否为空
			if(!this.username){
				layui.use(['layer'], function(){
					layer.msg("账号不能为空");
				});
				return;
			}
			//判断密码是否为空
			if(!this.userpwd){
				layui.use(['layer'], function(){
					layer.msg("账号不能为空");
				});
				return;
			}
			//请求后端数据
			this.$http.post(api.loginUser,{username:this.username,userpwd:this.userpwd,token:""},{emulateJSON:true}).then(function(res){
				if("1"==res.body.code){
					localStorage.token=res.body.UserToken;
					layui.use(['layer'], function(){
						layer.msg('登陆成功！<span name="count" style="color: red;">2</span>秒后跳转',{
							icon: 1,
							offset: 't',
							area:[230, 60],
							success: function (layero, index){
								var countElem = layero.find('span[name="count"]');
								var timer = setInterval(function () {
									var countTemp = parseInt(countElem.text()) - 1;
									countTemp === 0 ? clearInterval(timer):countElem.text(countTemp);
								}, 1000);
							}
						},function(){
							window.location.href="/pages/frame/";
						});
					});
				}
				else{
					layui.use(['layer'], function(){
						layer.msg(res.body.msg);
					});
				}
			},function(res){
				layui.use(['layer'], function(){
					layer.msg("与服务器通信失败！");
				});
			});
		},
		//跳转注册页面
		gotoregister:function(){
			window.location.href="/pages/register/";
		}
	}
});