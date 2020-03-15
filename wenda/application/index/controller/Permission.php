<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Validate;
use think\Db;
use app\index\model\PermissionModel;
use app\index\validate\PermissionValidate;
//权限控制器
class Permission extends Auth {
    public function info() {
        $path = "Permission/info";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post();
            $validate = new RoleValidate;
            if (!$validate->scene('Token')->check($data)) {
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            } else {
                $model = new RoleModel;
                $user = Db::table('yunque_userinfo')->where('UserToken', $data['token'])->find();
                $data['corporate'] = $user['Corporate_Id'];
                $code = $model->where('Corporate_Id', $data['corporate'])->select();
                if ($code) {
                    $info['msg'] = "查询成功";
                    $info['code'] = "1";
                    $info['data'] = $code;
                    return json($info);
                } else {
                    $info['msg'] = "数据不存在";
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
    // right 是 Permission 的简写，免得跟模型里的方法混淆；
    public function Insertright() {
        $path = "Permission/Insertright";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post(); //全部数据，一维数组
            $validate = new PermissionValidate;
            if (!$validate->scene('Insert')->check($data)) {
                return $validate->getError();
            } else {
                $code = Db::table('yunque_permission')->where('Right_Name', $data['name'])->count();
                if ($code == 0) {
                    $model = new PermissionModel;
                    $code = $model->InsertPermission($data);
                    if ($code) {
                        $info['msg'] = "操作成功";
                        $info['code'] = "1";
                        return json($info);
                    } else {
                        $info['msg'] = "操作失败";
                        $info['code'] = "0";
                        return json($info);
                    }
                } else {
                    $info['msg'] = 'error,权限名称已存在';
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
    public function Deleteright() {
        $path = "Permission/Deleteright";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post(); //全部数据，一维数组
            $validate = new PermissionValidate;
            if (!$validate->scene('Delete')->check($data)) {
                return $validate->getError();
            } else {
                // 要判断是否拥有这个权限
                $model = new PermissionModel;
                $code = $model->DeletePermission($data);
                if ($code) {
                    $info['msg'] = '数据删除成功';
                    $info['code'] = "1";
                    return json($info);
                } else {
                    $info['msg'] = "数据删除失败";
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
    public function Updataright() {
        $path = "Permission/Updataright";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post(); //全部数据，一维数组
            $validate = new PermissionValidate;
            if (!$validate->scene('Updata')->check($data)) {
                return $validate->getError();
            } else {
                $code = Db::table('yunque_permission')->where('Right_Name', $data['name'])->count();
                if ($code == 0) {
                    $model = new PermissionModel;
                    $code = $model->UpdataPermission($data);
                    if ($code) {
                        $info['msg'] = '数据修改成功';
                        $info['code'] = "1";
                        return json($info);
                    } else {
                        $info['msg'] = "数据修改失败";
                        $info['code'] = "0";
                        return json($info);
                    }
                } else {
                    $info['msg'] = 'error,权限名称已存在';
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
    public function Selectright() {
        $path = "Permission/Selectright";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post(); //全部数据，一维数组
            $validate = new PermissionValidate;
            if (!$validate->scene('Select')->check($data)) {
                return $validate->getError();
            } else {
                $model = new PermissionModel;
                $code = $model->SelectPermission($data);
                if ($code) {
                    $info['msg'] = "操作成功";
                    $info['code'] = "1";
                    $info['data'] = $code;
                    return json($info);
                } else {
                    $info['msg'] = "数据未找到";
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