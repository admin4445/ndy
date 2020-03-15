var dxComponentCountToolBar ={
	methods:{
	   CountSelect:function(){
		  this.$http.post(api.SelectCycle,{id:localStorage.count,number:this.$parent.number},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
					    this.$parent.CountLst=res.body.data;
                        layui.use(['layer'],function(){
						  layer.msg(res.body.msg);
						});
					}else{
						layui.use(['layer'],function(){
						  layer.msg(res.body.msg);
						});
					}
 			},function(res){
                 layer.msg("服务器出错，请联系技术人员",{offset:'t',icon: 1}); 
			}); 
	   }
	},
    template:'<div class="layui-row layui-form" style="background:#e3e3e3;height:40px;line-height:40px;">'
    +'<div style="float:left;width:80px;text-align:center;">数据查询</div>'
    +'<div  style="float:left;margin-left:10px;">'
    +'  <select style="float:left;width:80px;text-align:center;" lay-filter="countstatus">'
    +'    <option>请选择周期</option>'
    +'    <option value="1">当天</option>'
    +'    <option value="2">当周</option>'
    +'    <option value="3">当月</option>'
    +'  </select>'
    +'</div>'
    +'<button class="layui-btn layui-btn-sm" style="float:left;margin-top:5px;margin-left:10px;" @click="CountSelect"><i class="layui-icon">&#xe615;</i>查询</button>'
    +'</div>'
}
