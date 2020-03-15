var dxComponentAnswerOp ={
    data:function () {
        return {
            answer:{}
        }
    },
    watch:{
		//监听图像
		"answer.Avatar":function(val,oval){
            if(0<=this.answer.Avatar.indexOf("base64")){
                this.$http.post(api.UserImg,{"data":val,token:localStorage.token},{emulateJSON:true}).then(function(res){
                    if(1==res.body.code){
                        this.answer.Avatar=res.body.data;
                        layer.msg(res.body.msg); 
                    }
                    else{
                        layer.msg(res.body.msg);
						this.answer.Avatar="/assets/imgs/upload_avatar_icon.png";
                    }
                },function(res){
                    layer.msg("与服务器通讯失败!"); 
                });
            }
		},
	},
    methods:{
        //上传头像
		onUpload:function(e) {
			var file = e.target.files[0];
			var reader = new FileReader();
			var that = this;
			reader.readAsDataURL(file);
			reader.onload = function(e) {
				that.answer.Avatar= this.result;
			}
        },
        //添加回答
        addAnswerHandle:function(){
            this.$http.post(api.insert,{token:localStorage.token,answer:this.answer,id:localStorage.floorid},{emulateJSON:true}).then(function(res){
                    if("1"==res.body.code){
                        this.$parent.lstAnswer();
                        layer.msg(res.body.msg); 
                    }else{
                        layer.msg(res.body.msg); 
                    }    
            },function(res){
                    layer.msg("与服务器通讯失败!"); 
            });
        },
        //编辑回答
        edtAnswerHandle:function(){
            this.$http.post(api.Updates,{token:localStorage.token,answer:this.answer,id:localStorage.floorid},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstAnswer();
                    layer.msg(res.body.msg); 
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
            	layer.msg("与服务器通讯失败!"); 
            });
        }
    },
    template:'<table class="layui-table addAnswer" style="display:none;width:100%;">'
    +'<colgroup>'
    +'    <col width="120">'
    +'    <col>'
    +' </colgroup>'
    +'<tbody>'
    +'    <tr>'
    +'        <td width="50">回答者头像：</td>'
    +'       <td>'
    +'           <img :src="answer.Avatar" class="add_Img" style="width:30px;height:30px;"/>'
    +'            <input type="file" @change="onUpload" value="上传头像" class="add_Input" accept="image/gif,image/jpeg,image/jpg,image/png"  style="width:30px;height:30px;">'
    +'        </td>'
    +'    </tr>'
    +'    <tr><td width="50">回复的对象：</td><td><input type="text" class="layui-input" placeholder="请输入@对象编号,不输入您将默认为回复者" v-model="answer.PID"></td></tr>'
    +'    <tr><td width="50">回答者昵称：</td><td><input type="text" class="layui-input" placeholder="请输入回复者昵称" v-model="answer.Name"></td></tr>'
    +'    <tr><td width="50">回答者城市：</td><td><input type="text" class="layui-input" placeholder="请输入回复者城市" v-model="answer.City"></td></tr>'
    +'    <tr><td width="50">回答者等级：</td><td><input type="text" class="layui-input" placeholder="请输入回复者等级" v-model="answer.Grade"></td></tr>'
    +'    <tr><td width="50">回答者积分：</td><td><input type="text" class="layui-input" placeholder="请输入回复者积分" v-model="answer.Integral"></td></tr>'
    +'    <tr><td width="50">回答者标签：</td><td><input type="text" class="layui-input" placeholder="请输入回复者标签" v-model="answer.Label"></td></tr>'
	+'    <tr><td width="50">赞回答次数：</td><td><input type="text" class="layui-input" placeholder="请输入回复赞数量" v-model="answer.Zan"></td></tr>'
	+'    <tr><td width="50">顶回答次数：</td><td><input type="text" class="layui-input" placeholder="请输入回复顶数量" v-model="answer.Ding"></td></tr>'
	+'    <tr><td width="50">踩回答次数：</td><td><input type="text" class="layui-input" placeholder="请输入回复踩数量" v-model="answer.Cai"></td></tr>'
    +'    <tr><td width="50">回答的日期：</td><td><input type="text" class="layui-input" placeholder="请输入回答的日期" v-model="answer.Date"></td></tr>'
    +'    <tr><td>回答的内容：</td><td><textarea id="editorbox" name="content" style="width:100%;height:300px;"></textarea></td>'
    +'    </tr>'
    +'  </tbody> '
    +'</table>'
}