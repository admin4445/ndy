var dxComponentFolderOp ={
    data:function () {
        return {
            rootid:"",
            currLevel:0,
            currid:"",
            ids:[],
            pid:"",
            folder:{
                Id:"",
                Name:"",
                Flag:"folder"
            }
        }
    },
    methods:{
        //添加目录处理
        addFolderHandle:function(){
            if(this.folder.Name.length<1){this.folder.Name="";}
            this.$http.post(api.AddVideocatalog,{rootid:this.$parent.currid,level:this.$parent.currLevel,name:this.folder.Name,token:localStorage.token,Flag:"folder",pid:this.$parent.currid},{emulateJSON:true}).then(function(res){
                if(1==res.body.code){
                    this.folderList=res.body.data;
                    this.$parent.lstDirectory(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!"); 
            });
        },
        //编辑目录处理
        edtFolderHandle:function(){
            this.$http.post(api.UpdateVideocatalog,{token:localStorage.token,Name:this.folder.Name,Flag:"folder",Id:this.folder.Id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstDirectory(); 
                    layer.msg(res.body.msg)
                }else{
                    layer.msg(res.body.msg); 
                }    
            },function(res){
                layer.msg("与服务器通讯失败!");
            });
        },
        //删除目录处理
        delFolderHandle:function(){
            this.$http.post(api.DeleteVideocatalog,{token:localStorage.token,id:this.folder.Id},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    this.$parent.lstDirectory(); 
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
    template:'<table class="layui-table addFolderTable" style="display:none;">'
    +'<colgroup>'
    +'<col width="100">'
    +'<col>'
    +'</colgroup>'
    +'<tbody>'
    +'<tr>'
    +   '<td>目录名</td>'
    +   '<td><input type="text" name="title" required  lay-verify="required" placeholder="请输入目录名" autocomplete="off" class="layui-input" v-model="folder.Name"></td>'
    +'</tr>'
    +'</tbody>'
    +'</table>'
}