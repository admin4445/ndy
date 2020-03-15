var dxComponentAudioTable ={
    data:function(){
        return {
            audioList:[],
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
    +'<div class="folder" v-for="item in audioList"  @mouseover="mouseOverPhotoHandle(item.Audio_Id)"  @mouseout="mouseOutPhotoHandle(item.Audio_Id)">'
    +'<div :cid="item.Audio_Id" style="display:none;"><input type="checkbox" class="checkbox1" :value="item.Audio_Id" v-model="ids"></div>' 
    +'<div class="folder-icon"><img src="/assets/imgs/audio_icon.png" width="80" height="80"></div>'
    +'<div class="folder-text"><a href="#" v-text="item.Audio_Name"></a></div>'
    +'</div>' 
    +'</div>'
}