<?php
namespace app\index\controller;

use think\Controller;
use \think\Request;
use think\Db;
use app\index\model\ServicedeclarationModel;
use app\index\validate\ServicedeclarationValidate;

class Servicedeclaration extends Controller
{
    public function index(){
        echo '小威是最帅的！';
    }
    //***************boos 查询 消息接口******************* */
    public function BoosSelectMessageInfo(){
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        //只需要一个 token 就可查询
        $data = $request->post();
        if(array_key_exists("token",$data)){
            $validate = new ServicedeclarationValidate;
            if(!$validate->scene('Token')->check($data)){
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            }else{
                $user = Db::table('yunque_userinfo')->where('UserToken',$data['token'])->find();
                if($user){
                    $mdoel = new ServicedeclarationModel;
                    $code = $mdoel->where('Corporate_Id',$user['Corporate_Id'])->select();
                    if($code){
                        $info['msg'] = "查询成功";
                        $info['code'] = "1";
                        $info['data'] = $code;
                        return json($info);
                    }else{
                        $info['msg'] = "查询失败";
                        $info['code'] = "0";
                        return json($info);
                    }
                }else{
                    $info['msg'] = "请勿非法操作";
                    $info['code'] = "0";
                    return json($info);
                }
            }
        }else{
            $info['msg'] = "请勿非法操作";
            $info['code'] = "0";
            return json($info);
        }
    }

    //**************客服 查询 消息接口********************************** */
    public function ServiceSelectMessageInfo(){
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        //只需要一个 token 就可查询
        $data = $request->post();
        if(array_key_exists("token",$data)){
            $validate = new ServicedeclarationValidate;
            if(!$validate->scene('Token')->check($data)){
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            }else{
                $user = Db::table('yunque_customerinformation')->where('ServiceToken',$data['token'])->find();
                if($user){
                    $mdoel = new ServicedeclarationModel;
                    $code = $mdoel->where('Corporate_Id',$user['Corporate_Id'])->select();
                    if($code){
                        $info['msg'] = "查询成功";
                        $info['code'] = "1";
                        $info['data'] = $code;
                        return json($info);
                    }else{
                        $info['msg'] = "查询失败";
                        $info['code'] = "0";
                        return json($info);
                    }
                }else{
                    $info['msg'] = "请勿非法操作";
                    $info['code'] = "0";
                    return json($info);
                }
            }
        }else{
            $info['msg'] = "请勿非法操作";
            $info['code'] = "0";
            return json($info);
        }
    }
    //**************客服 提交报单 接口******************************************* */
    public function ServiceInsertMessage(){
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        /*Service_ID (客服id)   ServiceDeclaration_Date (日期)  ServiceDeclaration_Name (姓名)
		ServiceDeclaration_Tel  （电话） ServiceDeclaration_IDcard (身份证) 
		ServiceDeclaration_PelopeNumber （人数） Route_Id （旅游线路id） ServiceDeclaration_Deposit （定金）
        ServiceDeclaration_Balance （余款） ServiceDeclaration_Group （总团款）
        ServiceDeclaration_Remarks （备注） token*/
        $data = $request->post();
        if(isset($data['Service_ID','ServiceDeclaration_Date','ServiceDeclaration_Name','ServiceDeclaration_Tel','ServiceDeclaration_IDcard','ServiceDeclaration_PelopeNumber','Route_Id','ServiceDeclaration_Deposit','ServiceDeclaration_Balance','ServiceDeclaration_Group'])){
            $validate = new ServicedeclarationValidate;
            if(!$validate->scene('Token')->check($data)){
                $info['msg'] = $validate->getError();
                $info['code'] = "0";
                return json($info);
            }else{
                $user = Db::table('yunque_customerinformation')->where('ServiceToken',$data['token'])->find();
                if($user){
                    $data['Service_ID'] = $user['CustomerService_Id']
                    if(!$validate->scene('Insert')->check($data)){
                        $info['msg'] = $validate->getError();
                        $info['code'] = "0";
                        return json($info);
                    }else{
                        $mdoel = new ServicedeclarationModel;
                        $mdoel->data([
                            'Service_ID'  => $data['Service_ID'],
                            'ServiceDeclaration_Date' => $data['ServiceDeclaration_Date'],
                            'ServiceDeclaration_Name' => $data['ServiceDeclaration_Name'],
                            'ServiceDeclaration_Tel' =>  $data['ServiceDeclaration_Tel'],
                            'ServiceDeclaration_IDcard' => $data['ServiceDeclaration_IDcard'],
                            'ServiceDeclaration_PelopeNumber' => $data['ServiceDeclaration_PelopeNumber'],
                            'Route_Id' => $data['Route_Id'],
                            'ServiceDeclaration_Deposit' => $data['ServiceDeclaration_Deposit'],
                            'ServiceDeclaration_Balance' => $data['ServiceDeclaration_Balance'],
                            'ServiceDeclaration_Group' => $data['ServiceDeclaration_Group'],
                            'ServiceDeclaration_Remarks' => $data['ServiceDeclaration_Remarks'],
                            'Corporate_Id' => $user['Corporate_Id'];
                        ]);
                        $user->allowField(true)->save();
                        if($code){
                            $info['msg'] = "操作成功";
                            $info['code'] = "1";
                            return json($info);
                        }else{
                            $info['msg'] = "操作失败";
                            $info['code'] = "0";
                            return json($info);
                        }
                    }
                }else{
                    $info['msg'] = "请勿非法操作";
                    $info['code'] = "0";
                    return json($info);
                }
            }
        }else{
            $info['msg'] = "请勿非法操作";
            $info['code'] = "0";
            return json($info);
        }
    }

}
?>