var dxComponentAnswerDataTable ={
	 data:function () {
        return {
			xx:"点击复制"
        }
    },
    methods:{
		setClass(key) {
			str="a";
			str+=key;
            return str
        },
		setClasss(key) {
			str=".a";
			str+=key;
            return str
        },
        parentEdtAnswer:function(id){
            this.$parent.edtAnswer(id);
        },
        parentDelAnswer:function(id){
            this.$parent.delAnswer(id);
        },
        parentAddReply:function(id){
            this.$parent.addReply(id);
        },
        parentAddReplyMy:function(id,rid){
          var clipboard = new ClipboardJS('.btn');
		  //成功回调
          clipboard.on('success', function(e) {
          console.info('Action:', e.action);
          console.info('Text:', e.text);
          console.info('Trigger:', e.trigger);
          e.clearSelection();
          
      });
      clipboard.on('error', function(e) {
          console.error('Action:', e.action);
          console.error('Trigger:', e.trigger);
      });
            this.$parent.AddReplyMy(id,rid);
        },
    },
    template:'<div class="DataBox"><table class="layui-table" lay-even lay-size="sm" style="margin:0px;padding:0px;">'
    +'<colgroup>'
    +'  <col width="200">'
    +'  <col width="120">'
    +'  <col width="120">'
    +'  <col width="120">'
    +'  <col width="120">'
    +'  <col width="120">'
	+'  <col width="120">'
    +'  <col>'
    +'  <col width="285">'
    +'  </colgroup>'
    +'<thead>'
    +'  <tr>'
    +'    <th>编号</th>'
    +'    <th>头像</th>'
    +'    <th>昵称</th>'
    +'    <th>等级</th>'
    +'    <th>积分</th>'
    +'    <th>标签</th>'
    +'    <th>时间</th>'
    +'    <th>@谁</th>'
    +'    <th>操作</th>'
    +'  </tr>'
    +'</thead>'
    +'<tbody>'
    +'<tr v-for="(item,index) in this.$parent.request">'
    +'  <td><input type="text" :class="setClass(index)" v-model="item.ID" style="width:95px;height:30px;border-radius:3px;border:none;border:1px #48affc solid;"readonly="readonly"> <button class="layui-btn layui-btn-sm layui-btn-normal btn" @click="parentAddReplyMy(item.ID,item.RootId)" :data-clipboard-target="setClasss(index)" style="">{{xx}}</button></td>'
    +'  <td> <img :src="item.Avatar" width="30" height="30" class="add_Img"/></td>'
    +'  <td v-text="item.Name"></td>'
    +'  <td v-text="item.Grade"></td>'
    +'  <td v-text="item.Integral"></td>'
    +'  <td v-text="item.Label"></td>'
    +'  <td v-text="item.Date"></td>'
    +'  <td v-text="item.PID"></td>'
    +'  <td >'
    +'      <div class="layui-btn-group">'
    +'         <button class="layui-btn layui-btn-sm layui-btn-normal" @click="parentAddReply(item.ID)"><i class="layui-icon">&#xe60c;</i> AT我</button>'
    +'         <button class="layui-btn layui-btn-sm" @click="parentEdtAnswer(item.ID)"><i class="layui-icon">&#xe642;</i> 修改</button>'
    +'         <button class="layui-btn layui-btn-sm layui-btn-danger" @click="parentDelAnswer(item.ID)"><i class="layui-icon">&#xe640;</i> 删除</button>'
    +'      </div>'
    +'  </td>'
    +'</tr>'
    +'</tbody>'
    +'</table>'
	+'</div>'
}