<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use app\index\model\CorporateModel;
use app\index\model\UserModel;
use think\File;
class User extends Auth {


     
    //分页显示用户数据/////////////////////////////////////////////////////////////////
    public function SelectUser(){
        $path="User/SelectUser";
        if($this->GetAuth($path)){
            $request = Request::instance();
            $token=$request->post('token');      
            // $page=$request->post('page');
            // $limit=$request->post('pagenum');
            // $count=Db::table('yunque_userinfo')->count();
            // $ss=$count/$limit;
            // is_int($ss) ? $countpage=$count/$limit : $countpage=intval($count/$limit)+1;
            $list=Db::table('yunque_userinfo')->where('UserToken', $token)->find(); 
            $data=Db::field('a.*,b.Role_Name')
            ->table('yunque_userinfo a,yunque_role b')
            ->where(['a.Corporate_Id'=> $list['Corporate_Id'],'a.Role_Id'=>['>',$list['Role_Id']]])
            ->where('a.Role_Id=b.Role_Id','a.Corporate_Id=b.Corporate_Id')->select();           
            if($data){
                $info["data"]=$data; 
                $info["msg"]="查询成功";
                // $info["pagebar"]=$count;
                // $info["pagecount"]=$countpage;
                $info["code"]="1";
                return json($info); 
            }else{
                $info["msg"]="数据为空";
                $info["code"]="0";
                return json($info);
            }
        }else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }

    //筛选查询//////////////////////////////////////////////////////////////////////
    public function FiltrateSelect(){
        $path="User/FiltrateSelect";
        if($this->GetAuth($path)){
            $request = Request:: instance();
            $list=$request->post();
            $map['Name'] = ['like', '%' . $list['Name'] . '%'];
            $list=Db::table('yunque_userinfo')->where('UserToken', $list['token'])->find();
            $map['Corporate_Id'] = $list['Corporate_Id'];   
            $data=db::table('yunque_userinfo a,yunque_role b')->where([' a.Name'=>$map['Name'],'a.Corporate_Id'=>$map['Corporate_Id'],'a.Role_Id'=>['>',$list['Role_Id']]])
            ->where('a.Role_Id=b.Role_Id','a.Corporate_Id=b.Corporate_Id')->select(); 
            if($data){
                $info["data"]=$data;
                $info["msg"]="查询成功";
                $info["code"]="1";
                return json($info);
            }else{
                $info["msg"]="数据为空";
                $info["code"]="0";
                return json($info);
            }
        }else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
       
    }

    //查询用户单个的数据//////////////////////////////////////////////////////////////////////
    public function FindUser(){
        $path="User/FindUser";
        if($this->GetAuth($path)){
            $request = Request:: instance();
            $list=$request->post();
            $res=Db::table('yunque_userinfo')->where('UserToken', $list['token'])->find(); 
            $Corporate_Id= $res['Corporate_Id']; 
            $a=Db::table('yunque_userinfo')->where(['User_Id'=>$list['id'],'Corporate_Id'=>$Corporate_Id])->find();
            $b=db::table('yunque_role')->where(['Role_Id'=>$a['Role_Id'],'Corporate_Id'=>$Corporate_Id])->find();
            $data=Db::table('yunque_userinfo a,yunque_role b')->where(['a.User_Id'=>$list['id'],'a.Corporate_Id'=>$Corporate_Id])
            ->where(['b.Role_Id'=>$b['Role_Id'],'b.Corporate_Id'=>$Corporate_Id])
            ->select();
            if($data){
                $info['data']=$data;
                $info["msg"]="查询成功";
                $info["code"]="1"; 
                return json($info);
            }else{
                $info["msg"]="数据为空";
                $info["code"]="0";
                return json($info);

            }
        }else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
       
       
    }


    




