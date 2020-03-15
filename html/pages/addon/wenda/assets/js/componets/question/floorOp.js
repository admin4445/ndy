var dxComponentFloorOp ={
    data:function(){
       return{
			floor:{
				Question:{
					Avatar:"/assets/imgs/upload_avatar_icon.png",//提问者头像
					NickName:"",		//提问者昵称
					Title:"",			//提问的标题
					Content:""			//提问的内容
				},
				FllowNum:"",		//问答关注数 
				VisitNum:"",		//问答访问数
				BindDomain:"",	    //绑定的域名
				Copyright:"",		//问答的版权
				Template:"",		//问答的模板
				Status:"1",			//问答的状态
				Platform:"",        //推广平台
				date:"",            //提问时间
				City:""             //提问城市
			},
			tmps:[]
		}
    },
    updated:function(){
      var that =this;
      that.$nextTick(function(){
         layui.use(['form','layer','element'], function(){
            layui.form.on('select(floorstatus)',function(res){
                that.floor.Status=res.value;
            }); 
			 
         });
      });  
    },
    watch:{
		"floor.Question.Avatar":function(val,oval){
			if(0<=this.floor.Question.Avatar.indexOf("base64")){
				this.$http.post(api.UserImg,{"data":val,token:localStorage.token},{emulateJSON:true}).then(function(res){
				   if(1==res.body.code){
						this.floor.Question.Avatar=res.body.data;
						layui.use(['layer'], function(){layer.msg(res.body.msg);});
				   }
				   else{
						layui.use(['layer'], function(){layer.msg(res.body.msg);});
						this.floor.Question.Avatar="/assets/imgs/upload_avatar_icon.png";
				   }
				},function(res){
					layui.use(['layer'], function(){layer.msg("头像上传失败！");});
				});
			}
		},
	},
    methods:{
		onUpload:function(e) {
			var file = e.target.files[0];
			var reader = new FileReader();
			var that = this;
			reader.readAsDataURL(file);
			reader.onload = function(e) {
				that.floor.Question.Avatar= this.result;
			}
		},
    },
    template:' <table class="addfloorpage layui-table" style="display:none;width:100%;margin:0;">'
   +'<colgroup>'
   +'  <col width="95">'
   +'  <col>'
   +'</colgroup>'
   +'<tbody>'
   +'  <tr>'
   +'    <td>提问头像:</td>'
   +'    <td>'
   +'      <img :src="floor.Question.Avatar" class="add_Img" style="width:30px;height:30px;"/>'
   +'      <input type="file" @change="onUpload" value="上传头像" class="add_Input" accept="image/gif,image/jpeg,image/jpg,image/png">'
   +'    </td>'
   +'  </tr>'
   +'  <tr><td>提问昵称:</td><td><input type="text" class="layui-input" placeholder="请输入昵称" v-model="floor.Question.NickName"></td></tr>'
   +'  <tr><td>提问时间:</td><td><input type="text" class="layui-input" placeholder="请输入时间" v-model="floor.Question.Date"></td></tr>'
   +'  <tr><td>提问城市:</td><td><input type="text" class="layui-input" placeholder="请输入城市" v-model="floor.Question.City"></td></tr>'
   +'  <tr><td>提问标题:</td><td><input type="text" class="layui-input" placeholder="请输入标题" v-model="floor.Question.Title"></td></tr>'
   +'  <tr><td>提问内容:</td><td><textarea id="editorbox" style="width:100%;height:300px;" placeholder="请输入提问内容"></textarea></td></tr>'
   +'  <tr><td>访问数量:</td><td><input type="text" class="layui-input" placeholder="请输入访问次数" v-model="floor.VisitNum"></td></tr>'
   +'  <tr><td>关注数量:</td><td><input type="text" class="layui-input" placeholder="请输入关注次数" v-model="floor.FllowNum"></td></tr>'
   +'  <tr><td>绑定域名:</td><td><input type="text" class="layui-input" v-model="floor.BindDomain" placeholder="请输入绑定域名" /></td></tr>'
   +'  <tr><td>问答模板:</td><td><select v-model="floor.Template" class="select1" lay-filter="tempstatus"><option v-for="item in tmps" :value="item.Name">第{{item.Name}}模板</option></select></td></tr>'
   +'  <tr><td>统计代码:</td><td><textarea class="layui-textarea" v-model="floor.CensusCode" placeholder="请输入统计代码"></textarea></td></tr>'
   +'  <tr><td>平台推广:</td><td><input type="text" class="layui-input" v-model="floor.Platform" placeholder="请输入推广平台" /></td></tr>'
   +'  <tr><td>版权版权:</td><td><input type="text" class="layui-input" placeholder="请输入版权信息" v-model="floor.Copyright"></td></tr>'
  // +'  <td>问答状态:</td>'
  // +'    <td>'
  // +'      <div class="layui-form">'
  // +'        <select lay-filter="floorstatus" v-model="floor.Status">'
  // +'          <option value=1>正常</option>'
   //+'          <option value=0>冻结</option>'
   //+'        </select>'
  // +'      </div>'
   //+'    </td>'
   +'  </tr>'
   +'</tbody>'
   +'</table>'
}