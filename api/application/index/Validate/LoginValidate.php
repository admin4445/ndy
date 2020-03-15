<?php
namespace app\index\validate;

use think\Validate;

class LoginValidate extends Validate
{
    protected $rule = [
        'username' => 'require|chsAlphaNum|max:20',
        'userpwd' => 'require|alphaDash',
    ];
    protected $message = [
        'username.require'=>'账号不得为空',
        'username.chsAlphaNum'=>'账号只允许汉字、字母和数字',
        'username.max'=>'账号最多不能超过20个字符',
        'userpwd.require'=>'密码不得为空',
        'userpwd.alphaDash'=>'密码只允许字母、数字和下划线 破折号',
    ];
}

?>