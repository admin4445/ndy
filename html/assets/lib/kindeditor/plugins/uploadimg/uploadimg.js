KindEditor.plugin('uploadimg', function(K) {
    var self = this;
    var name = 'uploadimg';
    self.clickToolbar(name,function(){
        //创建弹出窗
        self.createDialog({
             width:160,
             height:120,
             title : '上传图片',
             body :'<div class="upload-img-box" style="margin:10px 20px;"></div>'
         });
        //创建子元素
        var node=K('<div class="layui-btn" style="width:120px;height:40px;"><input type="file" style="opacity:0;display:block;position:absolute;width:120px;height:40px;"></input><i class="layui-icon"></i>上传图片</div>');
        node.bind("change",function(e){
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var that = this;
				
                K.ajax(api.UserImg,function(res) {
                    self.insertHtml('<img src="'+res.data+'" width="660" height="410" ></img>');
                },'POST',{
					"token":localStorage.token,
                    "data":that.result
					
                });
            }
        });
        K('.upload-img-box').append(node);
    });
});