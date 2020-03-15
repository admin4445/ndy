<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\File;
use think\Request;
class Photo extends Auth {
    //查询图片/////////////////////////////////////////
    public function SelectImg() {
        $path = "Photo/SelectImg";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $rootid = $request->post('rootid');
            $level = $request->post('level');
            $pid = $request->post('pid');
            if ($pid == "") {
                $info['msg'] = "数据为空";
                $info['code'] = "0";
                return json($info);
            } else {
                $list = Db::table('yunque_photo')->where('Pid', $pid)->select();
                if ($list) {
                    $info['msg'] = "查询成功";
                    $info['code'] = "1";
                    $info['data'] = $list;
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
    //新增图片////////////////////////////////////////////
    public function AddImg() {
        $path = "Photo/AddImg";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post();
            $list['Img_Name'] = $data['upload']['Img_Name'];
            $list['Img_Path'] = $data['upload']['upload_Img'];
            $list['Catalog_Level'] = $data['level'];
            $list['RootId'] = $data['rootid'];
            $list['Pid'] = $data['pid'];
            if ($list['Pid'] == "") {
                $info['msg'] = "添加失败";
                $info['code'] = "0";
                return json($info);
            } else {
                if ($list['Img_Name'] == "") {
                    $info['msg'] = "图片名不能为空";
                    $info['code'] = 3;
                    return json($info);
                } else {
                    $rsult = Db::table('yunque_photo')->where(['Img_Name' => $list['Img_Name'], 'Pid' => $list['Pid'], 'RootId' => $list['RootId']])->find();
                    if ($rsult) {
                        $info['msg'] = "图片名称已存在";
                        $info['code'] = "2";
                        return json($info);
                    } else {
                        $rs = Db::table('yunque_photo')->insert($list);
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
    //删除图片/////////////////////////////////////////////////////
    public function DeleteImg() {
        $path = "Photo/DeleteImg";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $Img_Id = $request->post('Img_Id');
            $data = Db::table('yunque_photo')->where('Img_Id', $Img_Id)->find();
            if (!$data) {
                $info['msg'] = "数据为空";
                $info['code'] = "0";
                return json($info);
            } else {
                $rs = Db::table('yunque_photo')->where(['Img_Id' => ['in', $Img_Id], 'Pid' => $data['Pid']])->delete();
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
    //查询图片的单个数据///////////////////////////////////////////////////
    public function FindImg() {
        $path = "Photo/FindImg";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('ids');
            $data = db::table('yunque_photo')->where('Img_Id', $id)->find();
            if ($data) {
                $info['msg'] = "查询成功";
                $info['code'] = "1";
                $info['data'] = $data;
                return json($info);
            } else {
                $info['msg'] = "数据为空";
                $Info['code'] = "0";
                return json($info);
            }
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //修改图片///////////////////////////////////////////////////
    public function UpdateImg() {
        $path = "Photo/UpdateImg";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data['Img_Id'] = $request->post('Img_Id');
            $data['Img_Name'] = $request->post('Img_Name');
            $token = $request->post('token');
            $imginfo = Db::table('yunque_photo')->where('Img_Id', $data['Img_Id'])->find();
            if (!$imginfo) {
                $info['msg'] = "数据为空";
                $info['code'] = 0;
                return json($info);
            } else {
                $rsult = Db::table('yunque_photo')->where(['Img_Name' => $data['Img_Name'], 'Pid' => $imginfo['Pid']])->find();
                if ($rsult) {
                    $info['msg'] = "图片名称已存在";
                    $info['code'] = "2";
                    return json($info);
                } else {
                    if ($data['Img_Name'] == "") {
                        $info['msg'] = "图片名不能为空";
                        $info['code'] = 3;
                        return json($info);
                    } else {
                        $rs = Db::table('yunque_photo')->where(['Img_Id' => $data['Img_Id'], 'Pid' => $imginfo['Pid']])->update(['Img_Name' => $data['Img_Name']]);
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
            }
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
}
?>