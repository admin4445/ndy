var vm_user = new Vue ({
    el:'#app',
    components:{
		'dx-component-spot-toolbar': dxComponentSpotToolBar,
		'dx-component-spot-datatable' : dxComponentSpotDataTable,
		'dx-component-spot-op':dxComponentSpotOp
	},
    data:{
        spot:[],
        addspot:{},
        // selectedCountry:"",
        // selectedProvince:"",
        // selectedCity:"", 
    },
    mounted:function () {
		this.$refs.sidepageop.navsCuttle(3,0);
		this.$refs.navbarop.nav=[
		 	{name:"景点管理",url:"#"},
        	{name:"自然景点",url:"#"}
		]
	},
    updated:function () {
		var that=this;
        this.$nextTick(function () {
           layui.use(['form','layer','element'], function(){
				layui.form.render('checkbox');
				layui.form.render('select');
           });
        });
    },
    methods:{
        //景点添加       
        addSpot:function(){
            this.$http.post(api.SelectCountry,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                 this.$refs.spotop.selectedCountry="";
                 this.$refs.spotop.selectedProvince="";
                 this.$refs.spotop.selectedCity="";
                this.country=res.body.data;
                var addspot={
                    ScenicSpot_Type:"",
                    ScenicSpot_Name:"",  
                    ScenicSpot_Introduction:""
                };
                this.$refs.spotop.addspot=JSON.parse(JSON.stringify(addspot));
                var that =this;
                layer.open({type: 1,
                    title:"添加景点",
                    content:$('.addSpotTable'),
                    area:['500px','450px'],
                    btn:'保存景点',
                    btnAlign: 'c',
                    shade: 0.3 ,
                    yes:function(index, layero){
                        that.$refs.spotop.addSpotHandle();
                        layer.close(index);
                    },
                    cancel: function(index, layero){ 
                        layer.close(index);
                    }  
                });  
             },function(res){
            
            });
        },

        //景点列表////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        lstSpot:function(){
            var that = this;
            layui.use(['layer'],function(){
            that.$http.post(api.Selectspot,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                if("1"==res.body.code){
                    that.spot=res.body.data;
                    layer.msg(res.body.msg); 
                }
                else{
                    layer.msg(res.body.msg); 
                }
            },function(res){
                layer.msg("服务器无响应，请联系技术人员",{offset:'t',icon: 1}); 
            });
        });
        },

        //景点删除//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        delSpot:function(id){
            var that = this;
            var id=id;
            layer.confirm('您确定要删除当前景点吗？', {btn: ['确定','取消']},function(index,layero){
				that.$refs.spotop.delSpotHandle(id);
            });
        },

        
        //景点修改
        edtSpot:function(id){
            this.$http.post(api.SelectCountry,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                this.country=res.body.data;
                var that = this;
                that.$refs.spotop.Findspot(id);
                layer.open({
                    type: 1,
                    title:"修改景点",
                    content: $('.addSpotTable'),
                    area: ['500px','450px'],
                    btn: '保存景点',
                    btnAlign: 'c',
                    shade: 0.3 ,
                    yes:function(index, layero){
                        that.$refs.spotop.edtSpotHandle();
                        layer.close(index);
                    },
                    cancel:function(index, layero){ 
                        layer.close(index);
                    }  
                });
            },function(res){
            
            });
        },

    },  
})

vm_user.lstSpot();