<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\File;
use app\index\model\ScenicsSpotModel;
class Adminupload extends controller{
 
	//上传BASE64图片
	public function uploadBasePhoto(){
		
		header("Access-Control-Allow-Origin: *");
		$request = Request::instance();
		$baseimg = $request->post("data");
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/',$baseimg,$result)){
			$type = $result[2];
			$name =uniqid().'.'.$type;
			$path = ROOT_PATH.'upload/photo/'.$name;
			$img=base64_decode(str_replace($result[1],'',$baseimg));
			$img_len=strlen($img);
			$img_size=$img_len-($img_len/8)*2;
			$size=round($img_size/1024);
			if(500<=$size){
				$info['msg']='文件大小超过限制';
				$info['code']='0';
				return json($info);
			}
			else{
				$rs=file_put_contents($path,$img);
				$webURL="http://upload.cnsdvip.com/upload/photo/".$name;
				$info['msg']='上传成功';
				$info['code']='1';
				$info['data']=$webURL; 
				return json($info);
			} 
		}
	}
}
?>