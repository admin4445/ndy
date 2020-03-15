<?php
namespace app\index\validate;

use think\Validate;

class RolepermissionValidate extends Validate
{
    protected $rule = [
        'id' => 'number|max:11',
        'role' => 'number|max:11',
        'right' => 'number|max:11',
        'corporate' => 'number|max:11',
        'Role_Name' => 'chsDash|max:100',
        'Description' => 'chsAlphaNum|max:100',
        'token' => 'alphaNum|max:32',
    ];
    protected $message = [
        'id.require' => 'id是必须的',
        'id.number' => 'id必须是数字',
        'id.max' => 'id不得超过11位',
        'role.require' => '角色ID是必须的',
        'role.number' => '角色ID必须是数字',
        'role.max' => '角色ID不得超过11位',
        'right.require' => '权限ID是必须的',
        'right.number' => '权限ID必须是数字',
        'right.max' => '权限ID不得超过11位',
        'corporate.require' => '公司ID是必须的',
        'corporate.number' => '公司ID必须是数字',
        'corporate.max' => '公司ID不得超过11位',
        'Token.require' => 'Token错误',
        'Token.number' => 'Token错误',
        'Token.max' => 'Token错误',
        'Role_Name.require' => '角色名字不得为空',
        'Role_Name.chsDash' => '角色名称存在非法字符',
        'Role_Name.max' => '角色名称不得超过100字符',
        'Status.require' => '状态不得为空',
        'Status.number' => '状态错误',
        'Status.max' => '状态错误',
    ];
    protected $scene =[
        'Insert' => [
            'Role_Name' => 'require|chsDash|max:100',
            'Description' => 'chsAlphaNum|max:100',
        ],
        'Delete' => [
            'token' => 'require|alphaNum|max:32',
        ],
        'Updata' => [
            'Role_Id'  => 'require|number|max:11',
            'Role_Name' => 'require|chsDash|max:100',
            'Status' => 'require|number|max:1',
            'Description' => 'chsAlphaNum|max:100',
            'token' => 'require|alphaNum|max:32',
        ],
        'Select' => [
            'id'  => 'require|number|max:11',
            'token' => 'require|alphaNum|max:32',
        ],
        'Token' => [
            'token' => 'require|alphaNum|max:32',
        ],
    ];
}

?>