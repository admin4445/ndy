
new Vue({
	el:'#app',
	components:{
        'dx-component-floor-toolbar':dxComponentFloorToolBar,
        'dx-component-floor-datatable':dxComponentFloorDataTable,
        'dx-component-floor-op':dxComponentFloorOp,
    },
	data:{
      list:[],
      id:"",
	  
    },
    mounted:function(){
        this.selectLandingpage();
		this.lstTemplate();
		this.$refs.navbarop.nav=[
		 	{name:"搜索引擎",url:"/pages/addon/wenda/group.html"},
        	{name:"问答管理",url:"/pages/addon/wenda/question.html"}
		]
    },
    watch:{
        list:function(){
            var that =this;
            this.$nextTick(function(){
            layui.use(['form','element'], function(){
                layui.form.render('checkbox');
                layui.form.render('select');
                layui.form.on('select(floorstatus)', function(data){
                    that.$refs.floorop.floor.Status=data.value;
                });  
            });
        });
    },
	   
    },
	methods:{
        //列表落地页	
        selectLandingpage:function(){
            this.$http.post(api.selectLandingpage,{token:localStorage.token,id:localStorage.Group},{emulateJSON:true}).then(function(res){ 
                if("1"==res.body.code){
                    this.list=res.body.data;
                    layui.use(['layer'], function(){layer.msg(res.body.msg,{area:['110px','50px']});});
                }
                else{
                   layui.use(['layer'], function(){layer.msg(res.body.msg,{area:['110px','50px']});});
                }
			},function(res){
				layui.use(['layer'], function(){layer.msg("与服务器通信失败！");});
			});
        },
		//列表模板页
		lstTemplate:function(){
			var that= this;
			this.$http.post(api.Selecttemplate,{token:localStorage.token},{emulateJSON:true}).then(function(res){ 
                if("1"==res.body.code){
                    that.$refs.floorop.tmps=res.body.data;
                }
                else{
                   layui.use(['layer'], function(){layer.msg("加载模板失败！");});
                }
			},function(res){
				layui.use(['layer'], function(){layer.msg("与服务器通信失败！");});
			});
		},
        //拷贝落地页
        copy:function(id){
            this.id=id;
            var that = this;
            that.$http.post(api.CopyLandingpage,{token:localStorage.token,id:that.id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    that.selectLandingpage();
                    layui.use(['layer'],
						function(){layer.msg(res.body.msg);
                    });
                }
                else{
                    layui.use(['layer'], function(){layer.msg(res.body.msg);});
                }
            },function(res){
                layui.use(['layer'], function(){layer.msg("服务器无响应，请联系技术人员");});
            });
        },
        //修改落地页状态
        edtStatus:function(id){
            this.$http.post(api.UpdataLandingPageStatus,{token:localStorage.token,id:id},{emulateJSON:true}).then(function(res){
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
        //添加提问
        addFloorpage:function(){
			var data={
				Question:{
					Avatar:"/assets/imgs/upload_avatar_icon.png",//提问者头像
					NickName:"",		//提问者昵称
					Title:"",			//提问的标题
					Content:""			//提问的内容
				},
				FllowNum:"",		//问答关注数 
				VisitNum:"",		//问答访问数
				BindDomain:"",	    //绑定的域名
				Copyright:"",		//问答的版权
				Status:"1",			//问答的状态
				Platform:"",        //推广平台
				date:"",            //提问时间
				City:""             //提问城市

			}
            var that =this;
            that.$refs.floorop.floor=JSON.parse(JSON.stringify(data));
			that.$refs.floorop.floor.Question=JSON.parse(JSON.stringify(data.Question));
			layui.use(['layer','form'],function(){
                layer.open({
                    type:1,
                    zIndex:1000,
                    title:"添加提问者信息",
                    content:$('.addfloorpage'),
                    area: ['100%','100%'],
                    btn:'确定',  
                    btnAlign:'c',
                    shade: 0.3 ,
                    yes:function(index,layero){
                        that.$http.post(api.AddLandingpage,{token:localStorage.token,id:localStorage.Group,Floor:that.$refs.floorop.floor},{emulateJSON:true}).then(function(res){
                            if("1"==res.body.code){
                                that.selectLandingpage();
                                layer.msg(res.body.msg); 
                            }else{
                                layer.msg(res.body.msg); 
                            }    
                        },function(res){
                            layer.msg("与服务器通讯失败!"); 
                        });
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
                        'source','|','fontname','fontsize','|','forecolor','hilitecolor','bold','italic','underline',
                        'removeformat','|','justifyleft','justifycenter','justifyright','insertorderedlist',
                        'insertunorderedlist','|','emoticons','uploadimg','link','service'],
                    afterCreate:function(){
                        this.html("");
                    },
                    afterChange:function(){
                        that.$refs.floorop.floor.Question.Content=this.html();   
                    }
                });
            });
        },
        //修改提问
        edtFloor:function(id){
			this.$http.post(api.FindLandingpage,{token:localStorage.token,id:id},{emulateJSON:true}).then(function(res){
				this.$refs.floorop.floor=JSON.parse(JSON.stringify(res.body.data));
				this.$refs.floorop.floor.Question=JSON.parse(JSON.stringify(res.body.data.Question));
				//console.log(this.$refs.floorop.floor.Question);
                var that =this;
                layui.use(['layer','form'], function(){
                    layer.open({type:1,
                        zIndex:1000,
                        title:"修改提问者信息",
                        content: $('.addfloorpage'),
                        area: ['100%','100%'],
                        btn:'确定',
                        btnAlign:'c',
                        shade: 0.3 ,
                        yes:function(index,layero){
                            that.$http.post(api.UpdateLandingpage,{token:localStorage.token,Floor:that.$refs.floorop.floor},{emulateJSON:true}).then(function(res){   
                                if("1"==res.body.code){
                                    that.selectLandingpage();
                                    layer.msg(res.body.msg); 
                                }else{
                                    layer.msg(res.body.msg); 
                                }    
                            },function(res){
                                layer.msg("与服务器通讯失败!"); 
                            });
                            layer.close(index);
                            KindEditor.remove('#editorbox');
                        },
                        cancel: function(index, layero){ 
                            layer.close(index);
                            KindEditor.remove('#editorbox');
                        }  
                    });
                });
                KindEditor.create('#editorbox',{
                    resizeType:1,
                    allowPreviewEmoticons:false,
                    allowImageUpload:false,
                    useContextmenu:true,
                    items : [
                        'source','|','fontname','fontsize','|','forecolor','hilitecolor','bold','italic','underline',
						'removeformat', '|','justifyleft','justifycenter','justifyright','insertorderedlist',
						'insertunorderedlist','|','emoticons','uploadimg','link','service'],
                    afterCreate:function(){
                        this.html(res.body.data.Question.Content);
                    },
                    afterChange:function(){
                        that.$refs.floorop.floor.Question.Content=this.html();
                    }
                });
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });            
        },
		//删除提问
        delFloor:function(id){
            this.id=id;
            var that = this;
            layui.use(['layer','form'], function(){
                layer.confirm('您确定要删除当前问答吗？', {btn: ['确定','取消']},function(index,layero){
                    that.$http.post(api.DeleteLandingpage,{id:id,token:localStorage.token,ids:localStorage.Group},{emulateJSON:true}).then(function(res){
                        if("1"==res.body.code){
                            that.selectLandingpage();
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
	   
		//跳转到回答页面
        gotoAnswer:function(){
            window.location.href="answer.html"
        },
        //进入客服按钮
        gotoCustomer:function(id){
            localStorage.selects=id;
            window.location.href="service.html"
        },
		//进入统计
	    gotoCount:function(id){
		 localStorage.count=id;
		 window.location.href="count.html"
	    },
	    //生成w静态页
		wstaticsFloor:function(id,ym){
			 var yms = 'http://'+ ym + '/index.php/index/Staticshow/index';
		     this.$http.post(yms,{token:localStorage.token,id:id,value:"1"},{emulateJSON:true}).then(function(res){ 
                   layer.msg("生成移动静态页成功");
			},function(res){
			
			});
		},
	    //生成pc静态页
		staticsFloor:function(id,ym){
			
			var yms = 'http://'+ ym + '/index.php/index/Staticshow/index';
			//console.log(yms);
		   this.$http.post(yms,{token:localStorage.token,id:id,value:"0"},{emulateJSON:true}).then(function(res){ 
			    layer.msg("生成电脑静态页成功");
                 //console.log(res);
			},function(res){
				
			});
		},
    }
});