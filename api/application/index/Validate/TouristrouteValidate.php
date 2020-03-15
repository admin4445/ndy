<?php
namespace app\index\validate;

use think\Validate;

class RoleValidate extends Validate
{
    protected $rule = [
        'Route_Id' => 'number|max:11',
        'Play_Time' => 'number|max:2',
        'Route_Plan' => 'require|number|max:11',
    ];
    protected $message = [
        'Route_Id.require' => '旅游路线ID不得为空',
        'Route_Id.number' => '旅游路线ID只能为数字',
        'Route_Id.max' => '旅游路线ID不得超过11个字符',

        'Title.require' => '标题不得为空',
        'Title.chsDash' => '标题只允许汉字、字母、数字和下划线_及破折号',

        'Play_Time.require' => '游玩时间不得为空',
        'Play_Time.number' => '游玩时间只能为数字',
        'Play_Time.max' => '游玩时间不得超过2个字符',

        'ScenicsSpot.require' => '景点不得为空',
        'ScenicsSpot.chsAlphaNum' => '景点存在非法字符',

        'Arrangement.require' => '安排不得为空',
        'Arrangement.chsAlphaNum' => '安排只允许汉字、字母和数字',

        'Cost.require' => '报价不得为空',
        'Cost.chsAlphaNum' => '报价存在非法字符',

        'Cost_Type.require' => '报价类型不得为空',
        'Cost_Type.number' => '报价类型只能为数字',
        'Cost_Type.max' => '报价类型不得超过1个字符',

        'City_Id.require' => '城市ID不得为空',
        'City_Id.number' => '城市ID只能为数字',
        'City_Id.max' => '城市ID不得超过11个字符',

        'token.require' => 'token错误',
        'token.alphaNum' => 'token错误',
        'token.max' => 'token错误',
    ];
    protected $scene =[
        'Insert' => [
            'Title' => 'require|chsDash',
            'Play_Time' => 'require|number|max:2',
            'ScenicsSpot' => 'require|chsAlphaNum',
            'Arrangement' => 'require|chsAlphaNum',
            'Cost' => 'require|chaAlphaNum',
            'Cost_Type' => 'require|number|max:1',
            'City_Id' = > 'require|number|max:11',
            'token' => 'require|alphaNum|max:32',
        ],
        'Delete' => [
            'Route_Id'  => 'require|number|max:11',
            'token' => 'require|alphaNum|max:32',
        ],
        'Updata' => [
            'Route_Id'  => 'require|number|max:11',
            'Title' => 'require|chsDash',
            'Play_Time' => 'require|number|max:2',
            'ScenicsSpot' => 'require|chsAlphaNum',
            'Arrangement' => 'require|chsAlphaNum',
            'Cost' => 'require|chaAlphaNum',
            'Cost_Type' => 'require|number|max:1',
            'City_Id' = > 'require|number|max:11',
            'token' => 'require|alphaNum|max:32',
        ],
        'Select' => [
            'Route_Id'  => 'number|max:11',
            'Play_Time' => 'number|max:2',
            'Cost_Type' => 'number|max:1',
            'City_Id' = > 'number|max:11',
            'token' => 'alphaNum|max:32',
        ],
        'Token' =>[
            'token' => 'require|alphaNum|max:32',
        ],
    ];
}

?>