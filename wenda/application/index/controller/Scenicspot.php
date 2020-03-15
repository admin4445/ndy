<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\File;
use think\Request;
use app\index\model\ScenicsSpotModel;
class Scenicspot extends Auth {

      
	//添加景点数据
	public  function AddScenicSpot(){
	$path="Scenicspot/AddScenicSpot";
	if($this->GetAuth($path)){
		$request=Request::instance();
		$data['ScenicSpot_Name']=$request->post('addspot.ScenicSpot_Name');
		$data['ScenicSpot_Introduction']=$request->post('addspot.ScenicSpot_Introduction');
		$data['ScenicSpot_Pictures']=$request->post('addspot.ScenicSpot_Pictures');
		$data['ScenicSpot_Type']=$request->post('addspot.ScenicSpot_Type');
		$City_Name=$request->post('selectedCity');
		if($City_Name==""){
			$info['msg']="城市不能为空";
			$info['code']="0";
			return json($info);
		}else{
			$validate = new \app\index\validate\ScenicSpotValidate;   
			if (!$validate->scene('AddScenicSpot')->check($data)) {
				$info['msg']=$validate->getError();
				$info['code']=0;
				return json($info);
			}else{
				$rs=Db::table('yunque_city')->where('City_Name',$City_Name)->find();
				$data['City_Id']=$rs['City_Id'];
				$token=$request->post('token');   
				$list=Db::table('yunque_userinfo')->where('UserToken',$token)->find(); 
				$data['Corporate_Id']=$list['Corporate_Id'];
				$rs=Db::table('yunque_scenic_spot')->where(['ScenicSpot_Name'=>$data['ScenicSpot_Name'],'Corporate_Id'=> $data['Corporate_Id']])->find();
				if($rs){
					$info['msg']="景点名称已存在";
					$info['code']="0";
					return json($info); 
				}else{
					$rs=Db::table('yunque_scenic_spot')->insert($data);
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

       //查询景点数据
      public function SelectScenicspot(){
		$path="Scenicspot/SelectScenicspot";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$token=$request->post('token');
			$data=Db::table('yunque_userinfo')->where('UserToken',$token)->find();
			$data=Db::table('yunque_scenic_spot')->where('Corporate_Id',$data['Corporate_Id'])->select();
			if($data){
				$info['data']=$data;
				$info['msg']="查询成功";
				$info['code']='1';
				return json($info);
			}else{          
				$info['msg']="数据为空";
				$info['code']='0';
				return json($info);
			 }
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}    
      }

	//查询单个景点的数据
	public function FindScenicspot(){
		$path="Scenicspot/FindScenicspot";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$id=$request->post('id');
			$token=$request->post('token');
			$list=Db::table('yunque_userinfo')->where('UserToken',$token)->find();
			$data=Db::table('yunque_scenic_spot')->where(['ScenicsSpot_Id'=>3581,'Corporate_Id'=>80])->find();
			if($data){
				$info['data']=$data;
				$info['msg']="查询成功";
				$info['code']='1';
				return json($info);
			}else{          
				$info['msg']="数据为空";
				$info['code']='0';
				return json($info);
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
	}

      //根据景点名称来模糊查询
      public function FiltrateSelectScenicspot(){
		$path="Scenicspot/FiltrateSelectScenicspot";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$list=$request->post();
			$map['Name'] = ['like', '%' . $list['ScenicsSpot_Name'] . '%'];
			$map['Corporate_Id'] = $list['Corporate_Id'];
			$user=new ScenicsSpotModel;
			$data=$user->SelectFiltrate($map);
			if($data){
				$info["data"]=$data;
				$info["msg"]="查询成功";
				$info["code"]=1;
				return json($info);
			}else{
				$info["msg"]="数据为空";
				$info["code"]=0;
				return json($info);
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
      }

      //查询单个景点信息  
      public function ScenicsSpotFind(){
		$path="Scenicspot/ScenicsSpotFind";
		if($this->GetAuth($path)){
			$request = Request::instance();
			$id=$request->post('id');
			$token=$request->post('token'); 
			$list=Db::table('yunque_userinfo')->where('UserToken',$token)->find(); 
			$Corporate_Id=$list['Corporate_Id'];
			$data=Db::table('yunque_scenic_spot')->where(['ScenicSpot_Id'=>$id,'Corporate_Id'=>$Corporate_Id])->find();
			$data= Db::table('yunque_city a,yunque_province b,yunque_country c , yunque_scenic_spot d')
			->where(['d.ScenicSpot_Id'=>$id,'d.Corporate_Id'=>$Corporate_Id])
			->where('a.City_Id', $data['City_Id'])
			->where('a.Province_Id=b.Province_Id and b.Country_Id=c.Country_Id')
			->field('a.City_Name,b.Province_Name,c.Country_Name,d.ScenicSpot_Name,d.ScenicSpot_Id,d.ScenicSpot_Introduction,d.ScenicSpot_Pictures,d.ScenicSpot_Type,d.Corporate_Id')->select();
			if($data){
			  $info['data']=$data;
			  $info['msg']="查询成功";
			  $info['code']="1";
			  return json($info);
			}else{
			  $info['msg']="数据为空";
			  $info['code']="0";
			  return json($info);
			  }
		   }else{
				$info["msg"] = "您没有此操作权限";
				$info['code']="0";
				return json($info);
		    }   
        }

      //修改景点信息
      public function  ScenicsSpotUpdate(){
		$path="Scenicspot/ScenicsSpotUpdate";
		if($this->GetAuth($path)){
			$request=Request::instance();
			$data['ScenicSpot_Id']=$request->post('editspot.ScenicSpot_Id');
			$data['ScenicSpot_Name']=$request->post('editspot.ScenicSpot_Name');
			$data['ScenicSpot_Introduction']=$request->post('editspot.ScenicSpot_Introduction');
			$data['ScenicSpot_Pictures']=$request->post('editspot.ScenicSpot_Pictures');
			$data['ScenicSpot_Type']=$request->post('editspot.ScenicSpot_Type');
			$City_Name=$request->post('editspot.City_Name');
			if($City_Name==""){
				$info['msg']="城市不能为空";
				$info['code']="0";
				return json($info);
			}else{
				$validate = new \app\index\validate\ScenicSpotValidate;   
				if (!$validate->scene('ScenicsSpotUpdate')->check($data)) {
					$info['msg']=$validate->getError();
					$info['code']=0;
					return json($info);
				}else{
					$rs=Db::table('yunque_city')->where('City_Name',$City_Name)->find();
					$data['City_Id']=$rs['City_Id'];
					$token=$request->post('token');   
					$list=Db::table('yunque_userinfo')->where('UserToken',$token)->find(); 
					$data['Corporate_Id']=$list['Corporate_Id'];
					$rs=Db::table('yunque_scenic_spot')->where(['ScenicSpot_Name'=>$data['ScenicSpot_Name'],'Corporate_Id'=> $data['Corporate_Id']])->find();
					if($rs){
						$info['msg']="景点名称已存在";
						$info['code']="0";
						return json($info);
					}else{
						$list=Db::table('yunque_scenic_spot')->where(['ScenicSpot_Id'=>$data['ScenicSpot_Id'],'Corporate_Id'=>$data['Corporate_Id']])->update($data);
						if($list){
							$info["msg"]="修改成功";
							$info["code"]=1;
							return  json($info);
						}else{
							$info["msg"]="修改失败";
							$info["code"]=0;
							return  json($info);
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
      


      //删除景点
      public function ScenicsSpotDelete(){
		$path="Scenicspot/ScenicsSpotDelete";
		if($this->GetAuth($path)){
			$request = Request:: instance();
			$token=$request->post('token');
			$id=$request->post('id');
			$data=Db::table('yunque_userinfo')->where('UserToken',$token)->find();
			$rs=Db::table('yunque_scenic_spot')->where(['ScenicSpot_Id'=>$id,'Corporate_Id'=>$data['Corporate_Id']])->delete();
			if($rs){
				$info["msg"]="删除成功";
				$info["code"]=1; 
				return  json($info);
			}else{
				$info["msg"]="删除失败";
				$info["code"]=0;
				return  json($info);
			}  
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }
 }
?>