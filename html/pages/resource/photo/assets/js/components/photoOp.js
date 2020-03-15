var dxComponentPhotoOp ={
    data:function () {
        return {
            upload:{
                Img_Id:"",
                Img_Name:"",
                upload_Img:"" 
            },
            id:"",
            currid:"",
        }
    },
    watch:{
        //监听图片
		"upload.upload_Img":function(val,oldVal){
            if(0<=val.indexOf("base64")){
                this.$http.post(api.UserImg,{token:localStorage.token,"data":val},{emulateJSON:true}).then(function(res){
                    if(1==res.body.code){
                        this.upload.upload_Img=res.body.data;
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
    },
    methods:{
        //上传图片
		uploadHandle:function(e) {
			var file = e.target.files[0];
			var reader = new FileReader();
            var that = this;
			reader.readAsDataURL(file);
			reader.onload = function(e) {that.upload.upload_Img= this.result;}
		},
        //添加图片提交
        addPhotoHandle:function(){
            this.$http.post(api.UploadSub,{token:localStorage.token,upload:this.upload,pid:this.$parent.currid,rootid:this.$parent.currid,level:this.$parent.currLevel},{emulateJSON:true}).then(function(res){
                if(1==res.body.code){
                    this.$parent.lstImg(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
        //编辑图片提交
        edtPhotoHandle:function(){
            this.$http.post(api.UpdateImg,{token:localStorage.token,Img_Id:this.upload.Img_Id,Img_Name:this.upload.Img_Name},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstImg(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
        },
        //删除提交
        delPhotoHandle:function(){
            this.$http.post(api.deleteImg,{token:localStorage.token,Img_Id:this.upload.Img_Id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstImg(); 
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
    template:'<table class="layui-table addPhotoTable" style="display:none;">'
    +'<colgroup>'
    +'<col width="100">'
    +'<col>'
    +'</colgroup>'
    +'<tbody>'
    +'<tr>'
    +   '<td>选择图片:</td>'
    +   '<td>'
    +'<img :src="upload.upload_Img"  width="30" class="upload_img"/>'
    +'<input type="file" @change="uploadHandle" value="上传图片" class="upload_Input" accept="image/gif,image/jpeg,image/jpg,image/png">'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +   '<td>图片名称</td>'
    +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入图片名称" autocomplete="off" class="layui-input" v-model="upload.Img_Name"></td>'
    +'</tr>'
    +'</tbody>'
    +'</table>'
}