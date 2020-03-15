//数据交互
new Vue({
	el:'#app',
	components:{
        'dx-component-count-toolbar':dxComponentCountToolBar,
        'dx-component-count-datatable':dxComponentCountDataTable,
    },
	data:{
        CountLst:[],
		number:"",
    },
    mounted:function(){
        this.lstCount();
		this.$refs.navbarop.nav=[
			{name:"落地页",url:"/pages/addon/wenda/question.html"},
			{name:"统计",url:"/pages/addon/wenda/count.html"}
		]
	}, 
    watch:{
        CountLst:function(){
            var that= this;
            that.$nextTick(function(){
                layui.use(['form','element','layer'], function(){ 
					layui.form.render('select');
                    layui.form.on('select(countstatus)', function(data){
                        that.number=data.value;
                    });  
                });
            });
        },
    },
	methods:{
        //查询统计列表接口
        lstCount:function(){
				this.$http.post(api.SelectStatistics,{token:localStorage.token,id:localStorage.count},{emulateJSON:true}).then(function(res){
					if("1"==res.body.code){
						this.CountLst= res.body.data;
						layui.use(['layer'],function(){
						  layer.msg(res.body.msg,{area:[110,50]});
						});
					}
					else{
						layui.use(['layer'],function(){
						  layer.msg(res.body.msg,{area:[110,50]});
						});
					}
				},function(res){
					layui.use(['layer'],function(){
					layer.msg("服务器无响应，请联系技术人员",{offset:'t',icon: 1}); 
					});
				});
			
        },       
        //删除统计
        delCount:function(id){
            // var that = this;
            // layui.use(['layer','form'], function(){
            //     layer.confirm('您确定要删除当前客服吗？',
            //     {btn: ['确定','取消']},
            //     function(index,layero){
            //         that.$http.post(api.DeleteCount,{token:localStorage.token,id:id,ids:localStorage.selects},{emulateJSON:true}).then(function(res){
            //             if("1"==res.body.code){
            //                 that.lstCount();
            //                 layer.close(index);
            //                 layer.msg(res.body.msg);
            //             }
            //             else{
            //                 layer.msg(res.body.msg);
            //             }
            //         },function(res){
            //             layer.msg("服务器无响应，请联系技术人员"); 
            //         });
            //     });
            // });
         },
    },
});