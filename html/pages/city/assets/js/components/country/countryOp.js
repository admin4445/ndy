var dxComponentCountryOp={
    data:function(){
        return {
            country:{
                Country_Number:"",
                Country:""
            }
        }
    },
    methods:{
        //添加国家
        addCountryHandle:function(){
            this.$http.post(api.addCountry,{token:localStorage.token,country:this.country},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    layer.msg(res.body.msg);
                    this.$parent.selectCountry();
                }else{
                    layer.msg(res.body.msg);
                }
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
    },
    template:'<table class="layui-table addCountry" style="display:none">'
    +'  <tr><td width="50">区号：</td><td><input type="text" class="layui-input" placeholder="请输入区号" v-model="country.Country_Number"></td></tr>'
    +'  <tr><td width="50">国家：</td><td><input type="text" class="layui-input" placeholder="请输入国家" v-model="country.Country"></td></tr>'
    +'</table>'
}