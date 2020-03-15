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
		//创建音频弹框
		addAudioBox:function(){
			this.$parent.addAudio();
		},
		//编辑音频弹框
		edtAudioBox:function(){
			this.$parent.edtAudio();
		},
		//删除音频弹框
		delAudioBox:function(){
			this.$parent.delAudio();
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
     +'<li @click="addAudioBox"><i class="layui-icon"></i>上传音频</li>'
     +'<li @click="edtAudioBox"><i class="layui-icon layui-icon-edit"></i> 编辑音频</li>'
     +'<li @click="delAudioBox"><i class="layui-icon layui-icon-delete"></i>删除音频</li>'
     +'<li @click="upFolder"><i class="layui-icon layui-icon-return"></i> 返回上级</li>'
     +'</ul>'
}