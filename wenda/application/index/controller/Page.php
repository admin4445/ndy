<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use app\index\model\PageModel;
class Page extends Auth {
    public $list = [];
    //添加
    public function insert() {
        $path = "Page/insert";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $Landingpage_Id = $request->post('id');
            $array['Avatar'] = $request->post('answer.Avatar');
            $array['Name'] = $request->post('answer.Name');
            $array['Content'] = $request->post('answer.Content');
            $array['City'] = $request->post('answer.City');
            $array['Grade'] = $request->post('answer.Grade');
            $array['Integral'] = $request->post('answer.Integral');
            $array['Label'] = $request->post('answer.Label');
            $array['Date'] = $request->post('answer.Date');
            $PID = $request->post('answer.PID');
            $validate = new \app\index\validate\updeteValidate;
            if (!$validate->scene('insert')->check($array)) {
                $info['msg'] = $validate->getError();
                $info['code'] = 2;
                return json($info);
            } else {
                $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->find();
                $data['Reply'] = json_decode($data['Reply'], true);
				$PidName="";
				if($PID){
					foreach($data['Reply'] as $key=>$value){
						if($value['ID']==$PID){
							$PidName=$value['Name'];
						}
					}
				}
                $result = ["Avatar" => $array['Avatar'], "Name" => $array['Name'], "Content" => $array['Content'], "Grade" => $array['Grade'], "City" => $array['City'], "Integral" => $array['Integral'], "Label" => $array['Label'], "Date" => $array['Date'], "ID" => uniqid(), "RootId" => uniqid(), "PID" => $PID, "time" => time(),"PidName"=>$PidName];
                if ($data['Reply'] == "") {
                    $a = array();
                    $data['Reply'] = $a;
                    array_push($data['Reply'], $result);
                    $data['Reply'] = json_encode($data['Reply']);
                    $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->update($data);
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
                    array_push($data['Reply'], $result);
                    $data['Reply'] = json_encode($data['Reply']);
                    $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->update($data);
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
    public function select() {
        $path = "Page/select";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('id');
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $id, 'Corporate_Id' => $Corporate_Id])->find();
            if ($data['Reply'] == "") {
                $info['msg'] = "数据为空";
                $info['code'] = "0";
                return json($info);
            } else {
                $data['Reply'] = json_decode($data['Reply'], true);
                $info['msg'] = "查询成功";
                $info['code'] = "1";
                $info['data'] = $data['Reply'];
                return json($info);
            }
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //查询单个数据
    public function Find() {
        $path = "Page/Find";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('ids');
            $Landingpage_Id = $request->post('id');
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->find();
            if ($data) {
                if ($data['Reply'] == "") {
                    $info['msg'] = "数据为空";
                    $info['code'] = "0";
                    return json($info);
                }
                $data['Reply'] = json_decode($data['Reply'], true);
                foreach ($data['Reply'] as $key => $value) {
                    if ($value['ID'] == $id) {
                        $info['msg'] = "查询成功";
                        $info['code'] = "1";
                        $info['data'] = $value;
                    }
                }
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
    //修改回答
    public function Update() {
        $path = "Page/Update";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $token = $request->post('token');
            $Landingpage_Id = $request->post('id');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $array['Avatar'] = $request->post('answer.Avatar');
            $array['Name'] = $request->post('answer.Name');
            $array['Content'] = $request->post('answer.Content');
            $array['City'] = $request->post('answer.City');
            $array['Grade'] = $request->post('answer.Grade');
            $array['Integral'] = $request->post('answer.Integral');
            $array['Label'] = $request->post('answer.Label');
            $array['Date'] = $request->post('answer.Date');
            $array['ID'] = $request->post('answer.ID');
            $array['PID'] = $request->post('answer.PID');
            $array['time'] = $request->post('answer.time');
            $validate = new \app\index\validate\updeteValidate;
            if (!$validate->scene('Update')->check($array)) {
                $info['msg'] = $validate->getError();
                $info['code'] = 2;
                return json($info);
            } else {
                $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->find();
                $data['Reply'] = json_decode($data['Reply'], true);
				$PidName="";
					foreach($data['Reply'] as $key=>$value){
						if($value['ID']==$array['PID']){
							$PidName=$value['Name'];
						}
					}

                for ($i = 0;$i < count($data['Reply']);$i++) {
                    if ($data['Reply'][$i]['ID'] == $array['ID']) {
                        $data['Reply'][$i]['Avatar'] = $array['Avatar'];
                        $data['Reply'][$i]['Name'] = $array['Name'];
                        $data['Reply'][$i]['Grade'] = $array['Grade'];
                        $data['Reply'][$i]['Content'] = $array['Content'];
                        $data['Reply'][$i]['City'] = $array['City'];
                        $data['Reply'][$i]['Integral'] = $array['Integral'];
                        $data['Reply'][$i]['Label'] = $array['Label'];
                        $data['Reply'][$i]['Date'] = $array['Date'];
                        $data['Reply'][$i]['ID'] = $array['ID'];
                        $data['Reply'][$i]['PID'] = $array['PID'];
                        $data['Reply'][$i]['time'] = $array['time'];
						$data['Reply'][$i]['PidName'] = $PidName;
						
                    }
                }
                $data['Reply'] = json_encode($data['Reply']);
                $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->update(['Reply' => $data['Reply']]);
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
    //删除操作
    public function delete() {
        $path = "Page/delete";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $id = $request->post('ids');
            $Landingpage_Id = $request->post('id');
            $token = $request->post('token');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->find();
            $data['Reply'] = json_decode($data['Reply'], true);
            //删除回答
            foreach ($data['Reply'] as $key => $value) {
                if ($value['ID'] == $id) {
                    array_splice($data['Reply'], $key, 1);
                }
            }
            //删除回答的所有评论
            foreach ($data['Reply'] as $key => $value) {
                if ($value['PID'] == $id) {
                    array_splice($data['Reply'], $key, 1);
                }
            }
            $data['Reply'] = json_encode($data['Reply']);
            $rs = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $Landingpage_Id, 'Corporate_Id' => $Corporate_Id])->update($data);
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
}
?>