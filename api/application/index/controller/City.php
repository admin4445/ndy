<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use app\index\model\CityModel;
class City extends Auth  {
    //查询城市
    public function SelectCity() {
		$path = "City/SelectCity";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$token = $request->post('token');
			$Province_Id = $request->post('Province_Id');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$Corporate_Id = $list['Corporate_Id'];
			$rs = Db::table('yunque_city')->where(['Corporate_Id' => $Corporate_Id, 'Province_Id' => $Province_Id])->select();
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
    //根据省名称查询城市
    public function SelectProvince_city() {
		$path = "City/SelectProvince_city";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$token = $request->post('token');
			$Province_Name = $request->post('name');
			$data = Db::table('yunque_province')->where('Province_Name', $Province_Name)->find();
			$Province_Id = $data['Province_Id'];
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$Corporate_Id = $list['Corporate_Id'];
			$rs = Db::table('yunque_city')->where(['Corporate_Id' => $Corporate_Id, 'Province_Id' => $Province_Id])->select();
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
    //添加城市
    public function AddCity() {
		$path = "City/AddCity";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$data['City_Number'] = $request->post('city.City_Number');
			$data['City_Name'] = $request->post('city.City_Name');
			$data['Province_Id'] = $request->post('id');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			$validate = new \app\index\validate\updeteValidate;
			if (!$validate->scene('AddCity')->check($data)) {
				$info['msg'] = $validate->getError();
				$info['code'] = 0;
				return json($info);
			} else {
				$rs = Db::table('yunque_city')->where(['City_Name' => $data["City_Name"], 'Corporate_Id' => $data['Corporate_Id']])->find();
				if ($rs) {
					$info['msg'] = "城市已存在";
					$info['code'] = "2";
					return json($info);
				} else {
					$user = new CityModel;
					$rs = $user->save($data);
					if ($rs) {
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
    //删除城市
    public function DeleteCity() {
		$path = "City/DeleteCity";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$data['City_Id'] = $request->post('id');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			$rsult = DB::table('yunque_scenic_spot')->where(['City_Id' => $data['City_Id'], 'Corporate_Id' => $data['Corporate_Id']])->select();
			if ($rsult) {
				$info['msg'] = "存在关联数据，不可直接删除";
				$info['code'] = "0";
				return json($info);
			}
			$user = new CityModel;
			$rs = CityModel::where($data)->delete();
			if ($rs) {
				$info['msg'] = "删除成功";
				$info['code'] = "1";
				return json($info);
			} else {
				$info['msg'] = "删除失败";
				$info['code'] = "0";
				return json($info);
			}
		}else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
	}
}
?>    