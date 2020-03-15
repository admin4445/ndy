<?php
namespace app\index\controller;
use think\Controller;
use thinK\Request;
use think\Db;
class Pub extends controller {

	//游客评论
        public function Pinglun(){
            header("Access-Control-Allow-Origin: *");
            $request = Request:: instance();
            $data=$request->post();
            if($data['content']==""){
                $info['msg']="评论的内容不能为空";
                $info['code']="0";
                return json($info);
            }
            $Avatar="http://upload.cnsdvip.com/upload/photo/5c4155ee074f7.png";
            $Name="游客";
            $Date=date("Y/m/d");
            $soure=Db::table('yunque_landing_page')->where('Landingpage_Id',$data['Landingpage_Id'])->find();
            $soure['Reply'] = json_decode($soure['Reply'],true);
            $result= [
                    "Avatar" => $Avatar,
					"Name" => $Name, 
					"Content" => $data['content'],
					"Grade" =>"23", 
					"City" =>"上海", 
					"Integral" =>"1212",
					"Label" => "旅行达人", 
					"Date" => $Date, 
					"Zan"=>"12",
					"Ding"=>"52",
					"Cai"=>"25",
					"ID" => uniqid(), 
					"RootId" => uniqid(), 
					"PID" => $data['Pid'], 
					"time" => time(),
					"PidName"=>$data['PidName'],
            ];
            array_push($soure['Reply'],$result);
            $soure['Reply']= json_encode($soure['Reply']);
            $rs=Db::table('yunque_landing_page')->where('Landingpage_Id',$data['Landingpage_Id'])->update($soure);
            if($rs){
                $info['msg']="新增成功";
                $info['code']="1";
                return json($info);
            }else{
                $info['msg']="新增失败";
                $info['code']="0";
                return json($info);
            }
        }
    }
?>