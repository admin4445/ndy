<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\File;
use think\Request;
class Order extends Auth {
    //添加订单
    public function Addorder() {
        $path = "Order/Addorder";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $data['Contacts'] = $request->post('Contacts');
            $data['Telephone'] = $request->post('Telephone');
            $data['Number'] = $request->post('Number');
            $data['Trip'] = $request->post('Trip');
            $data['TotalSum'] = $request->post('TotalSum');
            $data['Deposit'] = $request->post('Deposit');
            $data['Date'] = $request->post('Date');
            $data['Operator'] = $request->post('Operator');
            $data['Remarks'] = $request->post('Remarks');
            $validate = new \app\index\validate\orderValidate;
            if (!$validate->scene('Addorder')->check($data)) {
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            } else {
                $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
                $data['Corporate_Id'] = $userinfo['Corporate_Id'];
                $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
                $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
                $data['Order_Number'] = $orderSn;
                $data['Status'] = "1";
                if (!$userinfo) {
                    $info['msg'] = "非法操作";
                    $info['code'] = "0";
                    return json($info);
                } else {
                    $rs = db::table('yunque_order')->insert($data);
                    if ($rs) {
                        $info['msg'] = "添加成功";
                        $info['code'] = "1";
                        return json($info);
                    } else {
                        $info['msg'] = "添加失败";
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
    //查询列表订单
    public function Selectorder() {
        $path = "Order/Selectorder";
          if($this->GetAuth($path)){
            $request = Request::instance();
            $token = $request->post('token');
            $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            if (!$userinfo) {
                $info['msg'] = "非法操作";
                $info['code'] = "0";
                return json($info);
            } else {
                $data = db::table('yunque_order')->where('Corporate_Id', $userinfo['Corporate_Id'])->select();
                if ($data) {
                    $info['msg'] = "查询成功";
                    $info['code'] = "1";
                    $info['data'] = $data;
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
    //查询单个订单
    public function Findorder() {
        $path = "Order/Findorder";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('id');
            $token = $request->post('token');
            $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            if (!$userinfo) {
                $info['msg'] = "非法操作";
                $info['code'] = "0";
                return json($info);
            } else {
                $data = DB::table('yunque_order')->where(['Order_Id' => $id, 'Corporate_Id' => $userinfo['Corporate_Id']])->find();
                if ($data) {
                    $info['msg'] = "查询成功";
                    $info['code'] = "1";
                    $info['data'] = $data;
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
    //筛选订单
    public function Filtrateorder() {
        $path = "Order/Filtrateorder";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $Contacts = $request->post('Contacts');
            $token = $request->post('token');
            $map['Contacts'] = ['like', '%' . $Contacts . '%'];
            $list = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $map['Corporate_Id'] = $list['Corporate_Id'];
            $data = db::table('yunque_order')->where(['Contacts' => $map['Contacts'], 'Corporate_Id' => $map['Corporate_Id']])->select();
            if ($data) {
                $info["data"] = $data;
                $info["msg"] = "查询成功";
                $info["code"] = "1";
                return json($info);
            } else {
                $info["msg"] = "数据为空";
                $info["code"] = "0";
                return json($info);
            }
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //修改订单
    public function Updateorder() {
        $path = "Order/Updateorder";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post();
            $validate = new \app\index\validate\orderValidate;
            if (!$validate->scene('Updateorder')->check($data)) {
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            } else {
                $userinfo = db::table('yunque_userinfo')->where('UserToken', $data['token'])->find();
                $data['Corporate_Id'] = $userinfo['Corporate_Id'];
                if (!$userinfo) {
                    $info['msg'] = "非法操作";
                    $info['code'] = "0";
                    return json($info);
                } else {
                    //
                    $rs = db::table('yunque_order')->where(['Corporate_Id' => $data['Corporate_Id'], 'Order_Id' => $data['Order_Id']])->update(['Contacts' => $data['Contacts'], 'Telephone' => $data['Telephone'], 'Number' => $data['Number'], 'Trip' => $data['Trip'], 'TotalSum' => $data['TotalSum'], 'Deposit' => $data['Deposit'], 'Date' => $data['Date'], 'Operator' => $data['Operator'], 'Remarks' => $data['Remarks'], 'Status' => $data['Status'], ]);
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
    //删除订单
    public function Deleteorder() {
        $path = "Order/Deleteorder";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('id');
            $token = $request->post('token');
            $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            if (!$userinfo) {
                $info['msg'] = "非法操作";
                $info['code'] = "0";
                return json($info);
            } else {
                $data = DB::table('yunque_order')->where(['Order_Id' => $id, 'Corporate_Id' => $userinfo['Corporate_Id']])->delete();
                if ($data) {
                    $info['msg'] = "删除成功";
                    $info['code'] = "1";
                    $info['data'] = $data;
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
