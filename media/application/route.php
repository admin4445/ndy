<?php
use think\Route;

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::rule([
         
    'news'  =>  'index/Home/selectfind',
    'new'=>'index/Home/index',
    'new1'=>'index/Home/selsect',
    'new2'=>'index/Home/Manyselect',
    'aa'=>'index/Home/aa',
    'ss'=>'index/Home/ss',
    'gg'=>'index/Home/gg',
    'bb'=>'index/Home/bb',
    'jj'=>'index/Home/jj',

]);
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    // '[hello]'     => [
    //     ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
    //     ':name' => ['index/hello', ['method' => 'post']],
    // ],
  
];






