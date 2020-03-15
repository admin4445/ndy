<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\index\model\RoleModel;
use app\index\validate\RoleValidate;
class Role extends Auth{


    //修改角色的状态
    public function UpdateroleStatus(){
		$path="Role/UpdateroleStatus";
        if($this->GetAuth($path)){
			$request = Request:: instance();
			$token=$request->post('token');
			$list=db::table('yunque_userinfo')->where('UserToken',$token)->find();
			$id=$request->post('id');
			$data=db::table('yunque_role')->where(['Corporate_Id'=>$list['Corporate_Id'],'Role_Id'=>$id])->find();
			if(!$data){
				$info['msg']="请勿非法操作";
				$info['code']="0";
				return json($info);
			}else{
				$data['Status']=="1" ? $data['Status']="0" : $data['Status']="1";
				$rs=db::table('yunque_role')->where(['Role_Id'=>$id,'Corporate_Id'=>$list['Corporate_Id']])->update(['Status'=>$data['Status']]);
				if($rs){
					$info['msg']="操作成功";
					$info['code']="1";
					return json($info);
				}else{
					$info['msg']="操作失败";
					$info['code']="0";
					return json($info);
				}
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }


    //角色列表接口
    public function info(){
		$path="Role/info";
        if($this->GetAuth($path)){
			$request = Request::instance();
			$data = $request->post();
			$validate = new RoleValidate;
			if(!$validate->scene('Token')->check($data)){
				$info['msg'] = $validate->getError();
				$info['code'] = "0";
				return json($info);
			}else{
				$model = new RoleModel;
				$user = Db::table('yunque_userinfo')->where('UserToken',$data['token'])->find();
				$data['corporate'] = $user['Corporate_Id'];
				$code = $model->where(['Role_Id'=>['>',$user['Role_Id']],'Corporate_Id'=>$data['corporate']])->whereOr('Role_Name','Service')->select();
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
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}    
    } 
}
?>
