<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\index\model\RolepermissionModel;
use app\index\validate\RolepermissionValidate;

//角色权限控制器
class Rolepermission extends Auth{
    //权限列表
    public function info(){
		$path="Rolepermission/info";
        if($this->GetAuth($path)){
			$request = Request::instance(); 
			$data = $request->post();
			$validate = new RolepermissionValidate;
			if(!$validate->scene('Token')->check($data)){
				$info['msg'] = $validate->getError();
				$info['code'] = "0";
				return json($info);
			}else{
				$user = Db::table('yunque_userinfo')->where('UserToken',$data['token'])->find();
				if($user){
					$privilegetypename = Db::table('yunque_permissiontype')->select();
					$list = array();
					for($i = 0; $i < count($privilegetypename); $i++){
						$privilegetypename[$i]["auth"] = array();
					}
					for($i = 0; $i < count($privilegetypename); $i++){
						$privilegetypename[$i]["auth"] = Db::table('yunque_rolepermission a,yunque_permission b,yunque_permissiontype c')
						->where(['a.Role_Id'=>$user['Role_Id'],'c.PrivilegeTypeName'=>$privilegetypename[$i]['PrivilegeTypeName']])
						->where('a.Right_Id=b.Right_Id and b.PermissionType_Id=c.PermissionType_Id')->field('b.Right_Id,b.Right_Name,b.PermissionType_Id,c.PermissionType_Id,c.PrivilegeTypeName')->select();
					}
					if($privilegetypename){
						$info['msg'] = "查询成功";
						$info['code'] = "1";
						$info['data'] = $privilegetypename;
						return json($info);
					}else{
						$info['msg'] = "数据不存在";
						$info['code'] = "0";
						return json($info);
					}
				}else{
					$info['msg'] = "非法操作";
					$info['code'] = "0";
					return json($info);
				}
			}    
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }

    // rp Rolepermission 这个的简写，免得跟模型的方法混淆；
    public function Insertrp(){
		$path="Rolepermission/Insertrp";
        if($this->GetAuth($path)){
        $request = Request::instance();
        $list = $request->post();   //全部数据
        $data = $list['Role'];
        $validate = new RolepermissionValidate;
        if (!$validate->scene('Insert')->check($data)) {
            $info['msg'] = $validate->getError();
            $info['code'] = "0";
            return json($info);
        }else{
            if(!$validate->scene('Token')->check($list)){
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            }else{
                //if($data['Status'] == "0" || $data['Status'] == "1"){
                    $user = Db::table('yunque_userinfo')->where('UserToken',$list['token'])->find();
                    if($user['Corporate_Id']){
                        $data['corporate'] = $user['Corporate_Id'];
                        $role = Db::table('yunque_role')->where(['Role_Name'=>$data['Role_Name'],'Corporate_Id'=>$data['corporate']])->find();
                        if(!$role){
                            $model = new RolepermissionModel;
                            $datarole = ['Role_Name'=>$data['Role_Name'],'Description'=>$data['Description'],'Corporate_Id'=>$data['corporate']];
                            $code = Db::table('yunque_role')->insert($datarole);
                            if($code && $data['Right_Id']){
                                $role = Db::table('yunque_role')->where(['Role_Name'=>$data['Role_Name'],'Corporate_Id'=>$data['corporate']])->find();
                                for($i = 0; $i < count($data['Right_Id']); $i++){
                                    $rolepermission[$i] =
                                        ['Role_Id' => $role['Role_Id'],'Right_Id' => $data['Right_Id'][$i],'Corporate_Id'=>$data['corporate']];
                                }
                                $model->saveAll($rolepermission,false);
                                if($code){
                                    $info['msg'] = "角色添加成功";
                                    $info['code'] = "1";
                                    return json($info);
                                }else{
                                    $info['msg'] = "添加失败";
                                    $info['code'] = "0";
                                    return json($info);
                                }
                            }else{
                                $info['msg'] = "角色添加成功";
                                $info['code'] = "0";
                                return json($info);
                            }
                        }else{
                            $info['msg'] = 'error,角色名称已存在';
                            $info['code'] = "0";
                            return json($info);
                        }
                    }else{
                        //用户表与公司表存在关联，用户必须拥有公司id，不存在及违法，因数据库被篡改了
                        $info['msg'] = '对不起您没有公司';
                        $info['code'] = "0";
                        return json($info);
                    }
                //}else{
                    //$info['msg'] = 'error,请勿非法操作';
                    //$info['code'] = "0";
                    //return json($info);
                //}
            } 
        }
	}else{
		$info["msg"] = "您没有此操作权限";
		$info['code']="0";
		return json($info);
	}      
  }

    //此方法删除角色对应的权限和角色
    public function Deleterp(){
		$path="Rolepermission/Deleterp";
        if($this->GetAuth($path)){
			$request = Request::instance();
			$data = $request->post();   //全部数据
			$validate = new RolepermissionValidate;
			if(!$validate->scene('Delete')->check($data)){
				$info['msg'] = $validate->getError();
				$info['code'] = "0";
				return json($info);
			}else{
				$user = Db::table('yunque_userinfo')->where('UserToken',$data['token'])->find();
				if($user['Corporate_Id']){
					$data['corporate'] = $user['Corporate_Id'];
					$list = $data['ids'];
					for($i = 0; $i < count($list); $i++){
						$list[$i] = (int) $list[$i];
					}
					$userinfo = Db::table('yunque_userinfo')->where('Role_Id','in',$list)->find();
					if(!$userinfo){
						$model = new RolepermissionModel;
						$code = $model->where('Role_Id','in',$list)->where('Corporate_Id',$data['corporate'])->select();
						if($code){
							$code = $model->destroy($model->where('Role_Id',['in',$list],['>',$user['Role_Id']])->where('Corporate_Id',$data['corporate']));
							if($code){
								$code = Db::table('yunque_role')->where('Role_Id',['in',$list],['>',$user['Role_Id']])->where('Corporate_Id',$data['corporate'])->delete();
								if($code){
									$info['msg'] = '数据删除成功';
									$info['code'] = "1";
									return json($info);
								}else{
									$info['msg'] = "数据删除失败";
									$info['code'] = "0";
									return json($info);
								}
							}else{
								$info['msg'] = "角色权限删除失败";
								$info['code'] = "0";
								return json($info);
							}
						}else{
							$code = Db::table('yunque_role')->where('Role_Id',['in',$list],['>',$user['Role_Id']])->where('Corporate_Id',$data['corporate'])->delete();
							if($code){
								$info['msg'] = '数据删除成功';
								$info['code'] = "1";
								return json($info);
							}else{
								$info['msg'] = "数据删除失败";
								$info['code'] = "0";
								return json($info);
							}
						}
					}else{
						$info['msg'] = '对不起该角色存在用户，不得删除';
						$info['code'] = "0";
						return json($info);
					}
				}else{
					//用户表与公司表存在关联，用户必须拥有公司id，不存在及违法，因数据库被篡改了
					$info['msg'] = '对不起您没有公司';
					$info['code'] = "0";
					return json($info);
				}
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }
    
   

    // 修改单个角色 和 对应的权限的接口
    public function Updatarp(){
		$path="Rolepermission/Updatarp";
        if($this->GetAuth($path)){
        $request = Request::instance();
        $list = $request->post();   //全部数据
        $data = $list['Role'];
        $data['token'] = $list['token'];
        $validate = new RolepermissionValidate;
        if (!$validate->scene('Updata')->check($data)) {
            $info['msg'] = $validate->getError();
            $info['code'] = "0";
            return json($info);
        }else{
            $user = Db::table('yunque_userinfo')->where('UserToken',$data['token'])->find();
            if($user['Corporate_Id']){
                $data['corporate'] = $user['Corporate_Id'];
                $role = Db::table('yunque_role')->where(['Role_Name'=>$data['Role_Name'],'Corporate_Id'=>$data['corporate']])->count();
                if($role <= 1){
					

                    $role = Db::table('yunque_role')->where(['Role_Id'=>$data['Role_Id'],'Corporate_Id'=>$data['corporate']])
                    ->update(['Role_Name'=>$data['Role_Name'],'Status'=>$data['Status'],'Description'=>$data['Description']]);
                        $model = new RolepermissionModel;
                        $rolepermission = $model->where(['Role_Id'=>$data['Role_Id'],'Corporate_Id'=>$data['corporate']])->field('Right_Id')->select();
                        $role = array();
                        for($i = 0; $i < count($rolepermission); $i++){
                            $role[$i] = $rolepermission[$i]['Right_Id'];
                        }
                        $diff = array_diff($data['Right_Id'],$role);
                        $diff2 = array_diff($role,$data['Right_Id']);
                        $code = $model->where(['Role_Id'=>$user['Role_Id'],'Corporate_Id'=>$data['corporate']])->field('Right_Id')->select();
                        for($i = 0; $i < count($code); $i++){
                            $role[$i] = $code[$i]['Right_Id'];
                        }
                        $Right_Id = array_diff($data['Right_Id'],$role);
                        if($Right_Id){
                            $info['msg'] = 'error，非法错误';
                            $info['code'] = "0";
                            return json($info);
                        }
                        if($diff){
                            $diff = array_values($diff);
                            $list = null;
                            for($i = 0; $i < count($diff); $i++){
                                $list[$i] = ['Role_Id'=>$data['Role_Id'],'Right_Id'=>$diff[$i],'Corporate_Id'=>$data['corporate']];
                            }
                            $rightdelete = $model->saveAll($list,false);
                        }else{
                            $rightdelete = 1;
                        }
                        if($diff2){
                            $list = array_values($diff2);
                            for($i = 0; $i < count($list); $i++){
                                $list[$i] = (int) $list[$i];
                            }
                            $rightdelete2 = $model->where('Right_Id','in',$list)->where(['Role_Id'=>$data['Role_Id'],'Corporate_Id'=>$data['corporate']])->delete();
                        }else{
                            $rightdelete2 = 1;
                        }
                        if($rightdelete && $rightdelete2){
                            $info['msg'] = '修改成功';
                            $info['code'] = "1";
                            return json($info);
                        }else{
                            $info['msg'] = 'error，修改出错';
                            $info['code'] = "0";
                            return json($info);
                        }
                   
                }else{
                    $info['msg'] = 'error,角色名称已存在';
                    $info['code'] = "0";
                    return json($info);
                }
            }else{
                $info['msg'] = "对不起您没有公司";
                $info['code'] = "0";
                return json($info);
            }
        }	
	}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}       
  }

    //查询单个角色对应的权限
    public function Selectrp(){
		$path="Rolepermission/Selectrp";
        if($this->GetAuth($path)){
			header("Access-Control-Allow-Origin: *");
			$request = Request::instance();
			$list = $request->post();   //全部数据
			$validate = new RolepermissionValidate;
			if (!$validate->scene('Select')->check($list)) {
			$info['msg'] = $validate->getError();
			$info['code'] = "0";
			return json($info);
			}else{
				$user = Db::table('yunque_userinfo')->where('UserToken',$list['token'])->find();
				if($user['Corporate_Id']){
					$model = new RolepermissionModel;
					$code = $model->where(['Role_Id'=>$list['id'],'Corporate_Id'=>$user['Corporate_Id']])->field('Right_Id')->select();
					if($code){
						$info['msg'] = "查询成功";
						$info['code'] = "1";
						$info['data'] = $code;
						return json($info);
					}else{
						$info['msg'] = "数据不存在";
						$info['code'] = "0";
						return json($info);
					}
				}else{
					$info['msg'] = "对不起您没有公司";
					$info['code'] = "0";
					return json($info);
				}
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }
}
?>