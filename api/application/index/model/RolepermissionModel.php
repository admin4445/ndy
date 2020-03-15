<?php
namespace app\index\model;

use think\Model;

class RolepermissionModel extends Model
{
    protected $table = 'yunque_rolepermission';

    public function InsertRolepermission($data){
        $this->data(['Role_Id' => $data['role'],'Right_Id' => $data['right'],'Corporate_Id' => $data['corporate']]);
        $list = $this->save();
        return $list;
    }

    public function DeleteRolepermission($data){
        $list = $this->where(['RoleRight_Id' => $data['id'],'Corporate_Id' => $data['corporate']])->delete();
        return $list;
    }

    public function UpdataRolepermission($data){
        $list = $this->get($data['id']);
        $list->Role_Id = $data['role'];
        $list->Right_Id  = $data['right'];
        $code = $list->save();
        return $code;
    }

    public function SelectRolepermission($data){
        $list = $this->where('Corporate_Id',$data['corporate'])->where('Role_Id','like','%'.$data['role'].'%')->select();
        return $list;
    }

    public function Role(){
        return $this->hasMany('RoleModel');
    }
}
?>