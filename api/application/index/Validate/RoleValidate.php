<?php
namespace app\index\validate;

use think\Validate;

class RoleValidate extends Validate
{
    protected $rule = [
        'id' => 'number|max:11',
        'Role_Name' => 'chsDash|max:100',
        'corporate' => 'require|number|max:11',
        'token' =>  'max:32',
    ];
    protected $message = [
        'token.require' => 'token错误',
        'token.alphaNum' => 'token错误',
        'token.max' => 'token错误',
    ];
    protected $scene =[
        'Token' =>[
            'token' => 'require|alphaNum|max:32',
        ],
    ];
}

?>