<?php
namespace app\index\model;

use think\Model;

class TouristrouteModel extends Model
{
    protected $table = 'yunque_tourist_route';

    // public function Insert($data){
    //     $this->data(['Play_Time'=>$data['id'],'Route_Plan'=>$data['playtime'],'Route_Plan'=>$data['routeplan'],
    //     'Arrangement'=>$data['arrangement'],'Hotel_Id'=>$data['hotel'],'Eat'=>$data['eat'],'Vehicle'=>$data['vehicle'],
    //     'Insurance_Id'=>$data['insurance'],'Corporate_Id'=>$data['corporate'],'City_Id'=>$data['city'],'Province_Id'=>$data['province']]);
    //     $list = $this->save();
    //     return $list;
    // }

    // public function Delete1($data){
    //     $list = $this->where(['Route_Id'=>$data['id'],'Corporate_Id'=>$data['corporate']])->delete();
    //     return $list;
    // }

    // public function Select($data){
    //     $list = $this->where('Corporate_Id',$data['corporate'])->where('Route_Id',$data['id'])
    //     ->whereOr('Play_Time',$data['playtime'])
    //     ->whereOr(['Hotel_Id'=>$data['hotel'],'Eat'=>$data['eat'],'Vehicle'=>$data['vehicle'],'Insurance_Id'=>$data['insurance'],'City_Id'=>$data['city'],'Province_Id'=>$data['province']])
    //     ->where(['Route_Plan'=>['like','%'.$data['routeplan'].'%'],'Arrangement'=>['like','%'.$data['arrangement'].'%']])
    //     ->select();
    //     return $list;
    // }
}


?>