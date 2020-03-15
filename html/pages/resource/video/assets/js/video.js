//数据交互
new Vue({
	el:'#app',
	components:{
		'dx-component-photo-toolbar':dxComponentPhotoToolBar,
		'dx-component-folder-foldertable':dxComponentFolderTable,
		'dx-component-folder-folderop':dxComponentFolderOp,
		'dx-component-video-videotable':dxComponentVideoTable,
		'dx-component-video-videoop':dxComponentVideoOp,
		'dx-component-video-edtvideoop':dxComponentEdtVideoOp
	},
	data:{
		prvid:[],
		currid:"",
		rootid:"",
		currLevel:0,
		ids:[],
		upload:{}
	},
	mounted:function(){
		this.lstDirectory();
		this.lstVideo();
		this.$refs.navbarop.nav=[
		 	{name:"资源管理",url:"#"},
        	{name:"视频管理",url:"#"}
		]
		this.$nextTick(function(){
			var that =this;
			layui.use('upload', function(){
				layui.upload.render({
					elem:'#test5'
					,url:api.uploadVideo
					,accept: 'video'
					,data:{token:localStorage.token}
					,before:function(res){
						layer.msg("正在上传",{shade:0.3,});
					}
					,done:function(res){
						if(1==res.code){
							that.$refs.videoop.upload.Video_Path=res.data;
							layer.msg(res.msg);
						}else{
							layer.msg(res.msg);
						}
					}
					,error:function(index,upload){
						layer.msg("与服务器通信失败");
					}
				});
			});
		});
	},
	methods:{
		//列表视频
		lstVideo:function(){
			this.$http.post(api.SelectVideo,{rootid:this.rootid,level:this.currLevel,pid:this.currid,token:localStorage.token},{emulateJSON:true}).then(function(res){
				this.$refs.listVideo.VideoList=res.body.data;
				this.$refs.listVideo.ids=[];
			},function(res){

			});
		},
		//列表目录
		lstDirectory:function(){
			this.$http.post(api.SelectVideocatalog,{level:this.currLevel,token:localStorage.token,pid:this.currid},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
					this.$refs.listFolder.folderList=res.body.data;
					this.$refs.listFolder.ids=[];
					layui.use(['layer','form'], function(){
						layer.msg(res.body.msg,{area:[110,50]});
					});
                }else{
					this.$refs.listFolder.folderList=[];
					this.$refs.listFolder.ids=[];
					layui.use(['layer','form'], function(){
						layer.msg(res.body.msg,{area:[110,50]});
					});
                }
            },function(res){
				layer.msg("服务器无响应，请联系技术人员");
            });
		},
		//创建目录
		addFolder:function(){
			this.$refs.folderop.folder.Name="";
			this.$refs.folderop.folder.pid="";
			var that = this;
			layui.use(['layer'], function(){
			layer.open({
					type: 1,
					title:"创建目录",
					content:$('.addFolderTable'),
					area:[300,240],
					btn:'保存目录',
					btnAlign: 'c',
					shade: 0.3 ,
					yes:function(index,layero){
						that.$refs.folderop.addFolderHandle();
						layer.close(index);
					},
					cancel: function(index,layero){ 
						layer.close(index);
					}  
				}); 
			}); 
		},
		//编辑目录
		edtFolder:function(){
			var that = this;
			if(0==that.ids.length){
				layui.use(['layer'], function(){
					layer.msg('请选择',{area:[120,50]});
				});
			}else if(1<that.ids.length){
				layui.use(['layer'], function(){
					layer.msg('不能多选',{area:[120,50]});
				});
			}else{
				that.$http.post(api.FindVideocatalog,{ids:that.ids,token:localStorage.token},{emulateJSON:true}).then(function(res){
					that.$refs.folderop.folder.Id=res.body.data.Catalog_Id;
					that.$refs.folderop.folder.Name=res.body.data.Catalog_Name;
					layui.use(['layer'], function(){
						layer.open({type: 1,
							title:"编辑目录",
							content:$('.addFolderTable'),
							area:[300,240],
							btn:'保存修改',
							btnAlign: 'c',
							shade: 0.3 ,
							yes:function(index, layero){
								that.$refs.folderop.edtFolderHandle();
								layer.close(index);
							},
							cancel: function(index, layero){ 
								layer.close(index);
							}  
						});
					});
				},function(res){
			
			
				});
			}	
	       
		},
		//删除目录
		delFolder:function(){
			var that = this;
			if(0==this.ids.length){
				layui.use(['layer'], function(){
					layer.msg('请选择',{area:[120,50]});
				});
			}else if(1<this.ids.length){
				layui.use(['layer'], function(){
					layer.msg('不能多选',{area:[120,50]});
				});
			}else{
				that.$refs.folderop.folder.Id=that.ids[0];
				 layui.use(['layer'], function(){
				 	layer.confirm('您确定要删除当前目录吗？', {btn: ['确定','取消'],area:[200,160]},function(index, layero){
						 that.$refs.folderop.delFolderHandle();

				 		layer.close(index);
				 	});
				 });
			}
		},
		//下级目录
		inFolder:function(cid,rid){
			if(undefined==rid){this.rootid=""}
			this.prvid.push(cid);
			this.currid=cid;
			this.currLevel=this.currLevel+1;
			this.upload.rootid=this.rootid;
			this.upload.level=this.currLevel;
			this.lstDirectory(); 
			this.lstVideo(); 
		},
		//上级目录
		upFolder:function(){
			if(0<this.prvid.length){
				this.currid=this.prvid.pop();
				this.currid=this.prvid.pop();
			}
			this.currLevel=this.currLevel-1;
			if(0<this.currLevel){
				this.upload.rootid=this.rootid;
				this.upload.level=this.currLevel;
				this.lstDirectory(); 
				this.lstVideo(); 
			}else{
				this.rootid="";
				this.currid="";
				this.prvid=[];
				this.upload.rootid="";
				this.upload.level=0;
				this.currLevel=0;
				this.lstDirectory(); 
				this.lstVideo(); 
			}
		},
		//上传视频
		addVideo:function(){
			if(0==this.currLevel){
				layui.use(['layer'], function(){
					layer.msg('根目录不能上传视频',{area:[200,50]});
				});
				return 0;
			}
			var upload={
				Video_Id:"",
				Video_Name:"",
			};
			this.$refs.videoop.upload=JSON.parse(JSON.stringify(upload));
			var that = this ;
			layui.use(['layer'], function(){
				layer.open({
						type: 1,
						title:"上传视频",
						content:$('.addVideoTable'),
						area:[400,350],
						btn:'保存视频',
						btnAlign: 'c',
						shade: 0.3 ,
						yes:function(index,layero){
							that.$refs.videoop.addVideoHandle();
							layer.close(index);
						},
						cancel: function(index,layero){ 
							layer.close(index);
						}  
					}); 
				}); 
		},
		//编辑视频
		edtVideo:function(){
			if(0==this.ids.length){
				layui.use(['layer'], function(){
					layer.msg('请选择',{area:[120,50]});
				});
			}else{
				this.$http.post(api.FindVideo,{ids:this.ids[0],token:localStorage.token},{emulateJSON:true}).then(function(res){
					this.$refs.edtvideoop.upload.Video_Id=res.body.data.Video_Id;
					this.$refs.edtvideoop.upload.Video_Path=res.body.data.Video_Path;
					this.$refs.edtvideoop.upload.Video_Name=res.body.data.Video_Name;
					var that=this;
					layui.use(['layer'], function(){
						layer.open({
								type: 1,
								title:"编辑视频",
								content:$('.edtVideoTable'),
								area:[400,350],
								btn:'编辑保存',
								btnAlign: 'c',
								shade: 0.3 ,
								yes:function(index,layero){
									that.$refs.edtvideoop.edtVideoHandle();
									layer.close(index);
								},
								cancel: function(index,layero){ 
									layer.close(index);
								}  
							}); 
						}); 
				},function(res){
				}); 	
			}
		},
		//删除视频
		delVideo:function(){
			if(0==this.ids.length){
				layui.use(['layer'], function(){
					layer.msg('请选择',{area:[120,50]});
				});
			}else{
				var that =this;
				that.$refs.videoop.upload.Video_Id=that.ids[0];
				layui.use(['layer'], function(){
					layer.confirm('您确定要删除当前视频吗？', {btn: ['确定','取消'],area:[200,160]},function(index, layero){
						that.$refs.videoop.delVideoHandle();
						layer.close(index);
					});
				});
			}
		}
	}
});