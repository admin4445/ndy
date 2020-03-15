<?php
      namespace app\index\model;
      use think\Model;
      use think\Db;
      use think\Validate;
      use app\index\model\ValidateModel;
      use think\Request;
      class CorporateModel extends Model{
        //建立模型与表的对于关系
        protected $table = 'yunque_corporatename';
        //添加注册用户到数据库
        public function addUser(){

          //实例化模型
          $Corporate =new CorporateModel;
          $request = Request::instance();

          //保存公司信息
          $Corporate->Corporate_Name= $request->post('Corporate_Name');
          $Corporate->Corporate_Address = $request->post('Corporate_Address');
          $Corporate->Corporate_Tel= $request->post('Corporate_Tel');
          $Corporate->Corporate_Boss= $request->post('Corporate_Boss');        
          if($Corporate->save()){
              //注册用户信息
              $data1['UserName']=trim($request->post('UserName'));
              $data1['UserPwd']=md5($request->post('UserPwd'));
              $data1['UserToken']=md5($data1['UserName'].'abckkoovvxx');
              $data1['Corporate_Id']= $Corporate->Corporate_Id;
              $rs=Db::table('yunque_userinfo')->where('UserName', $data1['UserName'])->select();           
              if($rs){
                  return 0;  
              }
              else{
                  Db::table('yunque_userinfo')->insert($data1);
                  return 1;                 
              }

          }else{
            return 0;              
          }

        
         
        }
        
        
        
            

                  

            
    

            
           

           
          
                  

         
             
              
              
             
            
               

              
        }


      