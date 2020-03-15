var dxComponentPhotoToolBar ={
    methods:{
		//创建目录弹框
		addFolderBox:function(){
			this.$parent.addFolder();
		},
		//编辑目录弹框
		edtFolderBox:function(){
			this.$parent.edtFolder();
		},
		//删除目录弹框
		delFolderBox:function(){
			this.$parent.delFolder();
		},
		//创建视频弹框
		addVideoBox:function(){
			this.$parent.addVideo();
		},
		//编辑视频弹框
		edtVideoBox:function(){
			this.$parent.edtVideo();
		},
		//删除视频弹框
		delVideoBox:function(){
			this.$parent.delVideo();
		},
		//返回上级目录
		upFolder:function(){
			this.$parent.upFolder();
		}
    },
    template:'<ul class="toolbar">'
     +'<li @click="addFolderBox"><i class="layui-icon layui-icon-add-circle"></i> 创建目录</li>'
     +'<li @click="edtFolderBox"><i class="layui-icon layui-icon-edit"></i> 编辑目录</li>'
     +'<li @click="delFolderBox"><i class="layui-icon layui-icon-delete"></i> 删除目录</li>'
     +'<li @click="addVideoBox"><i class="layui-icon"></i>上传视频</li>'
     +'<li @click="edtVideoBox"><i class="layui-icon layui-icon-edit"></i> 编辑视频</li>'
     +'<li @click="delVideoBox"><i class="layui-icon layui-icon-delete"></i>删除视频</li>'
     +'<li @click="upFolder"><i class="layui-icon layui-icon-return"></i> 返回上级</li>'
     +'</ul>'
}