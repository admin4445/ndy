var dxComponentCustomerDataTable ={
    methods:{
        parentEdtCustomer:function(id){
            this.$parent.edtCustomer(id);
        },
        parentDelCustomer:function(id){
            this.$parent.delCustomer(id);
        },
        parentEdtStatus:function(id){
            this.$parent.edtStatus(id);
        },
    },
template:'<table class="layui-table" lay-even lay-size="sm" style="margin:0px;padding:0px;">'
    +'<colgroup>'
    +'    <col width="50">'
    +'    <col width="50">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="80">'
    +'    <col width="150">'
    +'    <col width="150">'
    +'    <col width="150">'
    +'    <col width="150">'
    +'    <col width="80">'
    +'    <col>'
    +'</colgroup>'
    +'<thead>  ' 
    +'<tr>'
    +'  <th>ID</th>'
    +'  <th>头像</th>'
    +'  <th>名称</th>'
    +'  <th>性别</th>'
    +'  <th>用户</th>'
    +'  <th>电话</th>'
    +'  <th>微信</th>'
    +'  <th>状态</th>'
    +'  <th>操作</th>'
    +'</tr>'
    +' </thead>'
    +'<tbody> '
    +'  <tr v-for="item in this.$parent.CustomerLst">'
    +'    <td v-text="item.Id"></td>'
    +'    <td><img :src="item.Photo" width="30" height="30" /></td>'
    +'    <td v-text="item.CustomerService_Name"></td>'
    +'    <td><span v-if="1==item.CustomerService_Sex">男</span><span v-if="0==item.CustomerService_Sex">女</span></td>'
    +'    <td v-text="item.Pid"></td>'
    +'    <td v-text="item.CustomerService_Tel"></td>'
    +'    <td v-text="item.CustomerService_Wechat"></td>'
    +'    <td>'
    +'      <div class="layui-form" @click="parentEdtStatus(item.Id)">'
    +'        <input type="checkbox" lay-skin="switch" lay-text="开启|关闭" :checked ="1==item.Status? true : false">'
    +'      </div>'
    +'    </td>'       
    +'    <td>'
    +'      <div class="layui-btn-group">'
    +'        <button class="layui-btn layui-btn-sm" @click="parentEdtCustomer(item.Id)"><i class="layui-icon">&#xe642;</i>编辑</button>'
    +'        <button class="layui-btn layui-btn-sm layui-btn-danger" style="margin-left:5px;" @click="parentDelCustomer(item.Id)"><i class="layui-icon">&#xe640;</i>删除</button>'
    +'     </div>'
    +'    </td>'
    +'  </tr>'
    +'</tbody>'
    +'</table>'
}