<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Auth extends controller {
    
	public $role_name;
	public $jurisdiction=[];
	public function __construct() {
		//验证代码
		header("Access-Control-Allow-Origin: *");
		$request = Request::instance();
		$token = $request->post('token');
		$userinfo = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
		$role=db::table('yunque_role')->where('Role_Id',$userinfo['Role_Id'])->find();
		$this->role_name = $role['Role_Name'];
		if("超级管理员"!==$role['Role_Name']){
			if ($userinfo) {
				$rolejurisdiction = Db::table('yunque_role')->where('Role_Id', $userinfo['Role_Id'])->find();
				if (!$rolejurisdiction) {
					$info["msg"] = "您没有此操作权限";
					$info["code"] = 0;
					echo json_encode($info);
					exit;
				} else {
					$this->jurisdiction = Db::table('yunque_rolepermission')->where('Role_Id', $rolejurisdiction['Role_Id'])->select();
					if (!$this->jurisdiction) {
						$info["msg"] = "您没有此操作权限";
						$info["code"] = 0;
						echo json_encode($info);
						exit;
						}
					}
			} else {
				$info["msg"] = "您没有此操作权限";
				$info["code"] = 0;
				echo json_encode($info);
				exit;
			}
		}
    }
    public function GetAuth($data) {
		if("超级管理员"!==$this->role_name){
			$auth=$this->jurisdiction;
			for($i=0;$i<count($auth);$i++){
				$list[$i]=db::table('yunque_permission')->where('Right_Id',$auth[$i]['Right_Id'])->find();
				if($list[$i]['Right_Path']==$data){
					return 1;
				}else{
					 if($i==count($auth)){
						return 0;
						exit; 
					}
				}
			}
		}
		else{
			return 1;
		}
    }
}
?>