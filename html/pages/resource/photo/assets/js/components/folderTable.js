var dxComponentFolderTable ={
    data:function(){
        return {
            folderList:[],
            foldericon:"assets/img/icon-folder.png",
            ids:[],
        }
    },
    watch:{
        ids:function(){
            this.$parent.ids=this.ids;
        }
    },
    methods:{
        gotoNextFolderHandle:function(cid,rid){
            this.$parent.inFolder(cid,rid);
        },
        mouseOverFolderHandle:function(fid){
            $("div[cid='"+fid+"']").css("display","block"); 
        },
        mouseOutFolderHandle:function(fid){
            if(this.ids.indexOf(fid)<0){
                $("div[cid='"+fid+"']").css("display","none"); 
            }
        }
    },
    template:'<div>'
    +'<div class="folder" @dblclick="gotoNextFolderHandle(item.Catalog_Id,item.RootId)"  @mouseover="mouseOverFolderHandle(item.Catalog_Id)"  @mouseout="mouseOutFolderHandle(item.Catalog_Id)" v-for="item in folderList">'
    +'<div style="display:none;" :cid="item.Catalog_Id"><input type="checkbox" :value="item.Catalog_Id" class="checkbox1" v-model="ids"></div>'
    +'<div class="folder-icon"><img :src="foldericon" width="80" height="80" /></div>'
    +'<div class="folder-text"><a href="#" v-text="item.Catalog_Name"></a></div>'
    +'</div>'
    +'</div>'
}