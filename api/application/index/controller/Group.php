<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Group extends Auth {
    //添加组
    public function AddGroup() {
		$path = "Group/AddGroup";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$data['Group_Name'] = $request->post('Name.Name');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			if ($data['Group_Name'] == "") {
				$info['msg'] = "不能为空";
				$info['code'] = "3";
				return json($info);
			} else {
				$rs = Db::table('yunque_group')->where(['Group_Name' => $data['Group_Name'], 'Corporate_Id' => $data['Corporate_Id']])->find();
				if ($rs) {
					$info['msg'] = "名称存在";
					$info['code'] = "2";
					return json($info);
				} else {
					$rsult = DB::table('yunque_group')->insert($data);
					if ($rsult) {
						$info['msg'] = "新增成功";
						$info['code'] = "1";
						return json($info);
					} else {
						$info['msg'] = "新增失败";
						$info['code'] = "0";
						return json($info);
					}
				}
			}
		}else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //查询组
    public function SelectGroup() {
		$path = "Group/SelectGroup";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			$rs = DB::table('yunque_group')->where('Corporate_Id', $data['Corporate_Id'])->select();
			if ($rs) {
				$info['msg'] = "查询成功";
				$info['code'] = "1";
				$info['data'] = $rs;
				return json($info);
			} else {
				$info['msg'] = "数据为空";
				$info['code'] = "0";
				return json($info);
			}
		}else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //删除组
    public function DeleteGroup() {
		$path = "Group/DeleteGroup";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$id = $request->post('id');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			$result = DB::table('yunque_landing_page')->where(['Corporate_Id' => $data['Corporate_Id'], 'Group_Id' => $id])->find();
			if ($result) {
				$info['msg'] = "存在数据";
				$info['code'] = "2";
				return json($info);
			} else {
				$rs = db::table('yunque_group')->where(['Group_Id' => $id, 'Corporate_Id' => $data['Corporate_Id']])->delete();
				if ($rs) {
					$info['msg'] = "删除成功";
					$info['code'] = "1";
					return json($info);
				} else {
					$info['msg'] = "删除失败";
					$info['code'] = "0";
					return json($info);
				}
			}
		}else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //查询单个数据
    public function FindGroup() {
		$path = "Group/FindGroup";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$data['Group_Id'] = $request->post('id');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			$rsult = db::table('yunque_group')->where(['Group_Id' => $data['Group_Id'], 'Corporate_Id' => $data['Corporate_Id']])->find();
			if ($rsult) {
				$info['msg'] = "查询成功";
				$info['code'] = "1";
				$info['data'] = $rsult;
				return json($info);
			} else {
				$info['msg'] = "数据为空";
				$info['code'] = "0";
				return json($info);
			}
		}else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //修改组名
    public function UpdateGroup() {
		$path = "Group/UpdateGroup";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$data['Group_Id'] = $request->post('id');
			$data['Group_Name'] = $request->post('Name');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			if ($data['Group_Name'] == "") {
				$info['msg'] = "不能为空";
				$info['code'] = "3";
				return json($info);
			} else {
				$rs = DB::table('yunque_group')->where(['Group_Name' => $data['Group_Name'], 'Corporate_Id' => $data['Corporate_Id']])->find();
				if ($rs) {
					$info['msg'] = "名称存在";
					$info['code'] = "2";
					return json($info);
				} else {
					$rs = db::table('yunque_group')->where(['Group_Id' => $data['Group_Id'], 'Corporate_Id' => $data['Corporate_Id']])->update(['Group_Name' => $data['Group_Name']]);
					if ($rs) {
						$info['msg'] = "修改成功";
						$info['code'] = "1";
						return json($info);
					} else {
						$info['msg'] = "修改失败";
						$info['code'] = "0";
						return json($info);
					}
				}
			}
		}else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
}
?>