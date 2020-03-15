<?php
namespace app\index\validate;

use think\Validate;

class orderValidate extends Validate
{
    
    //验证器
    protected  $rule = [
        'Contacts'=>'require',
        'Telephone'=>'require|max:11|number',
        'Number'=>'require|number',
        'Trip'=>'require',
        'TotalSum'=>'require|number',
        'Deposit'=>'require|number',
        'Date'=>'require',
        'Operator'=>'require',
        'Remarks'=>'require',
        'Status'=>'require',
       

    ];
    //验证不成功提示的错误信息
    protected   $message = [];

    //场景验证
    protected $scene = [
        'Addorder'  =>  ['Contacts','Telephone','Number','Trip','TotalSum','Deposit','Date','Operator','Remarks'],
        'Updateorder'  =>  ['Contacts','Telephone','Number','Trip','TotalSum','Deposit','Date','Operator','Remarks','Status'],
      
     ];
}
?>