var dxComponentVideoOp ={
    data:function () {
        return {
            upload:{
                Video_Id:"",
                Video_Name:"",
                Video_Path:"" 
            },
            id:"",
            currid:"",
        }
    },
    watch:{
    },
    methods:{
        //添加视频提交
        addVideoHandle:function(){
            this.$http.post(api.AddVideo,{upload:this.upload,pid:this.$parent.currid,rootid:this.$parent.currid,level:this.$parent.currLevel,token:localStorage.token},{emulateJSON:true}).then(function(res){
                if(1==res.body.code){
                    this.$parent.lstVideo(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
        //删除视频提交
        delVideoHandle:function(){
            this.$http.post(api.DeleteVideo,{token:localStorage.token,Video_Id:this.upload.Video_Id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstVideo(); 
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
    template:'<table class="layui-table addVideoTable" style="display:none;">'
    +'<colgroup>'
    +'<col width="100">'
    +'<col>'
    +'</colgroup>'
    +'<tbody>'
    +'<tr>'
    +'  <td>选择视频:</td>'
    +'  <td>'
    +'      <button type="button" class="layui-btn" id="test5"><i class="layui-icon"></i>上传视频</button>'
    +'  </td>'
    +'</tr>'
    +'<tr>'
    +   '<td>视频名称</td>'
    +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入视频名称" autocomplete="off" class="layui-input" v-model="upload.Video_Name"></td>'
    +'</tr>'
    +'</tbody>'
    +'</table>'
}