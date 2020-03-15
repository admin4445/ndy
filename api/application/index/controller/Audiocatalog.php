<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\File;
use think\Request;
class Audiocatalog extends Auth {
    //创建视频目录//////////////////////////////////////////////////
    public function AddAudiocatalog() {
        $path = "Audiocatalog/AddAudiocatalog";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $list['Catalog_Name'] = $request->post('name');
            $list['Pid'] = $request->post('pid');
            $list['RootId'] = $request->post('rootid');
            $list['Catalog_Level'] = $request->post('level');
            $flag = $request->post('Flag');
            if ($list['Catalog_Name'] == "") {
                $info['msg'] = "目录名不能为空";
                $info['code'] = 2;
                return json($info);
            } else {
                if ($flag == "folder") {
                    if ($list['Pid'] == "") {
                        $data = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
                        $rs = Db::table('yunque_audio_catalog')->where(['Pid' => $list['Pid'], 'Corporate_Id' => $data['Corporate_Id'], 'Catalog_Name' => $list['Catalog_Name']])->find();
                        if ($rs) {
                            $info['msg'] = "目录已存在";
                            $info['code'] = "3";
                            return json($info);
                        } else {
                            $rs = Db::table('yunque_audio_catalog')->insert($list);
                            if ($rs) {
                                $info['msg'] = "新建成功";
                                $info['code'] = "1";
                                $info['data'] = $rs;
                                return json($info);
                            } else {
                                $info['msg'] = "新建失败";
                                $info['code'] = "0";
                                return json($info);
                            }
                        }
                    } else {
                        $list['Catalog_Level'] = $list['Catalog_Level'];
                        $data = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
                        $list['Corporate_Id'] = $data['Corporate_Id'];
                        $rs = Db::table('yunque_audio_catalog')->where(['Pid' => $list['Pid'], 'Corporate_Id' => $list['Corporate_Id'], 'Catalog_Name' => $list['Catalog_Name']])->find();
                        if ($rs) {
                            $info['msg'] = "目录已存在";
                            $info['code'] = "0";
                            return json($info);
                        } else {
                            $rs = Db::table('yunque_audio_catalog')->insert($list);
                            if ($rs) {
                                $info['msg'] = "新建成功";
                                $info['code'] = "1";
                                $info['data'] = $rs;
                                return json($info);
                            } else {
                                $info['msg'] = "新建失败";
                                $info['code'] = "0";
                                return json($info);
                            }
                        }
                    }
                } else {
                    $info['msg'] = "新建失败";
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
    //查询视频目录///////////////////////////////////////////////////////
    public function SelectAudiocatalog() {
        $path = "Audiocatalog/SelectAudiocatalog";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $list['Pid'] = $request->post('pid');
            $list['Catalog_Level'] = $request->post('level');
            $data = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $list['Corporate_Id'] = $data['Corporate_Id'];
            $data = Db::table('yunque_audio_catalog')->where(['Pid' => $list['Pid'], 'Corporate_Id' => $list['Corporate_Id']])->select();
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
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //删除视频目录////////////////////////////////////////////////////////
    public function DeleteAudiocatalog() {
        $path = "Audiocatalog/DeleteAudiocatalog";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $Catalog_Id = $request->post('id');
            $data = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $list = Db::table('yunque_audio_catalog')->where(['Catalog_Id' => $Catalog_Id, 'Corporate_Id' => $data['Corporate_Id']])->find();
            if ($list) {
                $rs = Db::table('yunque_audio_catalog')->where(['Pid' => $list['Catalog_Id'], 'Corporate_Id' => $data['Corporate_Id']])->select();
                if ($rs) {
                    $info['msg'] = "目录存在数据";
                    $info['code'] = "2";
                    return json($info);
                } else {
                    $rs = Db::table('yunque_photo')->where(['Pid' => $list['Catalog_Id'], 'RootId' => $list['RootId']])->select();
                    if ($rs) {
                        $info['msg'] = "目录存在数据";
                        $info['code'] = "2";
                        return json($info);
                    } else {
                        $rs = Db::table('yunque_audio_catalog')->where(['Catalog_Id' => $list['Catalog_Id'], 'Corporate_Id' => $data['Corporate_Id']])->delete();
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
                }
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
    //单个视频目录的查询/////////////////////////////////////////////////////////////
    public function FindAudiocatalog() {
        $path = "Audiocatalog/FindAudiocatalog";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post();
            $id = $data['ids'];
            $rs = Db::table('yunque_userinfo')->where('UserToken', $data['token'])->find();
            $list['Corporate_Id'] = $rs['Corporate_Id'];
            $rsult = Db::table('yunque_audio_catalog')->where(['Catalog_Id' => ['in', $id], 'Corporate_Id' => $list['Corporate_Id']])->find();
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
    //修改视频目录//////////////////////////////////////////////////////////////////
    public function UpdateAudiocatalog() {
        $path = "Audiocatalog/UpdateAudiocatalog";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $list['Catalog_Id'] = $request->post('Id');
            $list['Catalog_Name'] = $request->post('Name');
            $flag = $request->post('Flag');
            if ($list['Catalog_Name'] == "") {
                $info['msg'] = "目录不能为空";
                $info['code'] = 2;
                return json($info);
            } else {
                if ($flag == "folder") {
                    $data = Db::table('yunque_userinfo')->where('UserToken', $token)->find();
                    $list['Corporate_Id'] = $data['Corporate_Id'];
                    $rs = Db::table('yunque_audio_catalog')->where(['Corporate_Id' => $list['Corporate_Id'], 'Catalog_Name' => $list['Catalog_Name']])->find();
                    if ($rs) {
                        $info['msg'] = "目录名称已存在";
                        $info['code'] = "3";
                        return json($info);
                    } else {
                        $rs = Db::table('yunque_audio_catalog')->where(['Catalog_Id' => $list['Catalog_Id'], 'Corporate_Id' => $list['Corporate_Id']])->update(['Catalog_Name' => $list['Catalog_Name']]);
                        if ($rs) {
                            $info['msg'] = "修改成功";
                            $info['code'] = "1";
                            $info['data'] = $rs;
                            return json($info);
                        } else {
                            $info['msg'] = "修改失败";
                            $info['code'] = "0";
                            return json($info);
                        }
                    }
                } else {
                    $info['msg'] = "操作失败";
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