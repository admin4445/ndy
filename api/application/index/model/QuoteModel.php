<?php
namespace app\index\model;
use think\Model;
class QuoteModel extends Model{
    // protected $name = 'users';      $name    表的名字 前缀不用管
    // protected $table= 'users';      $table   表的名字 前缀必须管
    // protected $pk = 'uid';          数据库的主键 $pk 默认自动识别主键
    protected $table = 'yunque_quote';
}