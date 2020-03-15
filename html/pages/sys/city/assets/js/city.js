var vm_city=new Vue({
    el:"#app",
    data:{
        selected:{City_Number:'A',City_Name:'张家界'},
        options: [
            {City_Number:'A',City_Name:'张家界'},
            {City_Number:'B',City_Name:'曲靖'},
            {City_Number:'C',City_Name:'广州'},
            {City_Number:'D',City_Name:'三亚'},
        ],
       cityList:[],
    },
    methods:{
        //获取省份
        selectCity:function(){
            this.$http.post(api.SelectCity,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                if(res.body.code){ this.cityList=res.body.data;}
			},function(res){

			});
        },
        //添加国家
        addcity:function(){
            this.$http.post(api.addCity,{token:localStorage.token,data:this.selected},{emulateJSON:true}).then(function(res){
                if("2"!==res.body.code){this.cityList.push(this.selected);}
			},function(res){

			});
        },
         //弹出删除提示层
		delCityBox:function(id){
			this.id=id;
			var w = $(".content").width();
			var h = $(".content").height();
			var p = $(".content").position(); 
			var s = ((h-150)/2+75)/2+"px"+((w-300)/2-150)+"px";
			$(".delCityBox").css({"width":w,"height":h,"position":"absolute","top":p.top,"left":p.left,"z-index":"100000"}).slideDown();
			$(".delCityDiv").css({"width":"300px","margin":s});
			$(window).resize(function() {
				var w = $(".content").width();
				var h = $(".content").height();
				var s = ((h-150)/2+75)/2+"px"+((w-300)/2-150)+"px";
				$(".delCityBox").css({"width":w,"height":h,"position":"absolute","top":p.top,"left":p.left});
				$(".delCityDiv").css({"margin":s});
			});
		},
        //删除国家
        delCity:function(id){	
			this.$http.post(api.delCity,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
				this.selectCity();
			},function(res){

			});
		},
        //隐藏删除提示框
		delCityCancelBtn:function(){
			$(".delCityBox").hide();
			this.id="";
			
		},
		//删除框确认按钮处理函数
		delCityConfirmBtn:function(){
			this.delCity(this.id);
			$(".delCityBox").hide();
		},
    },
});
vm_city.selectCity();