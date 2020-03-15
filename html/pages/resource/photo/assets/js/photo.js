new Vue({
	el:'#app',
	components:{
		'dx-component-photo-toolbar':dxComponentPhotoToolBar,
		'dx-component-folder-foldertable':dxComponentFolderTable,
		'dx-component-photo-phototable':dxComponentPhotoTable,
		'dx-component-folder-folderop':dxComponentFolderOp,
		'dx-component-photo-folderop':dxComponentPhotoOp,
	},
	data:{
		prvid:[],
		currid:"",
		rootid:"",
		currLevel:0,
		ids:[],
		upload:{}
	},
	mounted:function () {
		this.lstDirectory();
		this.lstImg();
		this.$refs.navbarop.nav=[
		 	{name:"资源管理",url:"#"},
        	{name:"图片管理",url:"#"}
		]
	},
	updated:function () {
		this.$nextTick(function () {
			layui.use(['form','layer','element'], function(){
				 layui.form.render('checkbox');
				 layui.form.render('select');
			});
		 }); 
	},
	methods:{
		//列表图片
		lstImg:function(){
			this.$http.post(api.SelectImg,{token:localStorage.token,rootid:this.rootid,level:this.currLevel,pid:this.currid},{emulateJSON:true}).then(function(res){
				this.$refs.listPhoto.fileList=res.body.data;
				this.$refs.listPhoto.ids=[];
			},function(res){

			});
		},
		//列表目录
		lstDirectory:function(){
			this.$http.post(api.ListCatalog,{level:this.currLevel,token:localStorage.token,pid:this.currid},{emulateJSON:true}).then(function(res){
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
				layui.use(['layer'], function(){layer.msg('请选择',{area:[120,50]});});
			}else if(1<that.ids.length){
				layui.use(['layer'], function(){layer.msg('不能多选',{area:[120,50]});});
			}else{
				that.$http.post(api.FindCatalog,{ids:that.ids,token:localStorage.token},{emulateJSON:true}).then(function(res){
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
					layui.use(['layer'], function(){layer.msg('与服务器通讯失败！',{area:[120,50]});});
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
				 	layer.confirm('您确定要删除当前目录吗？', {btn: ['确定','取消'],area:[200,160]},function(index,layero){
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
			this.lstImg(); 
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
				this.lstImg(); 
			}else{
				this.rootid="";
				this.currid="";
				this.prvid=[];
				this.upload.rootid="";
				this.upload.level=0;
				this.currLevel=0;
				this.lstDirectory(); 
				this.lstImg(); 
			}
		},
		//上传图片
		addPhoto:function(){
			if(0==this.currLevel){
				layui.use(['layer'], function(){
					layer.msg('根目录不能上传图片',{area:[200,50]});
				});
				return 0;
			}
			var upload={
				Img_Name:"",
                upload_Img:"/assets/imgs/upload_avatar_icon.png" 
			};
			this.$refs.photoop.upload=JSON.parse(JSON.stringify(upload));
			var that = this ;
			layui.use(['layer'], function(){
				layer.open({
						type: 1,
						title:"上传图片",
						content:$('.addPhotoTable'),
						area:[400,350],
						btn:'保存图片',
						btnAlign: 'c',
						shade: 0.3 ,
						yes:function(index,layero){
							that.$refs.photoop.addPhotoHandle();
							layer.close(index);
						},
						cancel: function(index,layero){ 
							layer.close(index);
						}  
					}); 
				}); 
		},
		//编辑图片
		edtPhoto:function(){
			if(0==this.ids.length){
				layui.use(['layer'], function(){
					layer.msg('请选择',{area:[120,50]});
				});
			}else{
				this.$http.post(api.Findimg,{token:localStorage.token,ids:this.ids[0]},{emulateJSON:true}).then(function(res){
					this.$refs.photoop.upload.Img_Id=res.body.data.Img_Id;
					this.$refs.photoop.upload.upload_Img=res.body.data.Img_Path;
					this.$refs.photoop.upload.Img_Name=res.body.data.Img_Name;
					var that=this;
					layui.use(['layer'], function(){
						layer.open({
								type: 1,
								title:"编辑图片",
								content:$('.addPhotoTable'),
								area:[400,350],
								btn:'保存图片',
								btnAlign: 'c',
								shade: 0.3 ,
								yes:function(index,layero){
									that.$refs.photoop.edtPhotoHandle();
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
		//删除图片
		delPhoto:function(){
			if(0==this.ids.length){
				layui.use(['layer'], function(){
					layer.msg('请选择',{area:[120,50]});
				});
			}else{
				var that =this;
				that.$refs.photoop.upload.Img_Id=that.ids[0];
				layui.use(['layer'], function(){
					layer.confirm('您确定要删除当前图片吗？', {btn: ['确定','取消'],area:[200,160]},function(index, layero){
						that.$refs.photoop.delPhotoHandle();
						layer.close(index);
					});
				});
			}
		}
	}
});