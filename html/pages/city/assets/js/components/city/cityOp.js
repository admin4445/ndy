var dxComponentCityOp={
    data:function(){
        return {
            city:{
                City_Number:"",
                City_Name:""
            }
        }
    },
    methods:{
        //添加城市
        addCityHandle:function(){
            this.$http.post(api.addCity,{token:localStorage.token,city:this.city,id:localStorage.Province_Id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    layer.msg(res.body.msg);
                    this.$parent.selectCity();
                }
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
    },
    template:'<table class="layui-table addCity" style="display:none">'
    +'  <tr><td width="50">区号：</td><td><input type="text" class="layui-input" placeholder="请输入区号" v-model="city.City_Number"></td></tr>'
    +'  <tr><td width="50">城市：</td><td><input type="text" class="layui-input" placeholder="请输入城市" v-model="city.City_Name"></td></tr>'
    +'</table>'
}