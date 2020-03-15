<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Request;
class ScenicsSpotModel extends Model{
      protected $table = 'yunque_scenic_spot';
    public function Sightspot($data,$id){
        $user = new ScenicsSpotModel;
        // save方法第二个参数为更新条件
        $rs=$user->save($data,['ScenicsSpot_Id' => $id]);
        return $rs;
            
    }
    //景点信息的添加
    public function AddScenicspot($data){
      $user = new ScenicsSpotModel;
      return $user->save($data);

    }
    //景点名称筛选查询
    public function SelectFiltrate($list){
      $list = ScenicsSpotModel::all($list);
      return $list;
    }
   


         




   
   
   
   
   
    }
        