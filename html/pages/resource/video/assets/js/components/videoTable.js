var dxComponentVideoTable ={
    data:function(){
        return {
            VideoList:[],
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
    +'<div class="folder" v-for="item in VideoList"  @mouseover="mouseOverPhotoHandle(item.Video_Id)"  @mouseout="mouseOutPhotoHandle(item.Video_Id)">'
    +'<div :cid="item.Video_Id" style="display:none;"><input type="checkbox" class="checkbox1" :value="item.Video_Id" v-model="ids" style="z-index:100001"></div>' 
    +'<div class="folder-icon"><video :src="item.Video_Path" width="100" height="100" controls="controls"></video></div>'
    +'<div class="folder-text"><a href="#" v-text="item.Video_Name"></a></div>'
    +'</div>' 
    +'</div>'
}