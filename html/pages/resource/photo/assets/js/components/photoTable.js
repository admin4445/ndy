var dxComponentPhotoTable ={
    data:function(){
        return {
            fileList:[],
            ids:[]
        }
    },
    watch:{
        ids:function(){this.$parent.ids=this.ids;}
    },
    methods:{
        mouseOverPhotoHandle:function(fid){
            $("div[cid='"+fid+"']").css("display","block"); 
        },
        mouseOutPhotoHandle:function(fid){
            if(this.ids.indexOf(fid)<0){
                $("div[cid='"+fid+"']").css("display","none"); 
            }
        }
    },
    template:'<div>'
    +'<div class="folder" v-for="item in fileList"  @mouseover="mouseOverPhotoHandle(item.Img_Id)"  @mouseout="mouseOutPhotoHandle(item.Img_Id)">'
    +'<div :cid="item.Img_Id" style="display:none;"><input type="checkbox" class="checkbox1" :value="item.Img_Id" v-model="ids"></div>' 
    +'<div class="folder-icon"><img :src="item.Img_Path" width="80" height="80" /></div>'
    +'<div class="folder-text"><a href="#" v-text="item.Img_Name"></a></div>'
    +'</div>' 
    +'</div>'
}