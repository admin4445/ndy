KindEditor.plugin('service', function(K) {
    var self = this;
    var name = 'service';
    self.clickToolbar(name,function(){
        self.createDialog({
            width:430,
            height:180,
            title : '插入客服信息',
            body :'<div class="layui-btn-group service-info-box" style="margin:10px;">'
            +'</div>'
        });
        //创建子元素
        var node=K('<button class="layui-btn layui-btn-primary layui-btn-sm">客服头像</button>');
            node.bind("click",function(){self.insertHtml('[avatar]');});
            K('.service-info-box').append(node);
        var node=K('<button class="layui-btn layui-btn-primary layui-btn-sm">客服昵称</button>');
            node.bind("click",function(){self.insertHtml('[nickname]');});
            K('.service-info-box').append(node);
        var node=K('<button class="layui-btn layui-btn-primary layui-btn-sm">客服电话</button>');
            node.bind("click",function(){self.insertHtml('[tel]');});
            K('.service-info-box').append(node);
        var node=K('<button class="layui-btn layui-btn-primary layui-btn-sm">客服微信</button>');
            node.bind("click",function(){self.insertHtml('[wechat]');});
            K('.service-info-box').append(node);
        var node=K('<button class="layui-btn layui-btn-primary layui-btn-sm">二维码</button>');
            node.bind("click",function(){self.insertHtml('[qrcode]');});
            K('.service-info-box').append(node);
			var node=K('<button class="layui-btn layui-btn-primary layui-btn-sm">他（她）</button>');
            node.bind("click",function(){self.insertHtml('[person]');});
            K('.service-info-box').append(node);
    });
});