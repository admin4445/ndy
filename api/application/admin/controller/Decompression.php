<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\File;
class Decompression extends controller {

	//��ѹzip�ļ�
    public function index(){
    //��ѹ�ļ��������Ŀ¼
     $dir = "D:\jl_zip";

     if (file_exists($dir) == FALSE) {
            mkdir($dir);   //������ѹĿ¼
      }
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        Loader::import('PHPZIP', EXTEND_PATH);
        $archive   = new \PHPZIP();
        $file = $_FILES['file_name']['tmp_name']; //��Ҫѹ�����ļ�[��]·��
        $archive->unzip($file,$dir);
    }
}
?>