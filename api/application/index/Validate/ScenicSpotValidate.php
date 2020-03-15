<?php
namespace app\index\validate;

use think\Validate;

class ScenicSpotValidate extends Validate
{
    

    protected  $rule = [
        //景点的验证信息
        'ScenicSpot_Name'=>'require',
        'ScenicSpot_Introduction'=>'require',
        'ScenicSpot_Pictures'=>'require',
        'ScenicSpot_Type'=>'require',
    ];
    //验证不成功提示的错误信息
    protected   $message = [];

    //场景验证
    protected $scene = [
        //添加景点信息验证的数据
        'AddScenicSpot'=>['ScenicSpot_Name','ScenicSpot_Introduction','ScenicSpot_Type'],
        //修改景点信息验证的数据
        'ScenicsSpotUpdate'=>['ScenicSpot_Name','ScenicSpot_Introduction','ScenicSpot_Type'],
     ];
}
?>