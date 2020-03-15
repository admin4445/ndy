var dxComponentAudioOp ={
    data:function () {
        return {
            upload:{
                Audio_Id:"",
                Audio_Name:"",
                Audio_Path:"" 
            },
            id:"",
            currid:"",
            mode:"",
        }
    },
    watch:{
        mode:function(){
            this.$nextTick(function(){
                var that=this;
                layui.use('upload',function(){
                    layui.upload.render({
                        elem:'#test6'
                        ,url:api.uploadAudio
                        ,accept: 'audio'
						,data: {token:localStorage.token}
                        ,before:function(res){
                            layer.msg("正在上传",{shade:0.3});
                        }
                        ,done:function(res){
                            if("1"==res.code){
                                that.upload.Audio_Path=res.data;
                                layer.msg(res.msg);
                            }
							else{
								layer.msg(res.msg);
							}
                        }
						,error:function(index,upload){
							layer.msg("与服务器通信失败");
						}
                    });
                });
            });
        }
    },
    methods:{
        //添加音频提交
        addAudioHandle:function(){
            this.$http.post(api.AddAudio,{upload:this.upload,pid:this.$parent.currid,rootid:this.$parent.currid,level:this.$parent.currLevel,token:localStorage.token},{emulateJSON:true}).then(function(res){
                if(1==res.body.code){
                    this.$parent.listAudio(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
        //编辑音频提交
        edtAudioHandle:function(){
            this.$http.post(api.UpdateAudio,{token:localStorage.token,Audio_Id:this.upload.Audio_Id,Audio_Name:this.upload.Audio_Name},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.listAudio(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
        },
        //删除音频提交
        delAudioHandle:function(){
            this.$http.post(api.DeleteAudio,{token:localStorage.token,Audio_Id:this.upload.Audio_Id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.listAudio(); 
                    layer.msg(res.body.msg);
                }
                else{
                    layer.msg(res.body.msg);
                }
            },function(res){
                layer.msg("服务器无响应，请联系技术人员"); 
            });
        }
     },
    template:'<table class="layui-table addAudioTable" style="display:none;">'
    +'<colgroup>'
    +'<col width="100">'
    +'<col>'
    +'</colgroup>'
    +'<tbody>'
    +'<tr v-if="mode">'
    +   '<td>选择音频:</td>'
    +   '<td>'
    +'<button type="button" class="layui-btn" id="test6"><i class="layui-icon"></i>上传音频</button>' 
    +'</td>'
    +'</tr>'
    +'<tr>'
    +   '<td>音频名称</td>'
    +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入音频名称" autocomplete="off" class="layui-input" v-model="upload.Audio_Name"></td>'
    +'</tr>'
    +'</tbody>'
    +'</table>'
}