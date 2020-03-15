var dxComponentRoleDataTable ={
    methods:{
        parentEdtRole:function(item){
            this.$parent.edtRole(item);
        },
        parentDelRole:function(id){
            this.$parent.delRole(id);
        },
        parentUpstatus:function(id,status){
            this.$parent.upRoleStatus(id,status);
        },
        parentSelectAll:function(){
            this.$parent.selectAll();
        },
        parentSelectOne:function(id){
            this.$parent.selectOne(id);
        }
    },
    props:{
        checked:Boolean,
        ids:Array,
        rolelist:Array
    },
    template:'<table class="layui-table" lay-even lay-size="sm" style="margin:0px;">'
    +'<colgroup>'
    +'  <col width="50">'
    +'  <col width="50">'
    +'  <col width="200">'
    +'  <col>'
    +'  <col width="200">'
    +'  <col width="85">'
    +'  <col width="155">'
    +'</colgroup>'
    +'<thead>'   
    +'    <th><input type="checkbox" @click="parentSelectAll" class="checkbox1" :checked="checked"></th>'
    +'    <th style="font-weight:bolder;">ID</th>'
    +'    <th style="font-weight:bolder;">角色名称</th>'
    +'    <th style="font-weight:bolder;">角色描述</th>'
    +'    <th style="font-weight:bolder;">创建时间</th>'
    +'    <th style="font-weight:bolder;">角色状态</th>'
    +'    <th style="font-weight:bolder;">角色操作</th>'
    +'</thead>'
    +'<tbody>' 
    +'    <tr v-for="(item,index) in rolelist">'
    +'        <td><input type="checkbox" :value="item.Role_Id" @click="parentSelectOne(item.Role_Id)" class="checkbox1" :checked="checked"></td>'
    +'        <td v-text="item.Role_Id"></td>'
    +'        <td v-text="item.Role_Name"></td>'
    +'        <td v-text="item.Description"></td>'
    +'        <td v-text="item.CreateTime"></td>'
    +'        <td>'
    +'            <div class="layui-form" @click="parentUpstatus(item.Role_Id,item.Status)">'
    +'               <input type="checkbox" lay-skin="switch" lay-text="开启|关闭" :checked ="1==item.Status ? true : false">'
    +'            </div>'
    +'        </td>'
    +'        <td>'
    +'            <div class="layui-btn-group">'
    +'                <div class="layui-btn layui-btn-sm" @click="parentEdtRole(item)"><i class="layui-icon">&#xe642;</i> 编辑</div>'
    +'                <div class="layui-btn layui-btn-sm  layui-btn-danger" @click="parentDelRole(item.Role_Id)"><i class="layui-icon">&#xe640;</i> 删除</div>'
    +'            </div>'
    +'        </td>'
    +'    </tr>'
    +'</tbody>'
    +'</table>'
}