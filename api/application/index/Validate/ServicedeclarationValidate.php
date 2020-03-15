<?php
namespace app\index\validate;

use think\Validate;

class ServicedeclarationValidate extends Validate
{
    protected $rule = [
        'id' => 'number|max:11',
        'Role_Name' => 'chsDash|max:100',
        'corporate' => 'require|number|max:11',
    ];
    protected $message = [
        'Service_ID.require' => '客服ID是必须的',
        'Service_ID.number' => '客服ID必须是数字',
        'Service_ID.max' => '客服ID不得超过11位',

        'ServiceDeclaration_Date.require' => '日期是必须的',
        'ServiceDeclaration_Date.alphaNum' => '日期格式错误',
        'ServiceDeclaration_Date.max' => '日期超出限制',

        'ServiceDeclaration_Name.require' => '姓名是必须的',
        'ServiceDeclaration_Name.chsAlpha' => '姓名格式错误',
        'ServiceDeclaration_Name.max' => '姓名不得超过20字符',

        'ServiceDeclaration_Tel.require' => '电话是必须的',
        'ServiceDeclaration_Tel.number' => '电话必须是数字',
        'ServiceDeclaration_Tel.max' => '电话不得超过11字符',

        'ServiceDeclaration_IDcard.require' => '身份证号码是必须的',
        'ServiceDeclaration_IDcard.alphaNum' => '身份证号码格式错误',
        'ServiceDeclaration_IDcard.max' => '身份证号码不得超过18字符',

        'ServiceDeclaration_PelopeNumber.require'   => '人数是必须的',
        'ServiceDeclaration_PelopeNumber.number'   => '人数必须是数字',
        'ServiceDeclaration_PelopeNumber.max'   => '人数超出限制',

        'Route_Id.require' => '旅游线路ID是必须的',
        'Route_Id.number' => '旅游线路ID必须是数字',
        'Route_Id.max' => '旅游线路ID不得超过11位',

        'ServiceDeclaration_Deposit.require' => '定金是必须的',
        'ServiceDeclaration_Deposit.number' => '定金必须是数字',
        'ServiceDeclaration_Deposit.max' => '定金超出限制',

        'ServiceDeclaration_Balance.require' => '余款是必须的',
        'ServiceDeclaration_Balance.number' => '余款必须是数字',
        'ServiceDeclaration_Balance.max' => '余款超出限制的',

        'ServiceDeclaration_Group.require'  => '总团款是必须的',
        'ServiceDeclaration_Group.number'  => '总团款必须是数字',
        'ServiceDeclaration_Group.max'  => '总团款超出限制',

        'ServiceDeclaration_Remarks.chsAlphaNum' => '备注只允许汉字、字母和数字',

        'token.require' =>  'token错误',
        'token.alphaNum' =>  'token错误',
        'token.max' =>  'token错误',
    ];
    protected $scene =[
        'Insert' => [
            'Service_ID' => 'require|number|max:11',
            'ServiceDeclaration_Date' => 'require|alphaNum|max:30',
            'ServiceDeclaration_Name' => 'require|chsAlpha|max:20',
            'ServiceDeclaration_Tel' => 'require|number|max:11',
            'ServiceDeclaration_IDcard' => 'require|alphaNum|max:18',
            'ServiceDeclaration_PelopeNumber' => 'require|number|max:3',
            'Route_Id'  => 'require|number|max:11',
            'ServiceDeclaration_Deposit' => 'require|number|max:15',
            'ServiceDeclaration_Balance' => 'require|number|max:15',
            'ServiceDeclaration_Group'  => 'require|number|max:15',
            'ServiceDeclaration_Remarks' => 'chsAlphaNum',
        ],
        'Token' =>[
            'token' => 'require|alphaNum|max:32',
        ],
    ];
}

?>