<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use app\index\model\ProvinceModel;
class Province extends Auth {
    //添加省份
    public function AddProvince() {
        $path = "Province/AddProvince";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data['Provincial_Number'] = $request->post('province.Province_Number');
            $data['Province_Name'] = $request->post('province.Province');
            $data['Country_Id'] = $request->post('id');
            $token = $request->post('token');
            $list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $data['Corporate_Id'] = $list['Corporate_Id'];
            $validate = new \app\index\validate\updeteValidate;
            if (!$validate->scene('AddProvince')->check($data)) {
                $info['msg'] = $validate->getError();
                $info['code'] = 0;
                return json($info);
            } else {
                $rs = Db::table('yunque_province')->where(['Province_Name' => $data["Province_Name"], 'Corporate_Id' => $data['Corporate_Id']])->find();
                if ($rs) {
                    $info['msg'] = "省份已存在";
                    $info['code'] = "2";
                    return json($info);
                } else {
                    $user = new ProvinceModel;
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
    //查询
    public function SelectProvince() {
        $path = "Province/SelectProvince";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $Country_Id = $request->post('Country_Id');
            $token = $request->post('token');
            $list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $rs = Db::table('yunque_province')->where(['Corporate_Id' => $Corporate_Id, 'Country_Id' => $Country_Id])->select();
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
    //根据国家名称查询省
    public function SelectCountry_Province() {
        $path = "Province/SelectCountry_Province";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $Country_Name = $request->post('name');
            $data = Db::table('yunque_country')->where('Country_Name', $Country_Name)->find();
            $Country_Id = $data['Country_Id'];
            $list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $rs = Db::table('yunque_province')->where(['Corporate_Id' => $Corporate_Id, 'Country_Id' => $Country_Id])->select();
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
    //删除省份
    public function DeleteProvince() {
        $path = "Province/DeleteProvince";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('id');
            $token = $request->post('token');
            $list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $rs = Db::table('yunque_city')->where(['Province_Id' => $id, 'Corporate_Id' => $Corporate_Id])->select();
            if ($rs) {
                $info['msg'] = "省份存在数据";
                $info['code'] = '0';
                return json($info);
            } else {
                $rs = Db::table('yunque_province')->where(['Province_Id' => $id, 'Corporate_Id' => $Corporate_Id])->delete();
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