<?php
namespace app\index\controller;
use think\Controller;
use thin\kRequest;
use think\Db;
class Pub extends controller {
    //渲染页面
    public function xx() {
        return $this->fetch('index');
    }
    //添加费用说明
    public function Addcostincorporate() {
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        // $token=$request->post('token');
        $token = "a80053dd2daeb3a9c77a3e3b6e21414e";
        $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
        $data['Cost_title'] = $request->post('Cost_title');
        $soure['Cost_Description'] = $request->post('Cost_Description');
        $data['Corporate_Id'] = $userinfo['Corporate_Id'];
        $list = db::table('yunque_publiccost')->where(['Corporate_Id' => $data['Corporate_Id'], 'Cost_title' => $data['Cost_title']])->find();
        if ($list) {
            $list['Cost_Description'] = json_decode($list['Cost_Description'], true);
            array_push($list['Cost_Description'], $soure);
            $list['Cost_Description'] = json_encode($list['Cost_Description']);
            $rs = db::table('yunque_publiccost')->where(['Corporate_Id' => $data['Corporate_Id'], 'Cost_title' => $data['Cost_title']])->update(['Cost_Description' => $list['Cost_Description']]);
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
            $a = array();
            $data['Cost_Description'] = $a;
            array_push($data['Cost_Description'], $soure);
            $data['Cost_Description'] = json_encode($data['Cost_Description']);
            $rs = DB::table('yunque_publiccost')->insert($data);
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
    //查询费用说明
    public function selectcostincorporate() {
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        // $token=$request->post('token');
        $token = "a80053dd2daeb3a9c77a3e3b6e21414e";
        $userinfo = db::table('yunque_userinfo')->where('UserToken', $token)->find();
        $data = db::table('yunque_publiccost')->where('Corporate_Id', $userinfo['Corporate_Id'])->select();
        for ($i = 0;$i < count($data);$i++) {
            $data[$i]['Cost_Description'] = json_decode($data[$i]['Cost_Description'], true);
        }
        $this->assign('data', $data);
        return $this->fetch('home');
        // if($data){
        //     $info['msg']="查询成功";
        //     $info['code']="1";
        //     $info['data']=$data;
        //     return json($info);
        // }else{
        //     $info['msg']="数据为空";
        //     $info['code']="0";
        //     return json($info);
        // }
        
    }
}
?>