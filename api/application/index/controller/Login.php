<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Request;
use app\index\model\LoginModel;
use app\index\validate\LoginValidate;
//登陆控制器
class Login extends Controller {
    //登陆控制器
    //账号密码  登陆
    public function login() {
        header("Access-Control-Allow-Origin: *");
        $code = $this->UserToken();
        if ($code) {
            $info['msg'] = "登陆成功";
            $info['code'] = "1";
            $info['UserToken'] = $code['UserToken'];
            $info['data'] = $code;
            return json($info);
        } else {
            if (request()->ispost()) {
                $request = Request::instance();
                //全局使用 htmlspecialchars 过滤
                $data = $request->post();
                $validate = new LoginValidate;
                if (!$validate->check($data)) {
                    $info['data'] = $validate->getError();
                    $info['msg'] = "登陆失败";
                    $info['code'] = "0";
                    return json($info);
                } else {
                    $md5 = md5($data['userpwd']);
                    $model = new LoginModel;
                    $code = $model->where(['UserName' => $data['username'], 'UserPwd' => $md5])->find();
                    if ($code['Auditing'] == '0') {
                        $info['msg'] = "未审核";
                        $info['code'] = "0";
                        return json($info);
                    }
                    if (($code['UserName'] == $data['username']) && ($code['UserPwd'] == $md5)) {
                        $info['msg'] = "登陆成功";
                        $info['code'] = "1";
                        $info['UserToken'] = $code['UserToken'];
                        $info['data'] = $code;
                        return json($info);
                    } else {
                        $info['msg'] = "登陆失败";
                        $info['code'] = "0";
                        return json($info);
                    }
                }
            } else {
                $info['msg']="非法请求";
				$info['code']="0";
				return json($info);
            }
        }
    }
    //token登陆
    public function UserToken() {
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        //全局使用 htmlspecialchars 过滤
        $data = $request->post();
        //实例化 UserinfoModel 类
        if (array_key_exists('token', $data)) {
            if ($data['token']) {
                $model = new LoginModel;
                $code = $model->where(['UserToken' => $data['token'], 'Auditing' => '1'])->find();
                return $code;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
