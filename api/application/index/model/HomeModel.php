<?php
    namespace app\index\model;
    use think\Model;
    use think\Db;
    use think\Validate;
    use think\model\Collection;
    use app\index\model\ValidateModel;
    use think\Request;
    class HomeModel extends Model{
        protected $table = 'yunque_landing_page';
        //      //添加
        //      public function add_public($data){

        //         $user=new HomeModel;
        //         return $list=$user->save($data);
                

        //      }

        //       //修改
        //    public function Update_public($list){
        //     $user = new HomeModel;
        //     $rs=$user->save($list,['User_Id' => $list['User_Id']]);
        //     return $rs;
        // }

        


    }