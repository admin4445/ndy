    var dxComponentFloorDataTable ={
        methods:{
            parentGotoCustomer:function(id){
                this.$parent.gotoCustomer(id);
            },
            parentEdtFloor:function(id){
                this.$parent.edtFloor(id);
            },
            parentDelFloor:function(id){
                this.$parent.delFloor(id);
            },
            parentGotoAnswer:function(id){
                localStorage.floorid=id;
                this.$parent.gotoAnswer();
            },
            parentCopyFloor:function(id){
                this.$parent.copy(id);
            },
            parentUpstatus:function(id){
                this.$parent.edtStatus(id);
            },
			parentGotoCount:function(id){
			    this.$parent.gotoCount(id);
			},
            parentjtFloor:function(id,ym){
			    this.$parent.staticsFloor(id,ym);
			},
			parentjtwFloor:function(id,ym){
			    this.$parent.wstaticsFloor(id,ym);
			},
        },
        template:'<div class="floorOp"><table class="layui-table" lay-even lay-size="sm" style="margin:0px;padding:0px;">'
        +'<colgroup>'
        +'    <col width="50">'
        +'    <col>'
		+'    <col width="85">'
        +'    <col width="365">'
        +'    <col width="100">'
        +'    <col width="415">'
        +'</colgroup>'
        +'<tr>'
        +'  <th>编号</th>'
        +'  <th>标题</th>'
		+'  <th>平台</th>'
        +'  <th>预览</th>'
        +'  <th>域名</th>'
        +'  <th>操作</th>'
        +'</tr>'
        +'<tr v-for="item in this.$parent.list" :key="item.Landingpage_Id">'
        +'  <td v-text="item.Landingpage_Id"></td>'
        +'  <td v-text="item.Question.Title"></td>'
		+'  <td v-text="item.Platform"></td>'
        +'  <td>'
        +'      <div class="layui-btn-group">'
        +'          <button class="layui-btn layui-btn-primary layui-btn-sm">'
        +'              <a :href="item.P" target="_blank"><i class="layui-icon">&#xe7ae;</i> 电脑端</a>'
        +'          </button>'
        +'          <button class="layui-btn layui-btn-primary layui-btn-sm">'
        +'              <a :href="item.W" target="_blank"><i class="layui-icon">&#xe678;</i> 移动端</a>'
        +'          </button>'
		+'      <button class="layui-btn layui-btn-sm layui-btn-normal" v-on:click="parentjtFloor(item.Landingpage_Id,item.BindDomain)" >电脑静态页</button>'
		+'      <button class="layui-btn layui-btn-sm layui-btn-normal" @click="parentjtwFloor(item.Landingpage_Id,item.BindDomain)">移动静态页</button>'
        +'      </div>'
        +'  </td>'
        +'  <td v-text="item.BindDomain">'
         //+'   <div class="layui-form" @click="parentUpstatus(item.Landingpage_Id)">'
         //+'    <input type="checkbox" lay-skin="switch" lay-text="开启|关闭" :checked ="1==item.Status ? true : false">'
         //+'    </div>'
        +'  </td>'
        +'  <td>'
        +'    <div class="layui-btn-group">'
        +'      <button class="layui-btn layui-btn-sm layui-btn-normal" @click="parentGotoCustomer(item.Landingpage_Id)"><i class="layui-icon">&#xe606;</i>客服</button>'
        +'      <button class="layui-btn layui-btn-sm" @click="parentGotoAnswer(item.Landingpage_Id)"><i class="layui-icon">&#xe611;</i>回答</button>'
        +'      <button class="layui-btn layui-btn-sm  layui-btn-normal" @click="parentCopyFloor(item.Landingpage_Id)"><i class="layui-icon">&#xe654;</i>复制</button>'
		+'      <button class="layui-btn layui-btn-sm  layui-btn-warm" @click="parentGotoCount(item.Landingpage_Id)"><i class="layui-icon">&#xe857;</i>统计</button>'
        +'      <button class="layui-btn layui-btn-sm" @click="parentEdtFloor(item.Landingpage_Id)"><i class="layui-icon">&#xe642;</i>修改</button>'
        +'      <button class="layui-btn layui-btn-sm layui-btn-danger" @click="parentDelFloor(item.Landingpage_Id)"><i class="layui-icon">&#xe640;</i>删除</button>'
        +'    </div>'
        +'  </td>'
        +'</tr>'
        +'</table>'
		+'</div>'
    }







