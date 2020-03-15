var dxComponentCountDataTable ={
    methods:{
        parentEdtCount:function(id){
            this.$parent.edtCount(id);
        },
        parentDelCount:function(id){
            this.$parent.delCount(id);
        },
    },
template:'<div class="countTable"><table class="layui-table" lay-even lay-size="sm" style="margin:0px;padding:0px;">'
    +'<colgroup>'
    +'    <col width="50">'
    +'    <col width="100">'
    +'    <col width="150">'
    +'    <col width="300">'
    +'    <col width="150">'
    +'    <col width="60">'
    +'    <col width="60">'
    +'    <col width="60">'
    +'    <col>'
    +'</colgroup>'
    +'<thead>  ' 
    +'<tr>'
    +'  <th>编号</th>'
    +'  <th>昵称</th>'
    +'  <th>电话</th>'
    +'  <th>关键字</th>'
    +'  <th>时间</th>'
    +'  <th>ip</th>'
    +'  <th>地区</th>'
    +'  <th>城市</th>'
    +'  <th>操作</th>'
    +'</tr>'
    +' </thead>'
    +'<tbody> '
    +'  <tr v-for="item in this.$parent.CountLst">'
    +'    <td v-text="item.Statistics_Id"></td>'
    +'    <td v-text="item.NickName"></td>'
    +'    <td v-text="item.Tel"></td>'  
    +'    <td v-text="item.Keyword"></td>' 
    +'    <td v-text="item.Time"></td>' 
    +'    <td v-text="item.Ip"></td>' 
    +'    <td v-text="item.Region"></td>' 
    +'    <td v-text="item.City"></td>' 
    +'    <td>'
    +'      <div class="layui-btn-group">'
    +'        <button class="layui-btn layui-btn-sm layui-btn-danger" style="margin-left:5px;" @click="parentDelCount(item.Statistcs_Id)"><i class="layui-icon">&#xe640;</i>删除</button>'
    +'     </div>'
    +'    </td>'
    +'  </tr>'
    +'</tbody>'
    +'</table>'
	+'</div>'
}