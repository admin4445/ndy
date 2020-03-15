<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Loader;
use think\Cookie;

class Statisticss extends controller{
    //渲染页面
    public function index($e=0,$tel=0){
    		header("Access-Control-Allow-Origin: *");
        header('Content-Type: text/html; charset=utf-8');
    		$cc['Landingpage_Id'] = $e;
    		$cc['Tel'] = $tel;
        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        if(strstr( $referer, 'baidu.com')){ //百度

            preg_match( "|baidu.+wo?r?d=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'baidu';

        }elseif(strstr( $referer, 'google.com') or strstr( $referer, 'google.cn')){ //谷歌

            preg_match( "|google.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'google';

        }elseif(strstr( $referer, 'so.com')){ //360搜索

            preg_match( "|so.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = '360'; 

        }elseif(strstr( $referer, 'sogou.com')){ //搜狗

            preg_match( "|sogou.com.+query=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'sogou'; 

        }elseif(strstr( $referer, 'soso.com')){ //搜搜

            preg_match( "|soso.com.+w=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'soso';

        }elseif(strstr( $referer, 'sm.cn') or strstr( $referer, 'sm.cn')){ //谷歌

            preg_match( "|sm.cn.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'sm';

        }else {
      			if(array_key_exists('HTTP_REFERER', $_SERVER)){
      				$keyword= $_SERVER['HTTP_REFERER'];
      				$from = '智慧旅游旅游电商平台';
      				
      			}else{
      				$keyword= 'zhangge';
      				$from = '无';
      			}
           
        }



        /*获取设备类型*/
         $mobile=$this->getDevice();
         if($mobile=="mobile"){
            $bb['mobile']='mobile';
         }else{
            $bb['mobile']='pc';
         }

        /*获取访问的IP地址*/
          Loader::import('visitorInfo', EXTEND_PATH);
          $ip   = new \visitorInfo();
          $userip=$ip->getIp();

          if($userip=='127.0.0.1'){
            /*获取地区信息 包括 所在国家 省市 */
            $data=$ip->findCityByIp('220.202.152.76');
             if($data['code']==0){
                 /*获取的IP地址*/
                 $bb['ip']=$data['data']['ip'];
                 /*获取的省名称*/
                 $bb['region']=$data['data']['region'];
                /*获取的城市名称*/
                 $bb['city']=$data['data']['city'];
                
             }
          }else{

          }

        $bb['Keyword']=$keyword;
		    $bb['From']=$from;
       
		    $c = implode(",", $bb);
       
        return  $c;

		
    }




    /*获取设备类型*/

    public static function getDevice()
    {
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return 'mobile';
        }
        if (isset($_SERVER['HTTP_USER_AGENT']))
        {
            $clientKEY = array ('nokia','sony','ericsson','mot','samsung','htc','huawei','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iPhone','phone','ipod','ipad','blackberry','meizu','Android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
            if (preg_match("/(" . implode('|', $clientKEY) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return 'mobile';
            }
        }
        if (isset($_SERVER['HTTP_ACCEPT']))
        {
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return 'mobile';
            }
        }
        return 'pc';
    }


	//点击事件
	 public function indexs(){
		 header("Access-Control-Allow-Origin: *");
		 $request = Request::instance();
      $cc['Landingpage_Id'] = $request->post('Landingpage_Id');
		 $cc['Tel']=$request->post('Tel');
		 $cc['Tel']=substr($cc['Tel'],-11);
		 $cc['Keyword'] = $request->post('keyword');
		 $cc['From']=$request->post('From');
    $cc['Equipment']=$request->post('Equipment');
      $cc['Ip']=$request->post('ip');
      $cc['Region']=$request->post('region');
      $cc['City']=$request->post('city');
		if(Cookie::has($cc['Landingpage_Id'])){
            return "1";
        }
		cookie($cc['Landingpage_Id'], '123123', 3600);
        $userinfo=db::table('yunque_landing_page')->where('Landingpage_Id',$cc['Landingpage_Id'])->find();
        $cc['Corporate_Id']=$userinfo['Corporate_Id'];
        $data=db::table('yunque_landing_page')->where(['Landingpage_Id'=> $cc['Landingpage_Id'],'Corporate_Id'=> $cc['Corporate_Id']])->find();
        $data['CustomerService_Id']=json_decode($data['CustomerService_Id'],true);
		if($data['CustomerService_Id']){
			if($cc['Tel']){
				foreach($data['CustomerService_Id'] as $key=>$val){
					if($val['CustomerService_Tel']== $cc['Tel']){
						$cc['NickName']=$val['CustomerService_Name'];
					}
				}
			}else{
				$cc['NickName'] = "dadaguaijianjun";
			}
		}else{
			$cc['NickName'] = "dadaguaijianjun";
		}
        $cc['Time']=date("Y-m-d H:i:s");
        $rs=db::table('yunque_statistics')->insert($cc);
		if($rs){
			return "ok";
		}
		return no;
	}
}
?>