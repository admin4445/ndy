<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Replay extends Auth{
		//添加评论
		public function AddReplay(){
			$path="Replay/AddReplay";
			if($this->GetAuth($path)){
				$request = Request:: instance();
				$token=$request->post('token');
				$list=db::table('yunque_userinfo')->where('UserToken',$token)->find();
				$Corporate_Id=$list['Corporate_Id'];
				$array['Content']=$request->post('Content');
				$id=$request->post('Id');
				$PID=$request->post('Pid');
				$RootId=$request->post('RootId');
				if($id==$PID){
					$info['msg']="操作错误";
					$info['code']="0";
					return json($info); 
				}else{
					$array['time']=time();
					$Landingpage_Id=$request->post('ids');
					$data=Db::table('yunque_landing_page')->where(['Landingpage_Id'=>$Landingpage_Id,'Corporate_Id'=>$Corporate_Id])->find();
					$data['Reply'] = json_decode($data['Reply'],true);
					foreach($data['Reply'] as $key=>$value){
						if($value['RootId']==$RootId&&$value['ID']==$PID){
							$info['msg']="操作错误";
							$info['code']="0";
							return json($info);
						}
					}
					$PidName="";
					foreach($data['Reply'] as $key=>$value){
						if($value['ID']==$PID){
							$PidName=$value['Name'];
						}
					}

					foreach($data['Reply'] as $key=>$val){
						if($val['ID']==$id){
							$array['Name']=$val['Name'];
							$array['Avatar']=$val['Avatar'];
							$array['Grade']=$val['Grade'];
							$array['City']=$val['City'];
							$array['Integral']=$val['Integral'];
							$array['Label']=$val['Label'];
							$array['Date']=$val['Date'];
							$array['Date']=$val['Date'];
							$array['ID']=uniqid();
							$array['RootId']=$RootId;
							$array['PID']= $PID;
							$array['PidName']=$PidName;
							break;
						}

					}
					array_push($data['Reply'],$array);
					$data['Reply']= json_encode($data['Reply']);
					$rs=Db::table('yunque_landing_page')->where(['Landingpage_Id'=>$Landingpage_Id,'Corporate_Id'=>$Corporate_Id])->update(['Reply'=>$data['Reply']]);
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
				}else{
					$info['msg'] = "您没有此操作权限";
					$info['code'] = "0";
					return json($info);
				}
			}
	}
   ?>
