
$(document).ready(function(){
    $(".Pid").click(function(){
         Pid=$(this).attr("name");
         PidName=$(this).text();
        $('#dsMessageTextarea').attr("placeholder","@"+PidName);
    });
    $(".reply").click(function(){
     content=$("#dsMessageTextarea").val();
      $.ajax({
      url:'http://uapi.cnsdvip.com/public/index.php/index/Pub/pinglun',
      dataType: 'json',
      method: 'post',
      data:{"Pid":Pid,"Landingpage_Id":wid,"PidName":PidName,"content":content},
      success:function(data){ 
       if(1==data.code){
        window.location.reload();
       }else{
         alert("评论内容不能呢个为空");
        }
       }
      });
    });
  });