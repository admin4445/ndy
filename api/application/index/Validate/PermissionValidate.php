<?php
namespace app\index\validate;

use think\Validate;

class PermissionValidate extends Validate
{
    protected $rule = [
        'id'  => 'max:11',
        'name' => 'chsDash|max:90',
        'interface' => 'chsDash|max:90',
        'corporate' => 'require|number|max:11'
    ];
    protected $message = [
        'id.require' => '权限id不得为空',
        'id.number' => '权限id必须为数字',
        'id.max'  => '权限id不得超过11位',
        'name.require' => '权限名称不得为空',
        'name.chsAlpha' => '权限名称只允许汉字、字母',
        'name.max'  => '权限名称不得超过90字符',
        'path.require' => '权限路径不得为空',
        'path.chsAlpha' => '权限路径只允许汉字、字母',
        'path.max'  => '权限路径不得超过90字符',
        'type.require' => '权限类型不得为空',
        'type.chsAlpha' => '权限类型只允许汉字、字母',
        'type.max'  => '权限类型不得超过90字符',
    ];
    protected $scene =[
        'Insert' => [
            'name' => 'require|chsAlpha|max:90',
            'path' => 'require|chsAlpha|max:90',
            'type' => 'require|chsAlpha|max:90'
        ],
        'Delete' => [
            'id'  => 'require|number|max:11'
        ],
        'Updata' => [
            'id'  => 'require|number|max:11',
            'name' => 'require|chsAlpha|max:90',
            'path' => 'require|chsAlpha|max:90',
            'type' => 'require|chsAlpha|max:90'
        ],
        'Select' => [
            'id'  => 'number|max:11',
            'name' => 'chsAlpha|max:90',
            'path' => 'chsAlpha|max:90',
            'type' => 'chsAlpha|max:90'
        ],
    ];
}

?>