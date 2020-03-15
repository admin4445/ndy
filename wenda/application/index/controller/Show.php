<?php
namespace app\index\controller;
use think\Controller;
use \think\Request;
use think\Db;
use think\Cookie;
use think\Cache;
use \think\View;
class Show extends Controller{

	public function aa(){
		echo "1";
	}

    public function p(){
    	header("Access-Control-Allow-Origin: *");
        $request = Request::instance();	
         $Landingpage_Id = $request->get('id');
      
        $data = Db::table('yunque_static_page')->where(['Landingpage_Id'=>$Landingpage_Id,'PageType'=>'p'])->find();
        if(!$data){
        	$model = new \app\index\controller\Actionshow;
        	return $model->p($Landingpage_Id);
        }
        $key=$this->tj($Landingpage_Id,'123456');
		$var=explode(",",$key);
		$page['key'] = $var;
		$this->assign('data',$page);
        return $this->fetch($data['PagePath']);
    }

    public function w(){
    	header("Access-Control-Allow-Origin: *");
        $request = Request::instance();	
        $Landingpage_Id = $request->get('id');
        // $Landingpage_Id = 304;
        $data = Db::table('yunque_static_page')->where(['Landingpage_Id'=>$Landingpage_Id,'PageType'=>'w'])->find();
        if(!$data){
        	$model = new \app\index\controller\Actionshow;
        	return $model->w($Landingpage_Id);
        }
        $key=$this->tj($Landingpage_Id,'123456');
		$var=explode(",",$key);
		$page['key'] = $var;
		$this->assign('data',$page);
        return $this->fetch($data['PagePath']);
    }

  	public function tj($e,$tel){
		$model = new \app\index\controller\Statisticss;
		$a=$model->index($e,$tel);
    	return $a;
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
		return null;
	}
}
?> 