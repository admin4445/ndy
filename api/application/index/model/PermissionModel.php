<?php
namespace app\index\model;

use think\Model;

class PermissionModel extends Model{

    protected $table = 'yunque_Permission';

    public function InsertPermission($data){
        $this->data(['Right_Name' => $data['name'],'Right_Path' => $data['path'],'Right_Type' => $data['type']]);
        $list = $this->save();
        return $list;
    }

    public function DeletePermission($data){
        $list = $this->where('Right_Id',$data['id'])->delete();
        return $list;
    }

    public function UpdataPermission($data){
        $list = $this->where('Right_Id',$data['id'])->update(['Right_Name' => $data['name'],'Right_Path' => $data['path'],'Right_Type' => $data['type']]);
        return $list;
    }

    public function SelectPermission($data){
        $list = $this->where('Right_Name','like','%'.$data['name'].'%')->select();
        return $list;
    }
}

?>