    var dxComponentGroupDataTable ={
        methods:{
            parentEdtGroup:function(id){
                this.$parent.edtGroup(id);
            },
            parentDelGroup:function(id){
                this.$parent.delGroup(id);
            },
            parentlodingPage:function(id){
                this.$parent.lodingPage(id);
            }
        },
    template:'<table class="layui-table" lay-even lay-size="sm" style="margin:0px;padding:0px;">'
        +'<colgroup>'
        +'  <col width="50">'
        +'  <col>'
        +'  <col width="212">'
        +'</colgroup>'
        +'<thead>'
        +'  <tr>'
        +'    <th>ID</th>'
        +'    <th>问答分组</th>'
        +'    <th>操作</th>'
        +'  </tr>'
        +'</thead>'
        +'<tbody> '
        +'  <tr v-for="item in this.$parent.Group" :key="item.Group_Id">'
        +'    <td v-text="item.Group_Id"></td>'
        +'    <td v-text="item.Group_Name"></td>'
        +'    <td>'
        +'      <div class="layui-btn-group">'
		+'        <button @click="parentlodingPage(item.Group_Id)" class="layui-btn layui-btn-sm layui-btn-normal"><i class="layui-icon">&#xe857;</i>列表</button>'
        +'        <button @click="parentEdtGroup(item.Group_Id)" class="layui-btn layui-btn-sm"><i class="layui-icon">&#xe642;</i>修改</button>'
        +'        <button @click="parentDelGroup(item.Group_Id)" class="layui-btn layui-btn-sm  layui-btn-danger"><i class="layui-icon">&#xe640;</i>删除</button>'
        +'      </div>'
        +'    </td>'
        +'  </tr>'
        +'</tbody>'
        +'</table>'
    }