<?php
namespace app\index\validate;

use think\Validate;

class updeteValidate extends Validate
{
    

    protected  $rule = [
        'UserName'=>'require|chsAlphaNum|max:20',
        'UserPwd'=>'require|alphaDash',
        'Name'=>'require|chsAlpha',
        'Email'=>'require|email',
        // 'Address'=>'require', 
        'Tel'=>'require|max:11|number',
        // 'Qq'=>'require|number',
        'Wechat'=>'require|alphaNum',
        // 'IDcard'=>'require|max:20|alphaNum',
        // 'profession'=>'require',
        // 'Sex'=>'require',
        // 'Age'=>'require|max:3',
        // 'Hobby'=>'require',
        // 'Corporate_Id'=>'number|require',
        'Role_Id'=>'number|require',
        'Provincial_Number'=>'alphaNum|require',
        'Province_Name'=>'chs|require',
        'Country_Number'=>'require|alphaNum',
        'Country_Name'=>'chs|require',
        'City_Number'=>'require|alphaNum',
        'City_Name'=>'chs|require',
        'Catalog_Name'=>'require',
        'Avatar'=>'require|url',
        'Name'=>'require',
        'Content'=>'require',
        'Grade'=>'require',
        'City'=>'require',
        'Integral'=>'require',
        'Label'=>'require',
        'Date'=>'require',
        'Title'=>'require',
		'Zan'=>'require',
		'Ding'=>'require',
		'Cai'=>'require',
        'ScenicSpot_Name'=>'require',
        'ScenicSpot_Introduction'=>'require',
        'ScenicSpot_Pictures'=>'require',
        'ScenicSpot_Type'=>'require',
        'City_Name'=>'require',
      
        


       
    ];
    
    protected   $message = [
       
        'UserName.require'=>'用户账号不能为空',
        'UserName.chsAlphaNum'=>'用户账号格式错误',
        'UserName.max'=>'账号长度不超20位',
        'UserPwd.require'=>'密码不能为空',
        'Name.require'=>'姓名不能为空',
        'Name.chsAlpha'=>'姓名只允许汉字和字母',
        'UserPwd.alphaDash'=>'密码有数字字母下划线组成',
        'Email.require'=>'不能为空',
        'Email.email'=>'邮箱格式错误',
        'Address.require'=>'地址不能为空',
        'Tel.require'=>'电话号码不能为空',
        'Tel.min'=>'号码不能超过11位',
        'Tel.number'=>'必须为数字',
        'Qq.require'=>'不能为空',
        'Qq.number'=>'必须为数字',
        'Wechat.require'=>'微信不能为空',
        'Wechat.alphaNum'=>'不合法微信格式',
        'Role_Id.require'=>'角色名不能为空  ',
        'Role_Id.number'=>'必须是数字',
        'IDcard.require'=>'不能为空',
        // 'IDcard.number'=>'身份证号不超20位',
        'IDcard.alphaNum'=>'只允许字母和数字',
        'profession.require'=>'不能为空',
        'Sex.require'=>'性别必填',
        'Age.require'=>'年龄必填',
        'Age.number'=>'阿拉伯数字',
        'Hobby.require'=>'爱好必填',
        'Corporate_Id.number'=>'必须为数字',
        'Corporate_Id.require'=>'不能为空',
        'Provincial_Number.require'=>'不能为空',
        'Provincial_Number.alphaNum'=>'只能为数字字母',
        'Province_Name.chs'=>'只能为汉字',
        'Province_Name.require'=>'不能为空',
        'Country_Number.require'=>'不能为空',
        'Country_Number.alphaNum'=>'只能为数字字母',
        'Country_Name.chs'=>'只能为汉字',
        'Country_Name.require'=>'不能为空',
        'City_Number.require'=>'不能为空',
        'City_Number.alphaNum'=>'只能为数字字母',
        'City_Name.chs'=>'只能为汉字',
        'City_Name.require'=>'不能为空',
        'Catalog_Name.require'=>'目录名不能为空',




      ];

    protected $scene = [

        'UpdateUser'  =>  ['UserName','UserPwd','Name','Email','Tel','Wechat','Role_Id'],
        'AddUser'  =>  ['UserName','UserPwd','Name','Email','Tel','Wechat','Role_Id'],
        'AddProvince'=>['Provincial_Number','Province_Name'],
        'AddCountry'=>['Country_Number','Country_Name'],
        'AddCity'=>['City_Number','City_Name'],
        'insert'=>['Avatar','Name','Grade','City','Integral','Date','Label','Content','Zan','Ding','Cai'],
        'Update'=>['Avatar','Name','Grade','City','Integral','Date','Label','Content','Zan','Ding','Cai'],
        
     ];
}
?>