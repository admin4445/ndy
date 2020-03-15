var dxComponentCountryDataTable ={
    methods:{
        parentGotoPrvinceList:function(id){
            this.$parent.gotoPrvinceList(id);
        },
        parentdelCountry:function(id){
            this.$parent.delCountry(id);
        }
    },
    template:'<table class="layui-table" lay-even lay-size="sm" style="margin:0px;padding:0px;">'
    +'<colgroup>'
    +'  <col width="80">'
    +'  <col width="80">'
    +'  <col>'
    +'  <col width="180">'
    +'</colgroup>'
    +'<thead>'
    +'  <th>ID</th>'
    +'  <th><span>区号</span></th>'
    +'  <th><span>国家</span></th>'
    +'  <th><span>操作</span></th>'
    +'</thead>'
    +'<tbody>'
    +'  <tr v-for="item in this.$parent.countryList">'
    +'    <td><span v-text="item.Country_Id"></span></td>'
    +'    <td><span v-text="item.Country_Number"></span></td>'
    +'    <td><span v-text="item.Country_Name"></span></td>'
    +'    <td>'
    +'      <div class="layui-btn-group">'
    +'        <button class="layui-btn layui-btn-sm" @click="parentGotoPrvinceList(item.Country_Id)"><i class="layui-icon">&#xe715;</i>省份</button><button class="layui-btn layui-btn-sm layui-btn-danger"  @click="parentdelCountry(item.Country_Id)"><i class="layui-icon">&#xe640;</i>删除</button>'
    +'      </div>'
    +'    </td>'
    +'  </tr>'
    +'</tbody>'
    +'</table>'
}