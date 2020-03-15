<?php
namespace app\index\controller;

use think\Controller;
use \think\Request;
use think\Db;
use app\index\model\TouristrouteModel;

//旅游线路控制器
class Touristroute extends Controller
{
    public function index(){
        return view();
    }

    public function infotr(){
        $request = Request::instance();
        $data = $request->post();   //全部数据
        $user = Db::table('yunque_userinfo')->where('UserToken',$data['token'])->find(); 
        if($user){
            $model = new TouristrouteModel;
            $code = $model->where('Corporate_Id'=>$user['Corporate_Id'])->select();
            if($code){
                $info['msg'] = "线路查询成功";
                $info['code'] = "1";
                $info['data'] = $code;
                return json($info);
            }else{
                $info['msg'] = "线路查询失败";
                $info['code'] = "0";
                return json($info);
            }
        }
    }

    public function Inserttr(){
        $request = Request::instance();
        $data = $request->post();   //全部数据
        $list = $data['ScenicsSpot'];
        // dump($data);
        // $list = "3571,3572";
        // 验证
        $user = Db::table('yunque_userinfo')->where('UserToken',$data['token'])->find(); 
        if($user['Corporate_Id']){
            //安排 和 报价 要 分别组合成 一个字符串
            $city = Db::table('yunque_City')->where(['Corporate_Id'=>$user['Corporate_Id'],'City_Id'=>$data['City_Id']])->find();
            if($city['City_Id']){

                //这里要看前端创传的数据，是字符串还是数组
                // 查下景点表是否存在 该 景点id
                $scenicspot = Db::table('yunque_scenic_spot')->where(['Corporate_Id'=>$user['Corporate_Id'],'ScenicSpot_Id'=>['in',$list]])->select();
                $array = explode(",",$list);
                // 判断数据数组长度是否一样，不一样则景点有误
                if(count($array) == count($scenicspot)){
                    $model = new TouristrouteModel;
                    $touristroute = ['Title'=>$data['Title'],'Play_Time'=>$data['Play_Time'],'ScenicsSpot'=>$data['ScenicsSpot'],'Arrangement'=>$data['Arrangement'],'Cost'=>$data['Cost'],'Cost_Type'=>$data['Cost_Type'],'Corporate_Id'=>$user['Corporate_Id'],'City_Id'=>$city['City_Id']];
                    $code = $model->insert($touristroute);
                    if($code){
                        $info['msg'] = "旅游路线添加成功";
                        $info['code'] = "1";
                        return json($info);
                    }else{
                        $info['msg'] = "旅游路线添加失败";
                        $info['code'] = "0";
                        return json($info);
                    }
                }else{
                    $info['msg'] = "景点有误，请重新添加";
                    $info['code'] = "0";
                    return json($info);
                }
            }else{
                $info['msg'] = '对不起城市错误';
                $info['code'] = "0";
                return json($info);
            }
        }else{
            $info['msg'] = '对不起您没有公司';
            $info['code'] = "0";
            return json($info);
        }
    }

    public function Deletetr(){
        $request = Request::instance();
        $data = $request->post();   //全部数据
        //验证
        $user = Db::table('yunque_userinfo')->where('UserToken',$list['token'])->find();
        if($user['Corporate_Id']){
            $model = new TouristrouteModel;
            $code = $model->where(['Route_Id'=>$data['Route_Id'],'Corporate_Id'=>$user['Corporate_Id']])->delete();
            if($code){
                $info['msg'] = "旅游路线删除成功";
                $info['code'] = "1";
                return json($info);
            }else{
                $info['msg'] = "旅游路线删除失败";
                $info['code'] = "0";
                return json($info);
            }
        }else{
            $info['msg'] = '对不起您没有公司';
            $info['code'] = "0";
            return json($info);
        }
    }

    public function Updatatr(){
        $request = Request::instance();
        $list = $request->post();
        //验证器
        $user = Db::table('yunque_userinfo')->where('UserToken',$list['token'])->find();
        if($user['Corporate_Id']){
            $city = Db::table('yunque_City')->where(['Corporate_Id'=>$user['Corporate_Id'],'City_Id'=>$data['City_Id']])->find();
            if($city['City_Id']){
                $data = ['Play_Time'=>$list['Play_Time'],'Route_Plan'=>$list['Route_Plan'],'Arrangement'=>$list['Arrangement'],'Cost'=>$list['Cost'],'Cost_Type'=>$list['Cost_Type'],'City_Id'=>$city['City_Id']];
                $model = new TouristrouteModel;
                $code = $model->where(['Route_Id'=>$data['Route_Id'],'Corporate_Id'=>$user['Corporate_Id']])->update($data);
                if($code){
                    $info['msg'] = "旅游路线修改成功";
                    $info['code'] = "1";
                    return json($info);
                }else{
                    $info['msg'] = "旅游路线修改失败";
                    $info['code'] = "0";
                    return json($info);
                }
            }else{
                $info['msg'] = '对不起城市错误';
                $info['code'] = "0";
                return json($info);
            }
        }
    }

    public function Selecttr(){
        $request = Request::instance();
        $data = $request->post(); //全部数据
        //验证器
        $user = Db::table('yunque_userinfo')->where('UserToken',$list['token'])->find();
        if($corporate){
            $model = new TouristrouteModel;
            $code = $model->where('Route_Id'=$data['Route_Id'])->find();
            if($code){
                $info['msg'] = "操作成功";
                $info['code'] = "1";
                $info['data'] = $code;
                return json($info);
            }else{
                $info['msg'] = "数据查询失败";
                $info['code'] = "0";
                return json($info);
            }
        }else{
            $info['msg'] = "对不起贵公司的id不存在";
            $info['code'] = "0";
            return json($info);
        }
    }

}

?>