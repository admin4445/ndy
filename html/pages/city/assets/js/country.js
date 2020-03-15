var vm_city=new Vue({
	el:"#app",
	components:{
		'dx-component-country-toolbar':dxComponentCountryToolBar,
		'dx-component-country-datatable':dxComponentCountryDataTable,
		'dx-component-country-countryop':dxComponentCountryOp
	},
    data:{
        selected:[],
        countryList:[],
	},
	mounted:function(){
		this.selectCountry();
		this.$refs.sidepageop.navsCuttle(0,1);
		this.$refs.navbarop.nav=[
		 	{name:"系统管理",url:"#"},
        	{name:"城市字典",url:"#"}
		]
	},
	watch:{
        countryList:function(){
            var that= this;
            layui.use(['form','element'], function(){
                layui.form.render('select');
            });
        }
    },
    methods:{
        //获取国家列表
        selectCountry:function(){
            this.$http.post(api.SelectCountry,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                if(1==res.body.code){ 
					this.countryList=res.body.data;
					layui.use(['layer'], function(){
					 layer.msg(res.body.msg,{area:[110,50]});
				  });
				}else{
					layui.use(['layer'], function(){
						layer.msg(res.body.msg,{area:[110,50]});
				  });
				}
			},function(res){
				    layer.msg('与服务器通讯失败');
			});
        },
        //添加国家////////////////////////////////////////////////////////////////////////////////////////////////////////
        addCountry:function(){
			var that =this;
			that.$refs.countryop.country={
				Country_Number:"",
				Country:""
			};
			layui.use(['layer','form','element'], function(){
				layer.open({
					type:1,
					title:"添加国家",
					content:$(".addCountry"),
					area:['300px','260px'],
					btn:'确定',
					btnAlign:'c',
					shade:0.3 ,
					yes:function(index,layero){
						that.$refs.countryop.addCountryHandle();
						layer.close(index);
					},
					cancel: function(index, layero){ 
						layer.close(index);
					}  
				});
			});
        },
        
		//弹出删除提示层
		delCountry:function(id){
			this.id=id;
			var that=this;
			layer.confirm('您确定要删除当前国家吗？',{btn: ['确定','取消']},function(index,layero){
				that.$http.post(api.delCountry,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
					if("1"==res.body.code){
						that.selectCountry();
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
		},
        gotoPrvinceList:function(id){
            localStorage.Country_Id=id;
            window.location.href="province.html"
        },
    },
});