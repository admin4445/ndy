<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Loader;
use think\Cookie;

class Statisticss extends controller{
    //
    public function index($e,$tel){
		$cc['Landingpage_Id'] = $e;
		$cc['Tel'] = $tel;
		if(Cookie::has($e)){
            return ;
    }
		cookie($e, '123123', 3600);
		//$keyword= $_SERVER['HTTP_REFERER'];
        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        if(strstr( $referer, 'baidu.com')){ //°Ù¶È

            preg_match( "|baidu.+wo?r?d=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'baidu';

        }elseif(strstr( $referer, 'google.com') or strstr( $referer, 'google.cn')){ //¹È¸è

            preg_match( "|google.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'google';

        }elseif(strstr( $referer, 'so.com')){ //360统计

            preg_match( "|so.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = '360'; 

        }elseif(strstr( $referer, 'sogou.com')){ //搜狗统计

            preg_match( "|sogou.com.+query=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'sogou'; 

        }elseif(strstr( $referer, 'soso.com')){ //

            preg_match( "|soso.com.+w=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'soso';

        }elseif(strstr( $referer, 'sm.cn') or strstr( $referer, 'sm.cn')){ //

            preg_match( "|sm.cn.+q=([^\\&]*)|is", $referer, $tmp );

            $keyword = urldecode( $tmp[1] );

            $from = 'sm';

        }else {

            $keyword= $_SERVER['HTTP_REFERER'];

            $from = '';

        }
        $cc['Keyword']=$keyword;

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
		$cc['From'] = $from;
        $cc['Time']=date("Y-m-d H:i:s");
        $rs=db::table('yunque_statistics')->insert($cc);
		return ;
    }
}
?>