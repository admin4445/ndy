    var dxComponentProvinceOp={
        data:function(){
            return {
                province:{
                    Province_Number:"",
                    Province:"",
                }
            }
        },
        methods:{
            //添加省份
            addProvinceHandle:function(id){
                this.$http.post(api.addProincial,{token:localStorage.token,province:this.province,id:localStorage.Country_Id},{emulateJSON:true}).then(function(res){
                    if("1"==res.body.code){
                        layer.msg(res.body.msg);
                        this.$parent.selectProincial();
                    }
                },function(res){
                    layer.msg("与服务器通讯失败!"); 
                });
            },
        },
        template:'<table class="layui-table addProvince" style="display:none">'
        +'  <tr><td width="50">省号：</td><td><input type="text" class="layui-input" placeholder="请输入省号" v-model="province.Province_Number"></td></tr>'
        +'  <tr><td width="50">省份：</td><td><input type="text" class="layui-input" placeholder="请输入省份名" v-model="province.Province"></td></tr>'
        +'</table>'
    }