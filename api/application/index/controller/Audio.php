<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\File;
use think\Request;
class Audio extends Auth {
    //查询音频/////////////////////////////////////////
    public function SelectAudio() {
        $path = "Audio/SelectAudio";
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
                $list = Db::table('yunque_audio')->where('Pid', $pid)->select();
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
    //新增音频////////////////////////////////////////////
    public function AddAudio() {
        $path = "Audio/AddAudio";
        if($this->GetAuth($path)){
            $request = Request::instance();
            $data = $request->post();
            $list['Audio_Name'] = $data['upload']['Audio_Name'];
            $list['Audio_Path'] = $data['upload']['Audio_Path'];
            $list['Catalog_Level'] = $data['level'];
            $list['RootId'] = $data['rootid'];
            $list['Pid'] = $data['pid'];
            if ($list['Pid'] == "") {
                $info['msg'] = "添加失败";
                $info['code'] = "0";
                return json($info);
            } else {
                if ($list['Audio_Name'] == "") {
                    $info['msg'] = "视频名称不能为空";
                    $info['code'] = 3;
                    return json($info);
                } else {
                    $rsult = Db::table('yunque_audio')->where(['Audio_Name' => $list['Audio_Name'], 'Pid' => $list['Pid'], 'RootId' => $list['RootId']])->find();
                    if ($rsult) {
                        $info['msg'] = "视频名称已存在";
                        $info['code'] = "2";
                        return json($info);
                    } else {
                        $rs = Db::table('yunque_audio')->insert($list);
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
    //删除音频/////////////////////////////////////////////////////
    public function DeleteAudio() {
        $path = "Audio/DeleteAudio";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $Audio_Id = $request->post('Audio_Id');
            $data = Db::table('yunque_audio')->where('Audio_Id', $Audio_Id)->find();
            if (!$data) {
                $info['msg'] = "数据为空";
                $info['code'] = "0";
                return json($info);
            } else {
                $rs = Db::table('yunque_audio')->where(['Audio_Id' => ['in', $Audio_Id], 'Pid' => $data['Pid']])->delete();
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
    //查询音频的单个数据///////////////////////////////////////////////////
    public function FindAudio() {
        $path = "Audio/FindAudio";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('ids');
            $data = db::table('yunque_audio')->where('Audio_Id', $id)->find();
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
    //修改音频///////////////////////////////////////////////////
    public function UpdateAudio() {
        $path = "Audio/UpdateAudio";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data['Audio_Id'] = $request->post('Audio_Id');
            $data['Audio_Name'] = $request->post('Audio_Name');
            $videoinfo = Db::table('yunque_audio')->where('Audio_Id', $data['Audio_Id'])->find();
            if (!$videoinfo) {
                $info['msg'] = "数据为空";
                $info['code'] = 0;
                return json($info);
            } else {
                $rsult = Db::table('yunque_audio')->where(['Audio_Name' => $data['Audio_Name'], 'Pid' => $videoinfo['Pid']])->find();
                if ($rsult) {
                    $info['msg'] = "视频名称已存在";
                    $info['code'] = "2";
                    return json($info);
                } else {
                    if ($data['Audio_Name'] == "") {
                        $info['msg'] = "视频名称不能为空";
                        $info['code'] = 3;
                        return json($info);
                    } else {
                        $rs = Db::table('yunque_audio')->where('Audio_Id',$data['Audio_Id'])->update(['Audio_Name' => $data['Audio_Name']]);
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