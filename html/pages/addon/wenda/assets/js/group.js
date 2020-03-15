new Vue({
	el:'#app',
	components:{
        'dx-component-group-datatable': dxComponentGroupDataTable,
        'dx-component-group-toolbar':dxComponentGroupToolBar,
        'dx-component-group-groupop':dxComponentGroupOp
    },
	data:{
        Name:"",
        Group:[],
        id:"",
    },
    mounted:function(){
        this.SelectGroup();
		this.$refs.navbarop.nav=[
		 	{name:"营销推广",url:"/pages/addon/home/Index.html"},
        	{name:"搜索引擎",url:"/pages/addon/wenda/group.html"}
		]
    },
	methods:{	
        //列表分组
		SelectGroup:function(){
            this.$http.post(api.SelectGroup,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                this.Group=res.body.data;
                if("1"==res.body.code){
                    layui.use(['layer'],function(){
                        layer.msg(res.body.msg,{area:[110,50]});
                    });
                }else{
                    layui.use(['layer'],function(){
                        layer.msg(res.body.msg,{area:[110,50]});
                    });
                }
              
			},function(res){
			});
        },
        //添加弹出层
        addbtn:function(){
            var that =this;
            that.$refs.groupop.group.Name="";
            layui.use(['layer'],function(){
                layer.open({
                    type:1,
                    title:"添加问答分组",
                    content: $('.addplug'),
                    area: ['300px','200px'],
                    btn:'确定',
                    btnAlign:'c',
                    shade: 0.3,
                yes:function(index,layero){
                    that.$refs.groupop.addGroupHandle();
                    layer.close(index);
                },
                cancel: function(index, layero){ 
                    layer.close(index);
                }  
            });
            });
        },
        //弹出修改框
        edtGroup:function(id){
            this.$http.post(api.FindGroup,{token:localStorage.token,id:id},{emulateJSON:true}).then(function(res){
                this.$refs.groupop.group.Name=res.body.data.Group_Name;
                this.$refs.groupop.id=res.body.data.Group_Id;
                var that =this;
                layui.use(['layer'],function(){
                    layer.open({
                        type:1,
                        title:"修改问答分组",
                        content: $('.addplug'),
                        area: ['300px','200px'],
                        btn:'确定',
                        btnAlign:'c',
                        shade: 0.3,
                    yes:function(index,layero){
                        that.$refs.groupop.edtGroupHandle();
                        layer.close(index);
                    },
                    cancel: function(index, layero){ 
                        layer.close(index);
                    }  
                });
                });
			},function(res){
			});
        },
        //删除弹出框
        delGroup:function(id){
            this.id=id;
            var that = this;
            layui.use(['layer','form'],function(){
                layer.confirm('您确定要删除当前组吗？', {btn: ['确定','取消']},function(index,layero){
                    that.$http.post(api.DeleteGroup,{token:localStorage.token,id:that.id},{emulateJSON:true}).then(function(res){
                        if("1"==res.body.code){
                            that.SelectGroup();
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
        //进入落地页
        lodingPage:function(id){
            localStorage.Group=id;
            window.location.href="question.html"
        },
	},
});