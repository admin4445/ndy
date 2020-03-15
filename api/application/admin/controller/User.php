<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\File;
class User extends controller {
    //用户管理列表/////////////////////////////////////////////////////////////////
    public function SelectUser(){
        header("Access-Control-Allow-Origin: *");
        $data=db::table('yunque_userinfo')->where('Lable',1)->select();
        if($data){
            foreach($data as $key=>$value){
                $list[$key]=db::table('yunque_corporatename')->where('Corporate_Id',$value['Corporate_Id'])->find();
                $value['Corporate_Name']=$list[$key]['Corporate_Name'];
                $value['Corporate_Boss']=$list[$key]['Corporate_Boss'];
                $value['Corporate_Tel']=$list[$key]['Corporate_Tel'];
                $data[$key]=$value; 
            }
            $info['msg']="查询成功";
            $info['code']="1";
            $info['data']=$data;
            return json($info);
        }else{ 
            $info['msg']="数据为空";
            $info['code']="0";
            return json($info);
        }
    }

	//查询单个用户数据
    public function Find(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $id=$request->post('id');
        $code=db::table('yunque_userinfo a,yunque_corporatename b')->where(['a.User_Id'=>$id])
		->where('a.Corporate_Id = b.Corporate_Id')->field('User_Img,Corporate_Boss,Corporate_Tel,Wechat,Email,UserName,UserPwd,User_Id,a.Corporate_Id')->find();
        if($code){
            $info['msg']="查询成功";
            $info['code']="1";
            $info['data']=$code;
            return json($info);
        }else{
            $info['msg']="数据为空";
            $info['code']="0";
            return json($info);
        }
    }

    //审核接口
    public function Auditing(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        //$id=$request->post('id');
        $id="295";
        $data=DB::table('yunque_userinfo')->where('User_Id',$id)->find();
        $data['Auditing']==0?$data['Auditing']=1:$data['Auditing']=0;
        $rs=db::table('yunque_userinfo')->where('User_Id',$id)->update(['Auditing'=>$data['Auditing']]);
        if($rs){
			$roleinfo=db::table('yunque_role')->where('Corporate_Id',$data['Corporate_Id'])->find();
			$rs=db::table('yunque_userinfo')->where('User_Id',$id)->update(['Role_Id'=>$roleinfo['Role_Id']]);
			if($rs){
				$info['msg']="审核通过";
				$info['code']="1";
				return json($info);
			}else{
				$info['msg']="操作失败";
				$info['code']="0";
				return json($info);
			}
					
		}else{
			$info['msg']="修改失败";
			$info['code']="0";
			return json($info);
		}
    }

    //修改用户信息
	public function UpdateUserinfo(){
		header("Access-Control-Allow-Origin: *");
		$request = Request:: instance();
		$data = $request->post();
		$code=db::table('yunque_userinfo')->where('User_Id',$data['User_Id'])
		->update([
			'User_Img' => $data['User_Img'],
			'Email' => $data['Email'],
			'Wechat' => $data['Wechat'],
			'UserName' => $data['UserName'],
			'UserPwd' => $data['UserPwd']
		]);
		$list=db::table('yunque_corporatename')->where('Corporate_Id',$data['Corporate_Id'])
		->update([
			'Corporate_Boss' => $data['Corporate_Boss'],
			'Corporate_Tel' => $data['Corporate_Tel']
		]);
		if($code || $list){
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
?>