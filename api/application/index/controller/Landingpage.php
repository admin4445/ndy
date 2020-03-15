<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use app\index\model\LandingpageModel;
class Landingpage extends Auth {
	//列表问答////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function selectLandingpage() {
        if ($this->GetAuth("Landingpage/selectLandingpage")) {
            $request = Request::instance();
            $token = $request->post('token');
            $Group_Id = $request->post('id');
            $list = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $list['Corporate_Id'];
            $data = db::table('yunque_landing_page')->where(['Corporate_Id' => $Corporate_Id, 'Group_Id' => $Group_Id])->order('Status','desc')->select();
            if ($data) {
                for($i=0;$i<count($data);$i++){
					$data[$i]['Question']=json_decode($data[$i]['Question'],true);
					$data[$i]['Reply']=json_decode($data[$i]['Reply'],true);
					$data[$i]["P"]="http://".$data[$i]["BindDomain"].'/'."index.php/index/Show/p?id=".$data[$i]["Landingpage_Id"];
					$data[$i]["W"]="http://".$data[$i]["BindDomain"].'/'."index.php/index/Show/w?id=".$data[$i]["Landingpage_Id"];
					// $data[$i]["P"]="http://".$data[$i]["BindDomain"]."/"."wenda/p?id=".$data[$i]["Landingpage_Id"];
					// $data[$i]["W"]="http://".$data[$i]["BindDomain"]."/"."wenda/w?id=".$data[$i]["Landingpage_Id"];
					//$data[$i]["P"]="http://".$data[$i]["BindDomain"]."/"."index.php/p?id=".$data[$i]["Landingpage_Id"]."&"."p=p";
					//$data[$i]["W"]="http://".$data[$i]["BindDomain"]."/"."index.php/p?id=".$data[$i]["Landingpage_Id"]."&"."p=w";
					http://www.wenda.com/index.php/index/show/p?id=1
                }
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
	//查找问答//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function FindLandingpage() {
        if ($this->GetAuth("Landingpage/FindLandingpage")) {
            $request = Request::instance();
            $rs = db::table('yunque_landing_page')->where(['Landingpage_Id' => $request->post('id')])->find();
            $rs["Question"] = json_decode($rs['Question'],true);
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

	//模板列表/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function Selecttemplate(){
		if ($this->GetAuth("Landingpage/Selecttemplate")){
			$request = Request::instance();
            $token = $request->post('token');
			$soure = db::table('yunque_userinfo')->where('UserToken', $token)->find();
            $Corporate_Id = $soure['Corporate_Id'];
			$data=db::table('yunque_template')->where('Corporate_Id',"Null")->select();
			if($data){
				$list=db::table('yunque_template')->where('Corporate_Id',$Corporate_Id)->select();
				if($list){
					for($i=0;$i<count($list);$i++){
						array_push($data,$list[$i]);
					}
					$info['msg']="查询成功";
					$info['code']="1";
					$info['data']=$data;
					return json($info);
				}else{
					$info['msg']="查询成功";
					$info['code']="1";
					$info['data']=$data;
					return json($info);
				}
			}else{
				$info['msg'] = "数据为空";
				$info['code'] = "0";
				return json($info);
			}

			
		}
		
	}

    //添加落地页//////////////////////////////////////////////////////////////////////////////////////////////////////
    public function AddLandingpage() {
        if ($this->GetAuth("Landingpage/AddLandingpage")) {
            $validate = new \app\index\validate\LandingpageValidate;
            $request = Request::instance();
            $check['Avatar'] = $request->post('Floor.Question.Avatar');
            $check['Title'] = $request->post('Floor.Question.Title');
            $check['Content'] = $request->post('Floor.Question.Content');
            $check['NickName'] = $request->post('Floor.Question.NickName');
			$check['Date'] = $request->post('Floor.Question.Date');
            $check['City'] = $request->post('Floor.Question.City');
            if (!$validate->scene('AddLandingpage')->check($check)) {
                $info['msg'] = $validate->getError();
                $info['code'] = 0;
                return json($info);
            } else {
				$data['Avatar'] = $request->post('Floor.Question.Avatar');
				$data['Title'] = $request->post('Floor.Question.Title');
				$data['Content'] = $request->post('Floor.Question.Content');
				$data['NickName'] = $request->post('Floor.Question.NickName');
				$data['Date'] = $request->post('Floor.Question.Date');
				$data['City'] = $request->post('Floor.Question.City');
                $row['Question'] = json_encode($data);
                $row['Copyright'] = $request->post('Floor.Copyright');
				$row['FllowNum'] = $request->post('Floor.FllowNum');
				$row['VisitNum'] = $request->post('Floor.VisitNum');
				$row['BindDomain'] = $request->post('Floor.BindDomain');
				$row['CensusCode']=$request->post('Floor.CensusCode');
				$row['Status'] = $request->post('Floor.Status');
				$row['Template'] = $request->post('Floor.Template');
				$row['Platform'] = $request->post('Floor.Platform');
                $row['Group_Id'] = $request->post('id');
                $token = $request->post('token');
                $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
                if (!$userinfo) {
                    $info['msg'] = "数据为空";
                    $info['code'] = "0";
                    return json($info);
                } else {
                    $row['Corporate_Id'] = $userinfo['Corporate_Id'];
                    $rs = Db::table('yunque_landing_page')->insert($row);
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

    //修改问答////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function UpdateLandingpage() {
        if ($this->GetAuth("Landingpage/UpdateLandingpage")) {
            $request = Request::instance();
			$check['Avatar'] = $request->post('Floor.Question.Avatar');
			$check['Title'] = $request->post('Floor.Question.Title');
			$check['Content'] = $request->post('Floor.Question.Content');
			$check['NickName'] = $request->post('Floor.Question.NickName');
			$check['Date'] = $request->post('Floor.Question.Date');
            $check['City'] = $request->post('Floor.Question.City');
            $validate = new \app\index\validate\LandingpageValidate;
            if(!$validate->scene('UpdateLandingpage')->check($check)) {
                $info['msg'] = $validate->getError();
                $info['code'] = 0;
                return json($info);
            }else{
				$data['Avatar'] = $request->post('Floor.Question.Avatar');
				$data['Title'] = $request->post('Floor.Question.Title');
				$data['Content'] = $request->post('Floor.Question.Content');
				$data['NickName'] = $request->post('Floor.Question.NickName');
				$data['Date'] = $request->post('Floor.Question.Date');
				$data['City'] = $request->post('Floor.Question.City');
                $row['Question'] = json_encode($data,true);
                $row['FllowNum'] = $request->post('Floor.FllowNum');
				$row['VisitNum'] = $request->post('Floor.VisitNum'); 
				$row['BindDomain'] = $request->post('Floor.BindDomain');
				$row['CensusCode']= $request->post('Floor.CensusCode');
                $row['Copyright'] = $request->post('Floor.Copyright');
				$row['Template'] = $request->post('Floor.Template');
				$row['Platform'] = $request->post('Floor.Platform');
				$row['Status'] = $request->post('Floor.Status');
                $rsult=db::table('yunque_landing_page')->where(['Landingpage_Id' => $request->post('Floor.Landingpage_Id')])->update($row);
                if($rsult){
                    $info['msg'] = "修改成功";
                    $info['code'] = "1";
                    return json($info);
                }else{
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
    //删除问答//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function DeleteLandingpage() {
        if ($this->GetAuth("Landingpage/DeleteLandingpage")) {
            $request = Request::instance();
            $rsult = db::table('yunque_landing_page')->where(['Landingpage_Id' => $request->post('id')])->delete();
            if($rsult){
                $info['msg'] = "删除成功";
                $info['code'] = "1";
                return json($info);
            }else{
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
    //复制问答////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function CopyLandingpage() {
        if ($this->GetAuth("Landingpage/CopyLandingpage")) {
            $request = Request::instance();
            $id = $request->post('id');
            $data = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $id])->field('Landingpage_Id',true)->find();
            $rsult = db::table('yunque_landing_page')->insert($data);
            if ($rsult) {
                $info['msg'] = "复制成功";
                $info['code'] = "1";
                return json($info);
            } else {
                $info['msg'] = "复制失败";
                $info['code'] = "0";
                return json($info);
            }
        }else{
			$info['msg'] = "您没有此操作权限";
            $info['code'] = "0";
            return json($info);
		}
    }
    //修改状态///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function UpdateCode() {
        if($this->GetAuth("Landingpage/UpdateCode")) {
            $request = Request::instance();
            $data = db::table('yunque_landing_page')->where('Landingpage_Id',$request->post('id'))->find();
            $data['Status'] == "1" ? $data['Status'] = "0" : $data['Status'] = "1";
            $rsult = Db::table('yunque_landing_page')->where(['Landingpage_Id' => $request->post('id')])->update(['Status' => $data['Status']]);
            if ($rsult) {
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


    //由于 前后端 命名对不上 所以自定义 微信小程序  接口
    //修改  落地页  客服 信息接口
    public function Updateserviceinfo() {
        $path = "Landingpage/Updateserviceinfo";
        if ($this->GetAuth($path)) {
            $request = Request::instance();
            $data = $request->post();
            $validate = new LandingpageValidate;
            if (!$validate->scene('Updateservice')->check($data)) {
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            } else {
                $user = Db::table('yunque_userinfo')->where('UserToken', $data['token'])->find();
                if ($user) {
                    $model = new LandingpageModel;
                    $code = $model->where(['Corporate_Id' => $user['Corporate_Id'], 'Landingpage_Id' => $data['id']])->find();
                    if ($code) {
                        if (!$validate->scene('Updateserviceinfo')->check($data['data'])) {
                            $info['msg'] = $validate->getError();
                            $info['code'] = "0";
                            return json($info);
                        } else {
                            if ($code['CustomerService_Id']) {
                                $a = json_decode($code['CustomerService_Id'], true);
                                for ($i = 0;$i < count($a);$i++) {
                                    if ($a[$i]['Id'] == $data['data']['Id']) {
                                        $a[$i]['CustomerService_Name'] = $data['data']['CustomerService_Name'];
                                        $a[$i]['CustomerService_Sex'] = $data['data']['CustomerService_Sex'];
                                        $a[$i]['Photo'] = $data['data']['Photo'];
                                        $a[$i]['CustomerService_Tel'] = $data['data']['CustomerService_Tel'];
                                        $a[$i]['CustomerService_Wechat'] = $data['data']['CustomerService_Wechat'];
                                        $a[$i]['QrCode'] = $data['data']['QrCode'];
                                        $a[$i]['Status'] = $data['data']['Status'];
                                        $a[$i]['time'] = time();
                                    }
                                }
                                $a = json_encode($a);
                                $code = null;
                                $code = $model->save(['CustomerService_Id' => $a, ], ['Landingpage_Id' => $data['id']]);
                                if ($code) {
                                    $info['msg'] = "操作成功";
                                    $info['code'] = "1";
                                    return json($info);
                                } else {
                                    $info['msg'] = "操作失败";
                                    $info['code'] = "0";
                                    return json($info);
                                }
                            }
                        }
                    } else {
                        $info['msg'] = "数据不存在";
                        $info['code'] = "0";
                        return json($info);
                    }
                } else {
                    $info['msg'] = "公司不存在";
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