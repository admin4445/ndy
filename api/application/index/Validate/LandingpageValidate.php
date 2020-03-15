<?php
namespace app\index\validate;

use think\Validate;

class LandingpageValidate extends Validate
{
    
    //验证器
    protected  $rule = [
        //客服的验证信息
        'CustomerService_Name'=>'require',
        'CustomerService_Sex'=>'require',
        'Photo'=>'require|url',
        'CustomerService_Tel'=>'require',
        'CustomerService_Wechat'=>'require|alphaNum',
        'QrCode'=>'require|url',
        'Status'=>'require',
        //落地页的验证信息
        'Avatar'=>'require|url|activeUrl',
        'Title'=>'require',
        'Content'=>'require',
        'Nickname'=>'require',

    ];
    //验证不成功提示的错误信息
    protected   $message = [
        'token.require' => '公司错误',
        'token.number' => '公司错误',
        'token.max'  => '公司错误',

        'id.require' => '落地页id错误',
        'id.number' => '落地页id错误',
        'id.max'  => '落地页id错误',

        'CustomerService_Name.require' => '客服名字不得为空',
        'CustomerService_Name.chsDash' => '客服名字只允许汉字、字母、数字和下划线_及破折号',
        'CustomerService_Name.max'  => '客服名字不得超过20字符',

        'CustomerService_Sex.require' => '性别不得为空',
        'CustomerService_Sex.number' => '性别错误',
        'CustomerService_Sex.max'  => '性别不得超过1位',

        'CustomerService_Tel.require' => '手机号码不得为空',
        'CustomerService_Tel.number' => '手机号码必须为数字',
        'CustomerService_Tel.max'  => '手机号码不得超过11位',

        'CustomerService_Wechat.require' => '微信不得为空',
        'CustomerService_Wechat.number' => '微信必须为数字',
        'CustomerService_Wechat.max'  => '微信不得超过50位',

        'Status.require' => '状态不得为空',
        'Status.number' => '状态错误',
        'Status.max'  => '状态不得超过1位',

        'Photo.require' => '头像不得为空',
        'Photo.url' => '头像地址错误',
        'QrCode.url' => '二维码地址错误',
    ];

    //场景验证
    protected $scene = [
        //添加客服信息的验证数据
        'AddFindPageCustomerService'=>['CustomerService_Name','CustomerService_Sex','Photo','CustomerService_Tel','CustomerService_Wechat','QrCode','Status'],
        'UpdateCustomerService'=>['CustomerService_Name','CustomerService_Sex','Photo','CustomerService_Tel','CustomerService_Wechat','QrCode','Status'],
        'AddLandingpage'=>['path','Title','content','name'],
        'UpdateLandingpage'=>['path','Title','content','name'],
        'Updateservice' => [
            'token' => 'require|alphaNum|max:32',
            'id'    => 'require|number|max:11',
        ],
        'Updateserviceinfo' => [
            'CustomerService_Name' => 'require|chsDash|max:20',
            'CustomerService_Sex' => 'require|number|max:1',
            'Photo' => 'require|url',
            'CustomerService_Tel' => 'number|max:11',
            'CustomerService_Wechat'  => 'alphaNum|max:11',
            'QrCode' => 'require|url',
            'Status' => 'require|number|max:1',

        ],
     ];
}
?>