    //修改用户信息//////////////////////////////////////////////////////////////////////
    public function UpdateUser(){
        $path="User/UpdateUser";
        if($this->GetAuth($path)){
            $request = Request::instance();
            $token=$request->post('token');
            $data=db::table('yunque_userinfo')->where('UserToken',$token)->find();
            $list['Corporate_Id']=$data['Corporate_Id'];
            $list['User_Id']=$request->post('user.User_Id');
            $list['Name']=trim($request->post('user.Name'));
            $list['UserName']=trim($request->post('user.UserName'));
            $list['UserPwd']=md5($request->post('user.UserPwd'));
            $list['Email']=$request->post('user.Email');
            $list["User_Img"]=$request->post('user.User_Img');
            $list['Wechat']=$request->post('user.Wechat');
            $list['Role_Id']=$request->post('user.Role_Id');
            $list['Tel']=$request->post('user.Tel');
            $data['UserToken']=md5($list['UserName'].'abckkoovvxx');  
            $validate = new \app\index\validate\updeteValidate;   
            if (!$validate->scene('UpdateUser')->check($list)){
                $info['msg']=$validate->getError();
                $info['code']="0";
                return json($info);
            }else{
                   $rs=db::table('yunque_userinfo')->where(['User_Id'=>$list['User_Id'],'Corporate_Id'=>$list['Corporate_Id']])->update($list);
                    if($rs){
                        $info["msg"]="修改成功";
                        $info["code"]="1";
                        return json($info);
                    }else{
                        $info["msg"]="修改失败";
                        $info["code"]="0";
                        return json($info);
                    }   
            }
        }else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
       
       
    }

    //删除用户//////////////////////////////////////////////////////////////////////
    public function DeleteUser(){
        $path="User/DeleteUser";
        if($this->GetAuth($path)){
            $request = Request:: instance();
            $list=$request->post(); 
            $user=new UserModel;
            $rs=$user->Deleteuserinfo($list);
            if($rs=="1"){
                $info["msg"]="删除成功";
                $info["code"]="1";
                return  json($info);
            }else{
                $info["msg"]="删除失败";
                $info["code"]="0";
                return  json($info);
            } 
        }else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
       
      
    } 


    //添加用户//////////////////////////////////////////////////////////////////////
    public function AddUser(){
        $path="User/AddUser";
        if($this->GetAuth($path)){
            $validate = new \app\index\validate\updeteValidate;
            $request = Request:: instance();
            $token=$request->post('token');
            $data['UserName']=$request->post('user.UserName');
            $data['UserPwd']=md5($request->post('user.UserPwd'));
            $data['Name']=$request->post('user.Name');
            $data['User_Img']=$request->post('user.User_Img');
            $data['Email']=$request->post('user.Email');
            $data['Role_Id']=$request->post('user.Role_Id');
            $data['Tel']=$request->post('user.Tel');
            $data['Wechat']=$request->post('user.Wechat');
            $list=db::table('yunque_userinfo')->where('UserToken',$token)->find();
            $data['Corporate_Id']=$list['Corporate_Id'];
            $data['UserToken']=md5($data['UserName'].'abckkoovvxx'); 
            if (!$validate->scene('AddUser')->check($data)){
                $info['msg']=$validate->getError();
                $info['code']="0";
                return json($info); 
            }else{
                    $rs=db::table('yunque_userinfo')->where(['Corporate_Id'=>$data['Corporate_Id'],'UserName'=>$data['UserName']])->find();
                    if($rs){
                        $info["msg"]="用户名已存在";
                        $info["code"]="0";
                        return  json($info);
                    }else{
                        $rs=db::table('yunque_userinfo')->insert($data);
                        if($rs){
                            $info["msg"]="新增成功";
                            $info["code"]="1";
                            return  json($info);
                        }else{
                            $info["msg"]="新增失败";
                            $info["code"]="0";
                            return  json($info);
                        }   
                    }
                   
                }   
            }else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
           
    } 


