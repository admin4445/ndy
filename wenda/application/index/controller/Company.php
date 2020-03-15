<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\File;
use think\Request;
Class Company extends controller{

	public $Corporate_Id;
    //保存公司信息//////////////////////////////////////////////////////////////////////
    public function Register() {
			header("Access-Control-Allow-Origin: *");
			$validate = new \app\index\validate\CompanyValidate;
			//验证公司信息的字段是否规范
			$request = Request::instance();
			$data["Corporate_Name"] = $request->post('Corporate_Name');
			$data["Corporate_Tel"] = $request->post('Corporate_Tel');
			$data["Corporate_Boss"] = $request->post('Corporate_Boss');
			$UserName = $request->post('UserName');
			$UserPwd = $request->post('UserPwd');
			if ($UserName == "" && $UserPwd == "") {
				$info['msg'] = "账号或密码不能为空";
				$info['code'] = "0";
				return json($info);
			} else {
				//保存数据
				if (!$validate->check($data)) {
					$info['msg'] = $validate->getError();
					$info['code'] = "0";
					return json($info);
				} else {
					$corporateinfo = db::table('yunque_corporatename')->where('Corporate_Name', $data["Corporate_Name"])->find();

					if ($corporateinfo) {
						$info["msg"] = "该公司已注册";
						$info["code"] = 0;
						return json($info);
					} else {
						$code = db::table('yunque_userinfo')->where('UserName', $UserName)->find();
						if ($code) {
							$info["msg"] = "该账号已注册";
							$info["code"] = 0;
							return json($info);
						}
						$rs = db::table('yunque_corporatename')->insert($data);
						if ($rs) {
							$corporateinfo = db::table('yunque_corporatename')->where('Corporate_Name', $data["Corporate_Name"])->find();
							$this->Corporate_Id=$corporateinfo['Corporate_Id'];
							$userinfo['UserName'] = trim($UserName);
							$userinfo['Name']=$corporateinfo['Corporate_Boss'];
							$userinfo['UserPwd'] = md5($UserPwd);
							$userinfo['UserToken'] = md5($userinfo['UserName'] . 'abckkoovvxx');
							$userinfo['Corporate_Id'] =$this->Corporate_Id;
							$userinfo['Auditing'] = "0";
							$userinfo['Lable'] = "1";
							$rs = db::table('yunque_userinfo')->insert($userinfo);
							if ($rs == "1") {
								$role['Role_Name']="超级管理员";
								$role['Status']="1";
								$role['Description']="超级管理员";
								$role['Corporate_Id']=$this->Corporate_Id;
								$rs=db::table('yunque_role')->insert($role);
								if($rs){
									$listone=Db::table('yunque_role')->where(['Role_Name'=>"超级管理员",'Corporate_Id'=>$this->Corporate_Id])->find();
									$auth=db::table('yunque_permission')->select();
									for($i=0;$i<count($auth);$i++){
										$cc['Right_Id']=$auth[$i]['Right_Id'];
										$cc['Role_Id']=$listone['Role_Id'];
										$cc['Corporate_Id']=$this->Corporate_Id;
										db::table('yunque_rolepermission')->insert($cc);
									}
									$info["msg"] = "注册成功";
									$info["code"] = 1;
									return json($info);
								}else{
									$info["msg"] = "注册失败";
									$info["code"] = 1;
									return json($info);
								}
							} else {
								$info["msg"] = "注册失败";
								$info["code"] = 0;
								return json($info);
							}
						}
					}
				}
			}
		
    }
    //查询用户信息和所在的公司信息
    public function selectCompanyinfo() {
			header("Access-Control-Allow-Origin: *");
			$request = Request::instance();
			$token = $request->post('token');
			$data = Db::field('a.*,b.Role_Name')->table('yunque_userinfo a,yunque_role b')->where('a.UserToken',$token)->where('a.Role_Id=b.Role_Id', 'a.Corporate_Id=b.Corporate_Id')->select();
			$data=$data[0];
			if (!$data) {
				$info["msg"] = "查询失败";
				$info["code"] = 0;
				return json($info);
			} else {
				$list = db::table('yunque_corporatename')->where('Corporate_Id', $data['Corporate_Id'])->find();
				if ($list) {
					$info['msg'] = "查询成功";
					$info['code'] = "1";
					$user['User_Img'] = $data['User_Img'];
					$user['Role_Name'] = $data['Role_Name'];
					$user['Corporate_Name'] = $list['Corporate_Name'];
					$info['data'] = $user;
					return json($info);
				} else {
					$info["msg"] = "数据为空";
					$info["code"] = 0;
					return json($info);
				}
			}	
		
    }
}
?>