<?php
namespace app\index\validate;

use think\Validate;

class CompanyValidate extends Validate
{
    

   

    protected  $rule = [
      
        'Corporate_Name'  => 'require|max:25',
        'Corporate_Tel' => 'require|max:11|number',
        'Corporate_Boss'  => 'require',
       
       
    ];
    
    protected   $message = [
       
      
        'Corporate_Name.require' => '名称必须',
        'Corporate_Address.require' => '地址不能为空',
        'Corporate_Name.max'     => '名称最多不能超过25个字符',
        'Corporate_Tel.require'   => '电话号码必填',
        'Corporate_Tel.number'   => '电话号码必须是数字',
        'Corporate_Tel.max'  => '手机号码不能超过11位',
        'Corporate_Boss.require'  => '负责人不能为空',
       

      ];
}
?>