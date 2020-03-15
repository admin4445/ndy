<?php
 namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use think\facade\Cookie;
use app\index\model\User;
use app\index\controller\Page;
use app\index\model\HomeModel;
class Home extends Auth {
    public $list = [];
    //////////////////////////////////                  控制器                   //////////////////////////////////////////////
    //渲染的落地页
    public function Rendering() {
        $path = "Home/Rendering";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token);
            $id=$request->post('id);
            $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            if (!$userinfo) {
                $info['msg'] = "非法操作";
                $info['code'] = "0";
                return json($info);
            }
            //第一步获取数据
            $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $id, 'Corporate_Id' => $userinfo['Corporate_Id']])->find();
            //第二步随机客服
            $cid = array_rand(json_decode($data['CustomerService_Id'], true), 1);
            $customer = json_decode($data['CustomerService_Id'], true) [$cid];
            //第三步替换客服
            $data['Title'] = str_replace("[avatar]", "<img src='" . $customer["Photo"] . "' />", $data['Title']);
            $data['Title'] = str_replace("[nickname]", $customer["CustomerService_Name"], $data['Title']);
            $data['Title'] = str_replace("[tel]", $customer["CustomerService_Tel"], $data['Title']);
            $data['Title'] = str_replace("[wechat]", $customer["CustomerService_Wechat"], $data['Title']);
            $data['Title'] = str_replace("[qrcode]", "<img src='" . $customer["QrCode"] . "' />", $data['Title']);
            $data['Reply'] = str_replace("[avatar]", "<img src='" . $customer["Photo"] . "' />", $data['Reply']);
            $data['Reply'] = str_replace("[nickname]", $customer["CustomerService_Name"], $data['Reply']);
            $data['Reply'] = str_replace("[tel]", $customer["CustomerService_Tel"], $data['Reply']);
            $data['Reply'] = str_replace("[wechat]", $customer["CustomerService_Wechat"], $data['Reply']);
            $data['Reply'] = str_replace("[qrcode]", "<img src='" . $customer["QrCode"] . "' />", $data['Reply']);
            //第四步构建数据
            $page['question'] = json_decode($data['Title'], true);
            $page['answer'] = [];
            $reply = json_decode($data["Reply"], true);
            for ($i = 0;$i < count($reply);$i++) {
                if ("" == $reply[$i]["PID"]) {
                    array_push($page['answer'], $reply[$i]);
                }
            }
            for ($k = 0;$k < count($page['answer']);$k++) {
                $page['answer'][$k]["comment"] = [];
                $this->select2($reply, $page["answer"][$k]["ID"], $k);
                $page['answer'][$k]["comment"] = $this->list;
                $this->list = [];
            }
            //第五步渲染数据
            $this->assign('data', $page);
            return $this->fetch('index');
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    public function select2($data, $id, $i) {
        $path = "Home/select2";
        if ($this->GetAuth($path)) {
            foreach ($data as $key => $val) {
                if ($val['PID'] == $id) {
                    array_push($this->list, $val);
                    $this->select2($data, $val["ID"], $i);
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