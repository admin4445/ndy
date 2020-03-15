$(function(){
	$('.dx-tel').on('click',function(){
		var tel = $(this).text();
		$.ajax({
			url:'/index/Statisticss/indexs',
			dataType: 'json',
			method: 'post',
			data:{"Tel":tel,"Landingpage_Id":wid,"keyword":keyword,"From":from,"ip":ip,"region":region,"city":city,'Equipment':Equipment},
			success:function(data){ 
				//  if(1==data.code){
				//    alert("复制成功");
				//  }
			}
		});
	});
	$('.dx-wchat').on('click',function(){
		var tel = $(this).text();
		$.ajax({
			url:'/index/Statisticss/indexs',
			dataType: 'json',
			method: 'post',
			data:{"Tel":tel,"Landingpage_Id":wid,"keyword":keyword,"From":from,"ip":ip,"region":region,"city":city},
			success:function(data){ 
				//  if(1==data.code){
				//    alert("复制成功");
				//  }
			}
		});
	});
});