<?php
      namespace app\index\model;
      use think\Model;
      use think\Db;
      use think\Validate;
      use think\model\Collection;
      use app\index\model\ValidateModel;
      use think\Request;
      class UserModel extends Model{
        //建立模型与表的对于关系
        protected $table = 'yunque_userinfo';
        //新增用户到数据库
      
        //查询用户数据
        public function Selectuserinfo(){
            $userinfo =new UserModel;    
            $list = UserModel::all();
            return $list;
           }

        //筛选查询数据
        public function SelectFiltrate($list){
            $list = UserModel::all($list);
            return $list;
        } 

        //删除用户
        public function Deleteuserinfo($list){
            $user =new  UserModel;
            $code=$this->where(['User_Id'=>$list['id']])->delete();
            return $code;
        }      
    }
    ?>