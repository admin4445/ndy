<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\File;
class Login extends controller {


    

    //添加用户//////////////////////////////////////////////////////////////////////
    public function Add(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $data['Account']=$request->post('Account');
        $data['Password']=md5($request->post('Password'));
        $rs=db::table('yunque_admin')->where('Account',$data['Account'])->find();
        if($rs){
            $info["msg"]="帐号已存在";
            $info["code"]="0";
            return  json($info);
        }else{
            $rs=db::table('yunque_admin')->insert($data);
            if($rs){
                $info["msg"]="添加成功";
                $info["code"]="1";
                return  json($info);
            }else{
                $info["msg"]="添加失败";
                $info["code"]="0";
                return  json($info);
                }
            }  
    } 

    //查询列表用户
    public  function Select(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $data=db::table('yunque_admin')->select();
        if($data){
            $info['msg']="查询成功";
            $info['code']="1";
            $info['data']=$data;
        }else{
            $info['msg']="数据为空";
            $info['code']="0";
            $info['data']=$data;
            }
        }

    //查询单个用户数据
    public function Find(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $id=$request->post('id');
        $rs=db::table('yunque_admin')->where('Id',$id)->find();
        if($rs){
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

    //修改密码
    public function Update(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $id=$request->post('id');
        $data['Password']=md5($request->post('Password'));
        $rs=db::table('yunque_admin')->where('Id',$id)->update(['Password'=>$data['Password']]);
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
 

    //删除帐号
    public function Delete(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $id=$request->post('id');
        $rs=db::table('yunque_admin')->where('Id',$id)->delete();
        if($rs){
            $info['msg']="删除成功";
            $info['code']="1";
            return json($info);
        }else{
            $info['msg']="删除失败";
            $info['code']="1";
            return json($info);
        }
    }

    //登录验证
    public function Login(){
        header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $data['Account']=$request->post('Account');
        $data['Password']=md5($request->post('Password'));
        $rs=db::table('yunque_admin')->where(['Account'=>$data['Account'],'Password'=>$data['Password']])->find();
        if($rs){
            $info['msg']="登录成功";
            $info['code']="1";
            return json($info);
        }else{
            $info['msg']="登录失败";
            $info['code']="1";
            return json($info);
        }
    }

	//
}
?>