var vm_province=new Vue({
    el:"#app",
    data:{
        selected:{Provincial_Number:'B',Province_Name:'青海'},
        options: [
            {Provincial_Number:'B',Province_Name:'青海'},
            {Provincial_Number:'C',Province_Name:'云南'},
            {Provincial_Number:'D',Province_Name:'海南'},
        ],
        provinceList:[],
    },
    methods:{
        //获取省份
        selectProincial:function(){
            this.$http.post(api.SelectProincial,{token:localStorage.token,id:localStorage.Province_Id},{emulateJSON:true}).then(function(res){
                if(res.body.code){ this.provinceList=res.body.data;}
			},function(res){

			});
        },
        //添加国家
        addprovince:function(){
            this.$http.post(api.addProincial,{token:localStorage.token,data:this.selected},{emulateJSON:true}).then(function(res){
                if("2"!==res.body.code){this.provinceList.push(this.selected);}
			},function(res){

			});
        },
        //弹出删除提示层
		delProvinceBox:function(id){
			this.id=id;
			var w = $(".content").width();
			var h = $(".content").height();
			var p = $(".content").position(); 
			var s = ((h-150)/2+75)/2+"px"+((w-300)/2-150)+"px";
			$(".delProvinceBox").css({"width":w,"height":h,"position":"absolute","top":p.top,"left":p.left,"z-index":"100000"}).slideDown();
			$(".delProvinceDiv").css({"width":"300px","margin":s});
			$(window).resize(function() {
				var w = $(".content").width();
				var h = $(".content").height();
				var s = ((h-150)/2+75)/2+"px"+((w-300)/2-150)+"px";
				$(".delProvinceBox").css({"width":w,"height":h,"position":"absolute","top":p.top,"left":p.left});
				$(".delProvinceDiv").css({"margin":s});
			});
		},
        //删除省份
        delProvince:function(id){	
			this.$http.post(api.delProvince,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
				this.selectProincial();
			},function(res){

			});
		},
        //隐藏删除提示框
		delProvinceCancelBtn:function(){
			$(".delProvinceBox").hide();
			this.id="";
			
		},
		//删除框确认按钮处理函数
		delProvinceConfirmBtn:function(){
			this.delProvince(this.id);
			$(".delProvinceBox").hide();
		},
		gotoCityList:function(id){
            localStorage.Country_Id=id;
            window.location.href="City.html"
        },
    },
});
vm_province.selectProincial();