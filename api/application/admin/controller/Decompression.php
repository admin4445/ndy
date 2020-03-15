<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\File;
class Decompression extends controller {

	//解压zip文件
    public function index(){
    //解压文件所保存的目录
     $dir = "D:\jl_zip";

     if (file_exists($dir) == FALSE) {
            mkdir($dir);   //创建解压目录
      }
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        Loader::import('PHPZIP', EXTEND_PATH);
        $archive   = new \PHPZIP();
        $file = $_FILES['file_name']['tmp_name']; //需要压缩的文件[夹]路径
        $archive->unzip($file,$dir);
    }
}
?>