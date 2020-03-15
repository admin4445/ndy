<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\File;
use think\Request;

class Video extends Auth {


     //查询视频/////////////////////////////////////////
     public  function SelectVideo(){
		$path="Video/SelectVideo";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$rootid=$request->post('rootid');
			$level=$request->post('level');
			$pid=$request->post('pid');
			if($pid==""){
			$info['msg']="数据为空";
			$info['code']="0";
			return json($info);
			}else{
			$list=Db::table('yunque_video')->where('Pid',$pid)->select();
			if($list){
				$info['msg']="查询成功";
				$info['code']="1";
				$info['data']=$list;
				return json($info);
			}else{
				$info['msg']="数据为空";
				$info['code']="0";        
				return json($info);
			  }
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}
     }

     //新增视频////////////////////////////////////////////
     public function AddVideo(){
		$path="Video/AddVideo";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$data=$request->post();
			$list['Video_Name']=$data['upload']['Video_Name'];
			$list['Video_Path']=$data['upload']['Video_Path'];
			$list['Catalog_Level']=$data['level'];
			$list['RootId']=$data['rootid'];
			$list['Pid']=$data['pid'];
			if($list['Pid']==""){
				$info['msg']="添加失败";
				$info['code']="0";
				return json($info);
			}else{
				if($list['Video_Name']==""){
					$info['msg']="视频名称不能为空";
					$info['code']=3;
					return json($info);
				}else{
					$rsult= Db::table('yunque_video')->where(['Video_Name'=> $list['Video_Name'],'Pid'=> $list['Pid'],'RootId'=>$list['RootId']])->find();
					if($rsult){
						 $info['msg']="视频名称已存在";
						 $info['code']="2";
						 return json($info);
					}else{
					$rs=Db::table('yunque_video')->insert($list);
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
				}
			}else{
				$info["msg"] = "您没有此操作权限";
				$info['code']="0";
				return json($info);
			}   
		}

     //删除视频/////////////////////////////////////////////////////
     public  function DeleteVideo(){
		$path="Video/DeleteVideo";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$Video_Id=$request->post('Video_Id') ;
			$data=Db::table('yunque_video')->where('Video_Id',$Video_Id)->find();
			if(!$data){
			   $info['msg']="数据为空";
			   $info['code']="0";
			   return json($info);
			}else{
			   $rs=Db::table('yunque_video')->where(['Video_Id'=>['in',$Video_Id],'Pid'=> $data['Pid']])->delete();
			   if($rs){
					$info['msg']="删除成功";
					$info['code']="1";
					return json($info);
			   }else{
					$info['msg']="删除失败";
					$info['code']="0";
					return json($info);
			   }
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
     }

     //查询视频的单个数据///////////////////////////////////////////////////
     
     public  function  FindVideo(){
		$path="Video/FindVideo";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$id= $request->post('ids');
			$data=db::table('yunque_video')->where('Video_Id',$id)->find();
			if($data){
			   $info['msg']="查询成功";
			   $info['code']="1";
			   $info['data']=$data;
			   return json($info);
			}else{
			   $info['msg']="数据为空";
			   $Info['code']="0";
			   return json($info);
			}
		}
		else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
          
     }
     
     //修改视频///////////////////////////////////////////////////
     public function UpdateVideo(){
		$path="Video/UpdateVideo";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$data['Video_Id']=$request->post('Video_Id');
			$data['Video_Name']=$request->post('Video_Name');
			$videoinfo=Db::table('yunque_video')->where('Video_Id',$data['Video_Id'])->find();
			if(!$videoinfo){
			   $info['msg']="数据为空";
			   $info['code']=0;
			   return json($info); 
			}else{
				$rsult= Db::table('yunque_video')->where(['Video_Name'=> $data['Video_Name'],'Pid'=> $videoinfo['Pid']])->find();
				if($rsult){
					$info['msg']="视频名称已存在";
					$info['code']="2";
					return json($info);
				}else{
					if($data['Video_Name']==""){
						$info['msg']="视频名称不能为空";
						$info['code']=3;
						return json($info);    

					}else{
						$rs=Db::table('yunque_video')->where(['Video_Id'=> $data['Video_Id'],'Pid'=> $videoinfo['Pid']])->update(['Video_Name'=>$data['Video_Name']]);
						if($rs){
							$info['msg']="修改成功";
							$info['code']="1";
							return json($info);
						}else{
							$info['msg']="修改失败";
							$info['code']="0";
							return json($info);
						}
					}
				}
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
     }
}
?>