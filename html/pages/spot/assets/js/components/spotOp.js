var dxComponentSpotOp ={
    data:function () {
        return {
            addspot:{
                ScenicSpot_Type:"",
                ScenicSpot_Name:"",
                ScenicSpot_Introduction:"",
            },
            selectedCountry:"",
            selectedProvince:"",
            selectedCity:"",
            province:[],
            city:[], 
        }
    },
    watch:{
        //监听国家
        selectedCountry:function(){
            this.selectedProvince="",
            this.selectedCity="",
            this.$http.post(api.SelectProvince,{token:localStorage.token,name:this.selectedCountry},{emulateJSON:true}).then(function(res){
                this.province=res.body.data;
                this.selectedProvince = res.body.data[0]["Province_Name"];
            },function(res){
                
            });
        },
        //监听省份
        selectedProvince:function(){
            this.selectedCity="",
            this.$http.post(api.SelectCitylist,{token:localStorage.token,name:this.selectedProvince},{emulateJSON:true}).then(function(res){
                this.city=res.body.data;
                this.selectedCity = res.body.data[0]["City_Name"];
            },function(res){
                
            });
        },
    },  
    methods:{
        //添加提交
        addSpotHandle:function(){
            this.$http.post(api.Addspot,{token:localStorage.token,addspot:this.addspot,selectedCity:this.selectedCity},{emulateJSON:true}).then(function(res){
                if(1==res.body.code){
                    this.$parent.lstSpot(); 
                    layer.msg(res.body.msg)
              }else{
               layer.msg(res.body.msg); 
             }    
               },function(res){
                layer.msg("与服务器通讯失败!"); 
               });
        },
        //编辑提交
        edtSpotHandle:function(){
            this.$http.post(api.Updatespot,{token:localStorage.token,editspot:this.addspot},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstSpot(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
           //查询单个数据
           Findspot:function(id){
            this.$http.post(api.Findspot,{token:localStorage.token,id:id},{emulateJSON:true}).then(function(res){
                this.selectedCountry = res.body.data[0].Country_Name;
                this.selectedProvince = res.body.data[0].Province_Name;
                this.selectedCity = res.body.data[0].City_Name;
                this.addspot= res.body.data[0];
            },function(res){
            });  
        },
        //删除提交
        delSpotHandle:function(id){
            this.$http.post(api.Deletespot,{token:localStorage.token,id:id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstSpot(); 
                    layer.close(index);
                    layer.msg(res.body.msg);
                }
                else{
                    layer.msg(res.body.msg);
                }
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        }
    },
    template:
            '<table class="layui-table addSpotTable" style="display:none;">'
            +'<colgroup>'
            +'<col width="100">'
            +'<col>'
            +'</colgroup>'
            +'<tbody>'
            +'<tr>'
            +'<td>所在城市</td>'
            +'<td>'
            +   '<select class="spot_Select" v-model="selectedCountry">'
            +       '<option disabled value="">国家</option>'
            +       '<option v-for="item in this.$parent.country" v-text="item.Country_Name"></option>'
            +     '</select>'
            +     '<select class="spot_Select" v-model="selectedProvince">'
            +        '<option disabled value="">省份</option>'
            +        '<option v-for="item in province" v-text="item.Province_Name"></option>'
            +      '</select>'
            +      '<select class="spot_Select" v-model="selectedCity">'
            +        '<option disabled value="">城市</option>'
            +        '<option v-for="item in city" v-text="item.City_Name"></option>'
            +      '</select>'
            +   '</td>'
            + '</tr>'
            +'<tr>'
            +   '<td>景点类型</td>'
            +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入景点类型" autocomplete="off" class="layui-input" v-model="addspot.ScenicSpot_Type"></td>'
            +'</tr>'
            +'<tr>'
            +   '<td>景点名称</td>'
            +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入景点名称" autocomplete="off" class="layui-input" v-model="addspot.ScenicSpot_Name"></td>'
            +'</tr>'
            +'<tr>'
            +   '<td>景点介绍</td>'
            +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入景点介绍" autocomplete="off" class="layui-input" v-model="addspot.ScenicSpot_Introduction"></td>'
            +'</tr>'
            +'<tr>'
            +   '<td>景点图片</td>'
            +'</tr>'
            +'</tbody>'
            +'</table>'

}