    //修改用户状态
    public function Updatestatus(){
        $path="User/Updatestatus";
        if($this->GetAuth($path)){
			$request = Request:: instance();
			$token=$request->post('token');
			$id=$request->post('id');
			$data=db::table('yunque_userinfo')->where('User_Id',$id)->find();
			if(!$data){
				$info["msg"]="非法操作";
				$info["code"]="0";
				return  json($info);
			}else{
				$data['Status']=="1"?$data['Status']="0":$data['Status']="1";
				if($data['Record']==""){
					$a=array();
					array_push($a,date("Y-m-d h:i:sA"));
					$data['Record'] = $a;
				}else{
					$a = json_decode($data['Record'],true);
					array_push($a,date("Y-m-d h:i:sA"));
					$data['Record'] = $a;
				}
				$data['Record'] = json_encode($data['Record'],true);
				$rs=db::table('yunque_userinfo')->where('User_Id',$id)->update(['Status'=>$data['Status'],'Record'=>$data['Record']]);
				if($rs){
					$info["msg"]="操作成功";
					$info["code"]="1";
					return  json($info);
				}else{
					$info["msg"]="操作失败";
					$info["code"]="0";
					return  json($info);
				}

			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }


    //修改用户密码
    public function Updatepassword(){
		$path="User/Updatepassword";
        if($this->GetAuth($path)){
        header("Access-Control-Allow-Origin: *");
			$request = Request:: instance();
			$id=$request->post('Id');
			$token=$request->post('token');
			$newpassword=md5($request->post('UserPwd'));
			if(!(""==$id)){
				$rs=db::table('yunque_userinfo')->where('User_Id',$id)->update(['UserPwd'=>$newpassword]);
				if($rs){
					$info["msg"]="操作成功";
					$info["code"]="1";
					return  json($info);
				}else{
					$info["msg"]="操作失败";
					$info["code"]="0";
					return  json($info);
				}
			}else{
				$Oldpassword=md5($request->post('Oldpassword'));
				$newpassword=md5($request->post('Newpassword'));
				$data=db::table('yunque_userinfo')->where('UserToken',$token)->find();
				if(!$data['UserPwd']==$Oldpassword){
					$info["msg"]="输入的密码不对";
					$info["code"]="0";
					return  json($info);
				}else{
					$rs=db::table('yunque_userinfo')->where('User_Id',$data['User_Id'])->update(['UserPwd'=>$newpassword]);
					if($rs){
						$info["msg"]="操作成功";
						$info["code"]="1";
						return  json($info);
					}else{
						$info["msg"]="操作失败";
						$info["code"]="0";
						return  json($info);
					}
				}
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }

    //修改用户个人信息
    public function Updateuserinfo(){
		$path="User/Updateuserinfo";
        if($this->GetAuth($path)){
			header("Access-Control-Allow-Origin: *");
			$request = Request:: instance();
			$datasoure=$request->post();
			$data=$datasoure['data'];
			$list=db::table('yunque_userinfo')->where('UserToken',$datasoure['token'])->find();
			if(!$list){
				$info["msg"]="操作失败";
				$info["code"]="1";
				return  json($info);
			}else{
				$rs=db::table('yunque_userinfo')->where('User_Id',$list['User_Id'])->update([
					'User_Img'=>$data['User_Img'],
					'Tel'=>$data['Tel'],
					'Wechat'=>$data['Wechat'],
					'Qq'=>$data['Qq'],
					'Age'=>$data['Age'],
					'Sex'=>$data['Sex'],
					'Email'=>$data['Email']
					]);
				if($rs){
					$info["msg"]="操作成功";
					$info["code"]="1";
					return  json($info);
				}else{
					$info["msg"]="操作失败";
					$info["code"]="0";
					return  json($info);
				}
			}
		}else{
			$info["msg"] = "您没有此操作权限";
			$info['code']="0";
			return json($info);
		}   
    }

    //微信小程序批量查询数据//////////////////////////////////////////////////////////////////////
    public function Batchuser(){
		$path="User/Batchuser";
        if($this->GetAuth($path)){
			header("Access-Control-Allow-Origin: *");
			$request = Request:: instance();
			$list=$request->post();
			$res=Db::table('yunque_userinfo')->where('UserToken', $list['token'])->find(); 
			$Corporate_Id= $res['Corporate_Id']; 
			$data=Db::table('yunque_userinfo')->where(['User_Id'=>['in',$list['id']],'Corporate_Id'=>$Corporate_Id])->select();
			if($data){
				$info['data']=$data;
				$info["msg"]="查询成功";
				$info["code"]="1"; 
				return json($info);
			}else{
				$info["msg"]="数据为空";
				$info["code"]="0";
				return json($info);
	  
			  }
			}else{
				$info["msg"] = "您没有此操作权限";
				$info['code']="0";
				return json($info);
			}   
        }

        //修改登录帐号的信息

        public function Updatelogininfo(){
			$path="User/Batchuser";
			if($this->GetAuth($path)){
				header("Access-Control-Allow-Origin: *");
				$request = Request:: instance();
				$token=$request->post('token');
				$data['UserPwd']=$request->post('UserPwd');
				$data['Name']=$request->post('Name');
				$data['User_Img']=$request->post('User_Img');
				$rs=db::table('yunque_userinfo')->where('UserToken',$token)->update([
					'UserPwd'=>md5($data['UserPwd']),
					'Name'=>$data['Name'],
					'User_Img'=>$data['User_Img']
				]);
				if($rs){
					$info["msg"]="修改成功";
					$info["code"]="1"; 
					return json($info);
				}else{
					$info["msg"]="修改成功";
					$info["code"]="1"; 
					return json($info);
				}
			}else{
				$info["msg"] = "您没有此操作权限";
				$info['code']="0";
				return json($info);
			}   

		}
	}
?>