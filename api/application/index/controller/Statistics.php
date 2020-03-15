<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Loader;
use think\Cookie;

class Statistics extends controller{
    //渲染页面
    public function index(){
        header("Access-Control-Allow-Origin: *");
		print_r (Cookie::get());
		if(Cookie::get('uid')){
            return 1;
        }
		Cookie::set('uid','123456',3600);
		print_r (Cookie::get());
		exit;
		$request = Request::instance();
        $cc=$request->post();
		if(Cookie::has('uid')){
            return 'ok';
        }
		
		//echo $cc['Landingpage_Id'].'\\';
		//echo Cookie::has('xiaowei').'\\';
		//echo 'asodsaio';
		
		Cookie::set('uid','123456',3600);	
		exit;
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

        }else {

            $keyword ='';

            $from = '';

        }
        $cc['Keyword']=$keyword;   
        $userinfo=db::table('yunque_landing_page')->where('Landingpage_Id',$cc['Landingpage_Id'])->find();
        $cc['Corporate_Id']=$userinfo['Corporate_Id'];
        $data=db::table('yunque_landing_page')->where(['Landingpage_Id'=> $cc['Landingpage_Id'],'Corporate_Id'=> $cc['Corporate_Id']])->find();
        $data['CustomerService_Id']=json_decode($data['CustomerService_Id'],true);
        foreach($data['CustomerService_Id'] as $key=>$val){
                if($val['CustomerService_Tel']== $cc['Tel']){
                    $cc['NickName']=$val['CustomerService_Name'];
                }
        }
        $cc['Time']=date("Y-m-d H:i:s");
        $rs=db::table('yunque_statistics')->insert($cc);
        if($rs){
            $info['msg']="复制成功";
            $info['code']="1";
            return json($info);

        }else{
            $info['msg']="操作失败";
            $info['code']="1";
            return json($info);
        }
       
    }


		//查询列表
		public function SelectStatistics(){
			header("Access-Control-Allow-Origin: *");
			$request = Request:: instance();
			$id=$request->post('id');
			$token=$request->post('token');
			$userinfo=db::table('yunque_userinfo')->where('UserToken',$token)->find();
			$a=db::table('yunque_statistics')->where(['Corporate_Id'=>$userinfo['Corporate_Id'],'Landingpage_Id'=>$id])->order('Statistics_Id desc')->select();
			if($a){
				$info['msg']="查询成功";
				$info['code']="1";
				$info['data']=$a;
				return json($info);
			}else{
				$info['msg']="数据为空";
				$info['code']="1";
				return json($info);
			}
		}
    


	//查询当天，周，月的数据
	public function SelectCycle(){
		header("Access-Control-Allow-Origin: *");
		$request = Request:: instance();
		$id=$request->post('id');
		$number=$request->post('number');
		$date=$this->total($number);
		//$list=Db::table('yunque_statistics')->whereTime('Time', 'between', [$date[0], $date[1]])->select();
		$list=db::table('yunque_statistics')->where('Landingpage_Id',$id)->where('Time','>=',$date[0])->where('Time','<=',$date[1])->select();
		if($list){
			$info['msg']="查询成功";
			$info['code']="1";
			$info['data']=$list;
			return json($info);
		}else{
			$info['msg']="数据为空";
			$info['code']="0";
			return json($info);
		}
    }


	 public function total($id) {
		header("Access-Control-Allow-Origin: *");
		switch ($id) {
			case 3: { // 本月
				$start=mktime(0,0,0,date('m'),1,date('Y'));
				$end=mktime(0,0,0,date('m'),date('d')+1,date('Y'));
			};break;
			case 2: { //本周
				$start = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y'));
				$end = mktime(0,0,0,date('m'),date('d'),date('Y'));
			};break;
			case 1: { // 今天
				$start = mktime(0,0,0,date('m'),date('d'),date('Y'));
				$end = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
			};break;
			default:{
				return '';
			}
		}

		 $date[]=date('Y-m-d H:i:s',$start);
		 $date[]=date('Y-m-d H:i:s',$end);
		 return $date;
	 }
   }
?>