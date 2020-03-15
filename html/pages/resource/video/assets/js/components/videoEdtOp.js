var dxComponentEdtVideoOp ={
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
    methods:{
        //编辑视频提交
        edtVideoHandle:function(){
            this.$http.post(api.UpdateVideo,{token:localStorage.token,Video_Id:this.upload.Video_Id,Video_Name:this.upload.Video_Name},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstVideo(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
        },
    },
    template:'<table class="layui-table edtVideoTable" style="display:none;">'
    +'<colgroup>'
    +'<col width="100">'
    +'<col>'
    +'</colgroup>'
    +'<tbody>'
    +'<tr>'
    +   '<td>视频名称</td>'
    +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入视频名称" autocomplete="off" class="layui-input" v-model="upload.Video_Name"></td>'
    +'</tr>'
    +'</tbody>'
    +'</table>'
}