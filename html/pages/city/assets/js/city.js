new Vue({
	el:"#app",
	components:{
		'dx-component-city-toolbar':dxComponentCityToolBar,
		'dx-component-city-datatable':dxComponentCityDataTable,
		'dx-component-city-cityop':dxComponentCityOp,
	},
    data:{
		selected:[],
		cityList:[],
		Province_Id:""
	},
	mounted:function(){
		this.selectCity();
			this.$refs.sidepageop.navsCuttle(0);
			this.$refs.navbarop.nav=[
				{name:"省份",url:"#"},
				{name:"城市",url:"#"}
			]
	},
	updated:function(){
        this.$nextTick(function () {
           	layui.use(['layer','form'],function(){
			
			});
        });
    },
    methods:{
        //获取城市
        selectCity:function(ids){
            this.$http.post(api.SelectCity,{token:localStorage.token,Province_Id:localStorage.Province_Id},{emulateJSON:true}).then(function(res){
                if(res.body.code){
					this.cityList=res.body.data;
					layui.use(['layer'],function(){
					 layer.msg(res.body.msg,{area:[110,50]});
				  });
				}else{
                    layui.use(['layer'],function(){
						layer.msg(res.body.msg,{area:[110,50]})
					 });
				}
			},function(res){
				layer.msg("服务器无响应，请联系技术人员"); 
			});
        },
        //添加城市
        addCity:function(){
			var that =this;
			that.$refs.cityop.country={
				City_Number:"",
				City_Name:""
			};
			layui.use(['layer','form','element'], function(){
				layer.open({
					type:1,
					title:"添加城市",
					content:$(".addCity"),
					area:['300px','260px'],
					btn:'确定',
					btnAlign:'c',
					shade:0.3 ,
					yes:function(index,layero){
						that.$refs.cityop.addCityHandle();
						layer.close(index);
					},
					cancel: function(index, layero){ 
						layer.close(index);
					}  
				});
			});
        },
         //弹出删除提示层
		delCity:function(id){
			this.id=id;
			var that=this;
			layui.use(['layer','form'], function(){
				layer.confirm('您确定要删除当前城市吗？',{btn: ['确定','取消']},function(index,layero){
					that.$http.post(api.delCity,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
						if("1"==res.body.code){
							that.selectCity();
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
    },
});
