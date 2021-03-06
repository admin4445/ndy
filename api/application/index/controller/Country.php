<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use app\index\model\CountryModel;
class Country extends Auth {
    //添加国家
    public function AddCountry() {
		$path = "Country/AddCountry";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$data['Country_Number'] = $request->post('country.Country_Number');
			$data['Country_Name'] = $request->post('country.Country');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$data['Corporate_Id'] = $list['Corporate_Id'];
			$validate = new \app\index\validate\updeteValidate;
			if (!$validate->scene('AddCountry')->check($data)) {
				$info['msg'] = $validate->getError();
				$info['code'] = 0;
				return json($info);
			} else {
				$rs = Db::table('yunque_country')->where(['Country_Name' => $data["Country_Name"], 'Corporate_Id' => $data['Corporate_Id']])->find();
				if ($rs) {
					$info['msg'] = "国家已存在";
					$info['code'] = "2";
					return json($info);
				} else {
					$user = new CountryModel;
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
    //查询国家
    public function SelectCountry() {
		$path = "Country/SelectCountry";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$Corporate_Id = $list['Corporate_Id'];
			$rs = Db::table('yunque_country')->where('Corporate_Id', $Corporate_Id)->select();
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
    //删除国家
    public function DeleteCountry() {
		$path = "Country/DeleteCountry";
        if ($this->GetAuth($path)) {
			$request = Request::instance();
			$id = $request->post('id');
			$token = $request->post('token');
			$list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
			$Corporate_Id = $list['Corporate_Id'];
			$rs = Db::table('yunque_province')->where(['Country_Id' => $id, 'Corporate_Id' => $Corporate_Id])->select();
			if ($rs) {
				$info['msg'] = "国家存在数据";
				$info['code'] = '0';
				return json($info);
			} else {
				$rs = Db::table('yunque_country')->where(['Country_Id' => $id, 'Corporate_Id' => $Corporate_Id])->delete();
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
}
?>