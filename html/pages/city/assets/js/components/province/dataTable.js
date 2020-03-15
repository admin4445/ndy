var dxComponentProvinceDataTable ={
    methods:{
        parentGotoCityList:function(id){
            this.$parent.gotoCityList(id);
        },
        parentdelProvince:function(id){
            this.$parent.delProvince(id);
        }
    },
    template:'<table  class="layui-table" lay-even lay-size="sm">'
    +'<colgroup>'
    +'  <col width="80">'
    +'  <col width="180">'
    +'  <col>'
    +'</colgroup>'
    +'<thead>'
    +'    <th class="number"><span>省号</span></th>'
    +'    <th class="province"><span>省份</span></th>'
    +'    <th class="province"><span>操作</span></th>'
    +'</thead>'
    +'<tbody>'
    +'  <tr v-for="item in this.$parent.provinceList">'
    +'    <td><span v-text="item.Provincial_Number"></span></td>'
    +'    <td><span v-text="item.Province_Name"></span></td>'
    +'    <td>'
    +'      <div class="layui-btn-group">'
    +'        <button class="layui-btn layui-btn-sm" @click="parentGotoCityList(item.Province_Id)"><i class="layui-icon">&#xe715;</i>市</button><button class="layui-btn layui-btn-sm layui-btn-danger" @click="parentdelProvince(item.Province_Id)"><i class="layui-icon">&#xe640;</i>删除</button>'
    +'      </div>'
    +'    </td>'
    +'  </tr>'
    +'</tbody>'
    +'</table>'
}