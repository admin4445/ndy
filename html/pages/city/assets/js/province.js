var vm_province=new Vue({
	el:"#app",
	components:{
		'dx-component-province-toolbar':dxComponentProvinceToolBar,
		'dx-component-province-datatable':dxComponentProvinceDataTable,
		'dx-component-province-provinceop':dxComponentProvinceOp,
	},
    data:{
		selected:[],
		provinceList:[],
		Country_Id:""
	},
	mounted:function(){
		this.selectProincial();
				this.$refs.sidepageop.navsCuttle(0);
				this.$refs.navbarop.nav=[
					{name:"国家",url:"#"},
					{name:"省份",url:"#"}
				]
	},
	watch:{
        provinceList:function(){
            var that= this;
            layui.use(['form','element'], function(){
                layui.form.render('select');
            });
        }
    },
    methods:{
        //获取省份
        selectProincial:function(id){
            this.$http.post(api.SelectProincial,{token:localStorage.token,id:localStorage.Province_Id,Country_Id:localStorage.Country_Id},{emulateJSON:true}).then(function(res){
                if(1==res.body.code){ 
					this.provinceList=res.body.data;
					layui.use(['layer'], function(){
					 layer.msg(res.body.msg,{area:[110,50]});
				 });
				}else{
					layui.use(['layer'], function(){
						layer.msg(res.body.msg,{area:[110,50]});
					});
				}
			},function(res){
				layer.msg("服务器无响应，请联系技术人员"); 
			});
        },
        //添加省份
        addprovince:function(id){
			var that =this;
			that.$refs.provinceop.province={
				Province_Number:"",
				Province:""
			};
			layui.use(['layer','form','element'], function(){
				layer.open({
					type:1,
					title:"添加省份",
					content:$(".addProvince"),
					area:['300px','260px'],
					btn:'确定',
					btnAlign:'c',
					shade:0.3 ,
					yes:function(index,layero){
						that.$refs.provinceop.addProvinceHandle();
						layer.close(index);
					},
					cancel: function(index, layero){ 
						layer.close(index);
					}  
				});
			});
        },
        //弹出删除提示层
		delProvince:function(id){
			this.id=id;
			var that=this;
			layer.confirm('您确定要删除当前省份吗？',{btn: ['确定','取消']},function(index,layero){
				that.$http.post(api.delProvince,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
					if("1"==res.body.code){
						that.selectProincial();
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
		gotoCityList:function(id){
            localStorage.Province_Id=id;
            window.location.href="City.html"
        },
    },
});
