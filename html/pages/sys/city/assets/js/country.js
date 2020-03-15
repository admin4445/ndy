var vm_city=new Vue({
    el:"#app",
    data:{
        selected:{Country_Id:'1',Country_Name:'中国',Country_Number:'A'},
        options: [
            {Country_Id:'1',Country_Name:'中国',Country_Number:'A'},
            {Country_Id:'2',Country_Name:'韩国',Country_Number:'B'},
            {Country_Id:'3',Country_Name:'泰国',Country_Number:'C'},
            {Country_Id:'4',Country_Name:'美国',Country_Number:'D'}
        ],
        countryList:[],
    },
    methods:{
        //获取国家
        selectCountry:function(){
            this.$http.post(api.SelectCountry,{token:localStorage.token},{emulateJSON:true}).then(function(res){
                if(res.body.code){ this.countryList=res.body.data;}
			},function(res){

			});
        },
        //添加国家////////////////////////////////////////////////////////////////////////////////////////////////////////
        addCountry:function(){
            this.$http.post(api.addCountry,{token:localStorage.token,data:this.selected},{emulateJSON:true}).then(function(res){
                if("2"!==res.body.code){this.countryList.push(this.selected);}
			},function(res){

			});
        },
        
		//弹出删除提示层
		delCountryBox:function(id){
			this.id=id;
			var w = $(".content").width();
			var h = $(".content").height();
			var p = $(".content").position(); 
			var s = ((h-150)/2+75)/2+"px"+((w-300)/2-150)+"px";
			$(".delCountryBox").css({"width":w,"height":h,"position":"absolute","top":p.top,"left":p.left,"z-index":"100000"}).slideDown();
			$(".delCountryDiv").css({"width":"300px","margin":s});
			$(window).resize(function() {
				var w = $(".content").width();
				var h = $(".content").height();
				var s = ((h-150)/2+75)/2+"px"+((w-300)/2-150)+"px";
				$(".delCountryBox").css({"width":w,"height":h,"position":"absolute","top":p.top,"left":p.left});
				$(".delCountryDiv").css({"margin":s});
			});
		},
        //删除国家
        delCountry:function(id){	
			this.$http.post(api.delCountry,{id:id,token:localStorage.token},{emulateJSON:true}).then(function(res){
				this.selectCountry();
			},function(res){

			});
		},
        //隐藏删除提示框
		delCountryCancelBtn:function(){
			$(".delCountryBox").hide();
			this.id="";
			
		},
		//删除框确认按钮处理函数
		delCountryConfirmBtn:function(){
			this.delCountry(this.id);
			$(".delCountryBox").hide();
		},
        gotoPrvinceList:function(id){
            localStorage.Country_Id=id;
            window.location.href="province.html"
        },
    },
});
vm_city.selectCountry();