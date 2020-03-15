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
		//创建图片弹框
		addPhotoBox:function(){
			this.$parent.addPhoto();
		},
		//编辑图片弹框
		edtPhotoBox:function(){
			this.$parent.edtPhoto();
		},
		//删除图片弹框
		delPhotoBox:function(){
			this.$parent.delPhoto();
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
     +'<li @click="addPhotoBox"><i class="layui-icon layui-icon-camera"></i>上传图片</li>'
     +'<li @click="edtPhotoBox"><i class="layui-icon layui-icon-edit"></i> 编辑图片</li>'
     +'<li @click="delPhotoBox"><i class="layui-icon layui-icon-delete"></i>删除图片</li>'
     +'<li @click="upFolder"><i class="layui-icon layui-icon-return"></i> 返回上级</li>'
     +'</ul>'
}