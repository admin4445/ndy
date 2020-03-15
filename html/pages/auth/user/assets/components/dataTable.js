var dxComponentUserDataTable ={

    // updated:function(){
  
    // },
    
    mounted:function(){
    },
    methods:{
        parentEdtUser:function(id){this.$parent.edtUser(id);},
        parentDelUser:function(id){this.$parent.delUser(id);},
        parentUpstatus:function(id){
            this.$parent.upUserStatus(id);
        },
        parentEdtPwd:function(id){
            this.$parent.EdtPwd(id);
        }
    },
    template:'<table class="layui-table" lay-even lay-size="sm" style="margin:0px;">'
    +'<colgroup>'
    +'<col width="50">'
    +'<col width="50">'
    +'<col width="120">'
    +'<col width="120">'
    +'<col width="120">'
    +'<col width="120">'
    +'<col width="120">'
    +'<col>'
    +'<col width="90">'
    +'<col width="225">'
    +'</colgroup>'
    +'<thead>'
    +'    <th style="font-weight:bolder;">ID</th>'
    +'    <th style="font-weight:bolder;">头像</th>'
    +'    <th style="font-weight:bolder;">姓名</th>'
    +'    <th style="font-weight:bolder;">电话</th>'
    +'    <th style="font-weight:bolder;">微信</th>'
    +'    <th style="font-weight:bolder;">邮箱</th>'
    +'    <th style="font-weight:bolder;">账号</th>'
    +'    <th style="font-weight:bolder;">所属角色</th>'
    +'    <th style="font-weight:bolder;">状态</th>'
    +'    <th style="font-weight:bolder;">操作</th>'
    +'</thead>'
    +'<tbody>'   
    +'    <tr v-for="item in this.$parent.userList.pageList">'
    +'        <td v-text="item.User_Id"></td>'
    +'        <td><img :src="item.User_Img" width="30" height="30" /></td>'
    +'        <td v-text="item.Name"></td>'
    +'        <td v-text="item.Tel"></td>'
    +'        <td v-text="item.Wechat"></td>'
    +'        <td v-text="item.Email"></td>'
    +'        <td v-text="item.UserName"></td>'
    +'        <td v-text="item.Role_Name"></td>'
    +'        <td>'
    +'            <div class="layui-form" @click="parentUpstatus(item.User_Id)">'
    +'               <input type="checkbox" lay-skin="switch" lay-text="开启|关闭" :checked ="1==item.Status ? true : false">'
    +'            </div>'
    +'        </td>'
    +'        <td>'
    +'            <div class="layui-btn-group">'
	+'                <button class="layui-btn layui-btn-sm" @click="parentEdtPwd(item.User_Id)"><i class="layui-icon">&#xe673;</i> 改密</button>'
    +'                <button class="layui-btn layui-btn-sm layui-btn-normal" @click="parentEdtUser(item.User_Id)"><i class="layui-icon">&#xe642;</i> 编辑</button>'
    +'                <button class="layui-btn layui-btn-sm  layui-btn-danger" @click="parentDelUser(item.User_Id)"><i class="layui-icon">&#xe640;</i> 删除</button>'
    +'            </div>'
    +'        </td>'
    +'    </tr>'
    +'</tbody>'
    +'</table>'
}