//数据交互
new Vue({
	el:'#app',
	components:{
		'dx-component-answer-toolbar':dxComponentAnswerToolBar,
		'dx-component-answer-datatable':dxComponentAnswerDataTable,
		'dx-component-answer-op':dxComponentAnswerOp,
		'dx-component-answer-reply-op':dxComponentAnswerReplyOp,
    },
	data:{
		request:[],
	},
	mounted:function(){
		this.lstAnswer();
		this.$refs.navbarop.nav=[
			{name:"落地页",url:"/pages/addon/wenda/question.html"},
			{name:"客服",url:"/pages/addon/wenda/service.html"}
		]
	},
	methods:{
		//列表回答
		lstAnswer:function(){
            this.$http.post(api.Selects,{token:localStorage.token,id:localStorage.floorid},{emulateJSON:true}).then(function(res){
				if(1==res.body.code){
					this.request=res.body.data;
					layui.use(['layer','form'], function(){
						layer.msg(res.body.msg,{area:[110,50]});
					});
				}else{
                    layui.use(['layer','form'], function(){
						layer.msg(res.body.msg,{area:[110,50]});
					});
				}
				this.request=res.body.data;
			},function(res){
				layer.msg("服务器无响应，请联系技术人员");
			});
		},
        //添加回答
		addAnswer:function(){
			this.$refs.answerop.answer={
				Avatar:"/assets/imgs/upload_avatar_icon.png",
				Name:"",
				City:"",
				Grade:"",
				Integral:"",
				Label:"",
				Date:"",
				PID:""
			};
			var that =this;
			layui.use(['layer','form'], function(){
				layer.open({
					type:1,
					zIndex:1000,
					title:"添加回答",
					content:$('.addAnswer'),
					area:['100%','100%'],
					btn:'确定',
					btnAlign:'c',
					shade:0.3 ,
					yes:function(index,layero){
						that.$refs.answerop.addAnswerHandle();
						layer.close(index);
						KindEditor.remove('#editorbox');
					},
					cancel: function(index, layero){ 
						layer.close(index);
						KindEditor.remove('#editorbox');
					}  
				});
				KindEditor.create('#editorbox',{
					resizeType:1,
					allowPreviewEmoticons:false,
					allowImageUpload:false,
					useContextmenu:true,
					items : [
					   'source','|','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
					   'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
					   'insertunorderedlist', '|', 'emoticons','uploadimg', 'link','service'],
					afterCreate:function(){
						this.html("");
					},
					afterChange:function(){
						that.$refs.answerop.answer.Content=this.html();
					}
				});
			});
		},
		//编辑回答
		edtAnswer:function(id){
			this.$http.post(api.Finds,{token:localStorage.token,id:localStorage.floorid,ids:id},{emulateJSON:true}).then(function(res){
				this.$refs.answerop.answer=JSON.parse(JSON.stringify(res.body.data));
				var that = this;
				layui.use(['layer','form'], function(){
					layer.open({
						type: 1,
						zIndex:1000,
						title:"修改回答",
						content: $('.addAnswer'),
						area:['100%','100%'],
						btn:'确定',
						btnAlign:'c',
						shade: 0.3 ,
						yes:function(index, layero){
							that.$refs.answerop.edtAnswerHandle();
							layer.close(index);
							KindEditor.remove('#editorbox');
						},
						cancel: function(index, layero){ 
							layer.close(index);
							KindEditor.remove('#editorbox');
						}  
					});
					KindEditor.create('#editorbox',{
						resizeType:1,
						allowPreviewEmoticons:false,
						allowImageUpload:false,
						useContextmenu:true,
						items:[
						'source','|','fontname','fontsize','|','forecolor','hilitecolor','bold','italic','underline',
						'removeformat', '|','justifyleft','justifycenter','justifyright','insertorderedlist',
						'insertunorderedlist','|','emoticons','uploadimg','link','service'],
						afterCreate:function(){
							this.html(res.body.data.Content);
						},
						afterChange:function(){
							that.$refs.answerop.answer.Content=this.html();   
						}
					});
				});
			 },function(res){
				layer.msg("服务器无响应，请联系技术人员");
			 });
		},
		//删除回答
		delAnswer:function(id){
			var id=id;
			var that = this;
			layui.use(['layer','form'], function(){
				layer.confirm('您确定要删除当前回答吗？',{btn: ['确定','取消']},function(index,layero){
					that.$http.post(api.Deletes,{token:localStorage.token,id:localStorage.floorid,ids:id},{emulateJSON:true}).then(function(res){
						if("1"==res.body.code){
							that.lstAnswer();
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
		//添加评论
		addReply:function(id){
			this.$refs.replyop.reply.Content="";
			this.$refs.replyop.reply.Pid=id;
			if(""==this.$refs.replyop.reply.Id){
				layui.use(['layer'], function(){
					layer.msg('请复制唯一编号')
				});
			}else{
				var that = this;
				layui.use(['layer','form'], function(){
					layer.open({
						type: 1,
						title:"添加评论",
						zIndex:1000,
						content: $('.addreply'),
						area: ['700px','550px'],
						btn: '确定',
						btnAlign: 'c',
						shade: 0.3 ,
						yes:function(index, layero){
							that.$refs.replyop.addreply();
							layer.close(index);
							KindEditor.remove('#editorbox2');
						},
						cancel: function(index, layero){ 
							layer.close(index);
							KindEditor.remove('#editorbox2');
						}  
					});
					KindEditor.create('#editorbox2',{
						resizeType:1,
						zIndex:100000000,
						allowPreviewEmoticons:false,
						allowImageUpload:false,
						useContextmenu:true,
						items : [
							'source','|','fontname','fontsize','|','forecolor','hilitecolor','bold','italic','underline',
							'removeformat', '|','justifyleft','justifycenter','justifyright','insertorderedlist',
							'insertunorderedlist','|','emoticons','uploadimg','link','service'],
						afterCreate:function(){
							this.html("");
						},
						afterChange:function(){
							that.$refs.replyop.reply.Content=this.html();
						}
					});
				});
			}
			
		},
		//设置我的标识
		AddReplyMy:function(id,rid){
			this.$refs.replyop.reply.Id=id;
			this.$refs.replyop.reply.RootId=rid;
			layui.use(['layer'], function(){
				layer.msg("复制编号成功",{area:[160,50]});
			});
		}
    }
});