var dxComponentAnswerReplyOp ={
    data:function () {
        return {
            reply:{
                Id:"",
                Pid:"",
                Content:"",
                RootId:"",
                token:localStorage.token,
                ids:localStorage.floorid
            }
        }
    },
    methods:{
        //添加评论
        addreply:function(){
            this.$http.post(api.AddReply,this.reply,{emulateJSON:true}).then(function(res){
                if(1==res.body.code){
					this.reply.Id="";
                    this.$parent.lstAnswer();
                    layui.use(['layer'], function(){
                        layer.msg(res.body.msg);
                    });
                }else{
                    layui.use(['layer'], function(){
                        layer.msg(res.body.msg);
                     });
                }
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        }    
    },
    template:'<table class="layui-table addreply" style="display:none;width:100%;">'
    +'<colgroup>'
    +'    <col width="120">'
    +'    <col>'
    +' </colgroup>'
    +'      <tbody>'
    +'          <tr><td width="50">我的标号：</td><td v-text="reply.Id"></td></tr>'
    +'          <tr><td width="50">回复内容：</td><td><textarea id="editorbox2" name="content" style="width:100%;height:300px;"></textarea></td></tr>'
    +'      </tbody>'
    +'</table>'
}