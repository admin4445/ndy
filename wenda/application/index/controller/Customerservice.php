<?php
  namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
class Customerservice extends Auth {
    //查询落地页对应的客服
    public function SelectFindPageCustomerService() {
		$path = "Customerservice/SelectFindPageCustomerService";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $Landingpage_Id = $request->post('floorid');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = db::table('yunque_landing_page')->where(['Corporate_Id' => $Corporate_Id, 'Landingpage_Id' => $Landingpage_Id])->find();
            if ($data['CustomerService_Id'] == "") {
                $info['msg'] = "数据为空";
                $info['code'] = "0";
                return json($info);
            } else {
                $data['CustomerService_Id'] = json_decode($data['CustomerService_Id'], true);
                for ($i = 0;$i < count($data['CustomerService_Id']);$i++) {
                    $id = $data['CustomerService_Id'][$i]['Pid'];
                    $rs = db::table('yunque_userinfo')->where(['User_Id' => $id, 'Status' => 1])->find();
                    if ($rs) {
                    } else {
                        array_splice($data['CustomerService_Id'], $i, 1);
                        $i--;
                    }
                    $id = null;
                }
                if (0 < count($data['CustomerService_Id'])) {
                    for ($i = 0;$i < count($data['CustomerService_Id']);$i++) {
                        $soure = DB::table('yunque_userinfo')->where('User_Id', $data['CustomerService_Id'][$i]['Pid'])->find();
                        if ($soure) {
                            $data['CustomerService_Id'][$i]['Pid'] = $soure['UserName'];
                        }
                    }
                    $info['msg'] = "查询成功";
                    $info['code'] = "1";
                    $info['data'] = $data['CustomerService_Id'];
                    return json($info);
                } else {
                    $info['msg'] = "数据为空";
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
    //添加落地页的客服
    public function AddFindPageCustomerService() {
		$path = "Customerservice/AddFindPageCustomerService";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('id');
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data['CustomerService_Name'] = $request->post('customer.CustomerService_Name');
            $data['User_Id'] = $request->post('customer.User_Id');
            $data['CustomerService_Sex'] = $request->post('customer.CustomerService_Sex');
            $data['Photo'] = $request->post('customer.User_Img');
            $data['CustomerService_Tel'] = $request->post('customer.CustomerService_Tel');
            $data['CustomerService_Wechat'] = $request->post('customer.CustomerService_Wechat');
            $data['QrCode'] = $request->post('customer.User_Qrcode');
            $data['Status'] = $request->post('customer.Status');
            $validate = new \app\index\validate\LandingpageValidate;
            if (!$validate->scene('AddFindPageCustomerService')->check($data)) {
                $info['msg'] = $validate->getError();
                $info['code'] = 0;
                return json($info);
            } else {
                $datasoure = db::table('yunque_landing_page')->where(['Corporate_Id' => $Corporate_Id, 'Landingpage_Id' => $id])->find();
                $result = ["Pid" => $data['User_Id'], "CustomerService_Name" => $data['CustomerService_Name'], "CustomerService_Sex" => $data['CustomerService_Sex'], "Photo" => $data['Photo'], "CustomerService_Tel" => $data['CustomerService_Tel'], "CustomerService_Wechat" => $data['CustomerService_Wechat'], "QrCode" => $data['QrCode'], "Status" => $data['Status'], "Id" => uniqid(), "time" => time(), ];
                if (empty($datasoure['CustomerService_Id'])) {
                    $datasoure['CustomerService_Id'] = array();
                    array_push($datasoure['CustomerService_Id'], $result);
                    $datasoure['CustomerService_Id'] = json_encode($datasoure['CustomerService_Id']);
                    $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $id, 'Corporate_Id' => $Corporate_Id])->update($datasoure);
                    if ($rs) {
                        $info['msg'] = "新增成功";
                        $info['code'] = "1";
                        return json($info);
                    } else {
                        $info['msg'] = "新增失败";
                        $info['code'] = "0";
                        return json($info);
                    }
                } else {
					$code="";
                    $datasoure['CustomerService_Id'] = json_decode($datasoure['CustomerService_Id'], true);
                    foreach ($datasoure['CustomerService_Id'] as $key => $value) {
                        $value['CustomerService_Name'] == $data['CustomerService_Name'] ? $code = "1" : $code = "0";
                    }
                    if ($code == "1") {
                        $info['msg'] = "名称已存在";
                        $info['code'] = "0";
                        return json($info);
                    } else {
                        array_push($datasoure['CustomerService_Id'], $result);
                        $datasoure['CustomerService_Id'] = json_encode($datasoure['CustomerService_Id']);
                        $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $id, 'Corporate_Id' => $Corporate_Id])->update($datasoure);
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
            }
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //查询客服个人信息
    public function FindCustomerService() {
		$path = "Customerservice/FindCustomerService";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $Landingpage_Id = $request->post('ids');
            $Id = $request->post('id');
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = db::table('yunque_landing_page')->where(['Corporate_Id' => $Corporate_Id, 'Landingpage_Id' => $Landingpage_Id])->find();
            $data['CustomerService_Id'] = json_decode($data['CustomerService_Id'], true);
            for ($i = 0;$i < count($data['CustomerService_Id']);$i++) {
                if ($data['CustomerService_Id'][$i]['Id'] == $Id) {
                    $info['msg'] = "查询成功";
                    $info['code'] = "1";
                    $info['data'] = $data['CustomerService_Id'][$i];
                    return json($info);
                } else {
                    $code = "";
                }
            }
            if ($code == "") {
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
    //修改落地页客服信息和客服信息
    public function UpdateCustomerService() {
		$path = "Customerservice/UpdateCustomerService";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $Landingpage_Id = $request->post('ids');
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data['Id'] = $request->post('id');
            $data['CustomerService_Name'] = $request->post('customer.CustomerService_Name');
            $data['User_Id'] = $request->post('customer.User_Id');
            $data['CustomerService_Sex'] = $request->post('customer.CustomerService_Sex');
            $data['Photo'] = $request->post('customer.User_Img');
            $data['CustomerService_Tel'] = $request->post('customer.CustomerService_Tel');
            $data['CustomerService_Wechat'] = $request->post('customer.CustomerService_Wechat');
            $data['QrCode'] = $request->post('customer.User_Qrcode');
            $data['Status'] = $request->post('customer.Status');
            $validate = new \app\index\validate\LandingpageValidate;
            if (!$validate->scene('UpdateCustomerService')->check($data)) {
                $info['msg'] = $validate->getError();
                $info['code'] = 0;
                return json($info);
            } else {
                $datasoure = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->find();
                $datasoure['CustomerService_Id'] = json_decode($datasoure['CustomerService_Id'], true);
                for ($j = 0;$j < count($datasoure['CustomerService_Id']);$j++) {
                    if ($datasoure['CustomerService_Id'][$j]['Id'] == $data['Id']) {
                        $datasoure['CustomerService_Id'][$j]['Pid'] = $data['User_Id'];
                        $datasoure['CustomerService_Id'][$j]['CustomerService_Name'] = $data['CustomerService_Name'];
                        $datasoure['CustomerService_Id'][$j]['CustomerService_Sex'] = $data['CustomerService_Sex'];
                        $datasoure['CustomerService_Id'][$j]['Photo'] = $data['Photo'];
                        $datasoure['CustomerService_Id'][$j]['CustomerService_Tel'] = $data['CustomerService_Tel'];
                        $datasoure['CustomerService_Id'][$j]['CustomerService_Wechat'] = $data['CustomerService_Wechat'];
                        $datasoure['CustomerService_Id'][$j]['QrCode'] = $data['QrCode'];
                        $datasoure['CustomerService_Id'][$j]['Status'] = $data['Status'];
                        $datasoure['CustomerService_Id'][$j]['Id'] = $data['Id'];
                        $datasoure['CustomerService_Id'][$j]['time'] = time();
                    }
                }
                $datasoure['CustomerService_Id'] = json_encode($datasoure['CustomerService_Id']);
                $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->update($datasoure);
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
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //删除落地页客服
    function DeleteCustomerService() {
		$path = "Customerservice/DeleteCustomerService";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $Landingpage_Id = $request->post('ids');
            $Id = $request->post('id');
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->find();
            $data['CustomerService_Id'] = json_decode($data['CustomerService_Id'], true);
            foreach ($data['CustomerService_Id'] as $key => $value) {
                if ($value['Id'] == $Id) {
                    array_splice($data['CustomerService_Id'], $key, 1);
                }
            }
            if (count($data['CustomerService_Id']) == "0") {
                $data['CustomerService_Id'] = "";
            } else {
                $data['CustomerService_Id'] = json_encode($data['CustomerService_Id']);
            }
            $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->update(['CustomerService_Id' => $data['CustomerService_Id']]);
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
    //修改落地页客服状态
    public function UpdateCustomerServiceCode() {
		$path = "Customerservice/UpdateCustomerServiceCode";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $Landingpage_Id = $request->post('ids');
            $token = $request->post('token');
            $id = $request->post('id');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->find();
            $data['CustomerService_Id'] = json_decode($data['CustomerService_Id'], true);
            for ($i = 0;$i < count($data['CustomerService_Id']);$i++) {
                if ($data['CustomerService_Id'][$i]['Id'] == $id) {
                    if ($data['CustomerService_Id'][$i]['Status'] == "1") {
                        $data['CustomerService_Id'][$i]['Status'] = "0";
                    } else {
                        $data['CustomerService_Id'][$i]['Status'] = "1";
                    }
                }
            }
            $data['CustomerService_Id'] = json_encode($data['CustomerService_Id']);
            $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->update(['CustomerService_Id' => $data['CustomerService_Id']]);
            if ($rs) {
                $info['msg'] = "修改成功";
                $info['code'] = "1";
                return json($info);
            } else {
                $info['msg'] = "修改失败";
                $info['code'] = "0";
                return json($info);
            }
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //查询客服对应的业务员的信息
    public function selectuserinfo() {
		$path = "Customerservice/selectuserinfo";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $rs = db::table('yunque_role')->where(['Corporate_Id' => $Corporate_Id, 'Role_Name' => "Service"])->find();
            if ($rs) {
                $data = db::table('yunque_userinfo')->where(['Corporate_Id' => $Corporate_Id, 'Role_Id' => $rs['Role_Id']])->select();
                for ($i = 0;$i < count($data);$i++) {
                    $data[$i]['Record'] = json_decode($data[$i]['Record'], true);
                }
                if ($data) {
                    $info['msg'] = "查询成功";
                    $info['code'] = "1";
                    $info['data'] = $data;
                    return json($info);
                } else {
                    $info['msg'] = "查询数据为空";
                    $info['code'] = "0";
                    return json($info);
                }
            } else {
                $info['msg'] = "数据不存在";
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