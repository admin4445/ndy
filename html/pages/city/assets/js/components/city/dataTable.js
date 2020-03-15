var dxComponentCityDataTable ={
    methods:{
        parentdelCity:function(id){
            this.$parent.delCity(id);
        }
    },
    template:'<table class="layui-table" lay-even lay-size="sm">'
    +'<colgroup>'
    +'  <col width="80">'
    +'  <col width="80">'
    +'  <col width="120">'
    +'  <col>'
    +'</colgroup>'
    +'<thead>'
    +'  <th><span>区号</span></th>'
    +'  <th><span>市</span></th>'
    +'  <th><span>操作</span></th>'
    +'</thead>'
    +'<tbody>'
    +'<tr v-for="item in this.$parent.cityList">'
    +'  <td><span v-text="item.City_Number"></span></td>'
    +'  <td><span v-text="item.City_Name"></span></td>'
    +'  <td width="120">'
    +'    <div class="layui-btn-group">'
    +'      <button class="layui-btn layui-btn-sm layui-btn-danger" @click="parentdelCity(item.City_Id)"><i class="layui-icon">&#xe640;</i>删除</button>'
    +'    </div>'
    +'  </td>'
    +' </tr>'
    +'</tbody>'
    +' </table>'
}