//数据交互
new Vue({
	el:'#app',
	components:{
		'dx-component-order-toolbar':dxComponentOrderToolBar,
		'dx-component-order-datatable':dxComponentOrderDataTable,
		'dx-component-order-op':dxComponentOrderOp
	},
	data:{
		orderList:[],
	},
	mounted:function () {
		this.lstOrder();
		this.$refs.sidepageop.navsCuttle(7,0);
		this.$refs.navbarop.nav=[
		 	{name:"订单管理",url:"#"},
        	{name:"旅游订单",url:"#"}
		]
	},
	methods:{
		//列表订单//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		lstOrder:function(){
			var that = this;
			layui.use(['layer'],function(){
				that.$http.post(api.Selectorder,{token:localStorage.token},{emulateJSON:true}).then(function(res){
					if("1"==res.body.code){
						that.orderList=res.body.data;
						layer.msg(res.body.msg); 
					}
					else{
						layer.msg(res.body.msg); 
					}
				},function(res){
					layer.msg("服务器无响应，请联系技术人员",{offset:'t',icon: 1}); 
				});
			});
		},
		//添加订单////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		addOrder:function(){
			var that = this;
			var order={
				Contacts:"",
				Telephone:"",
				Number:"",
				Trip:"",
				TotalSum:"",
				Deposit:"",
				Remarks:"",
				Operator:"",
				token:localStorage.token
			};
			that.$refs.orderop.mode=false;
			that.$refs.orderop.order=order;
			layui.use(['layer'], function(){
				layer.open({
					type:1,
					title:"添加订单",
					content:$('.orderTable'),
					area:['500','80%'],
					btn:'保存订单',
					btnAlign:'c',
					shade: 0.3 ,
					yes:function(index,layero){
						that.$refs.orderop.addOrderHandle();
						layer.close(index);
					},
					cancel:function(index, layero){ 
						layer.close(index);
					}  
				});
			});
		},
		//编辑订单///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		edtOrder:function(order){
			var that=this;
			layui.use(['layer','form','element'],function(){
				that.$refs.orderop.order=order;
				that.$refs.orderop.order.token=localStorage.token;
				that.$refs.orderop.mode=2;
				$('option[value="'+parseInt(order.Status)+'"]').prop("selected",true);
				$('option[value!="'+parseInt(order.Status)+'"]').prop("selected",false);
				layui.form.render(null,'orderTable');
				layui.form.on('select(orderStatus)',function(res){
				 	that.$refs.orderop.order.Status=parseInt(res.value);
				}); 
				layer.open({
					type: 1,
					title:"编辑订单",
					content: $('.orderTable'),
					area: ['500','80%'],
					btn: '编辑修改',
					btnAlign:'c',
					shade:0.3 ,
					yes:function(index, layero){
						that.$refs.orderop.edtOrderHandle();
						layer.close(index);
					},
					cancel:function(index, layero){ 
						layer.close(index);
					}  
				});
			});
		},
		//删除订单//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		delOrder:function(id){
			var that = this;
			layer.confirm('您确定要删除当前订单吗？', {btn: ['确定','取消']},function(index,layero){
				that.$http.post(api.Deleteorder,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
					if("1"==res.body.code){
						that.lstOrder();
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
		}
	}
});