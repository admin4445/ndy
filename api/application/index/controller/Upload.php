<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\File;
class Upload extends Auth{
 
		//上传BASE64图片
		public function uploadBasePhoto(){
			$path = "Upload/uploadBasePhoto";
			if($this->GetAuth($path)){
				
				$request = Request::instance();
				$baseimg = $request->post("data");
				if (preg_match('/^(data:\s*image\/(\w+);base64,)/',$baseimg,$result)){
					$type = $result[2];
					$name =uniqid().'.'.$type;
					$path = ROOT_PATH.'static/upload/photo/'.$name;
					echo $path;
					exit;
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
						$webURL="http://www.api.com/static/upload/photo/".$name;
						$info['msg']='上传成功';
						$info['code']='1';
						$info['data']=$webURL; 
						return json($info);
					} 
				}
			}
	   }

	   //上传图片
	   public function uploadFilePhoto(){
			//$path = "Upload/uploadFilePhoto";
			//if($this->GetAuth($path)){
				header("Access-Control-Allow-Origin: *");
				$request = Request::instance();
				$file = request()->file('file');
				if($file){
					$code = $file->rule('uniqid')->move(ROOT_PATH .'public/upload/photo/');
					if($code){
						$info['msg']="上传成功";
						$info['code']="1";
						$info['data']="http://www.media.com/upload/photo/". $code->getFilename();
						return json($info);
					}else{ 
						$info['msg']="上传失败";
						$info['code']="0";
						return json($info);
					}
				}
			//}
		}

		//上传视频
		public function uploadVideo(){
			$path = "Upload/uploadVideo";
			if($this->GetAuth($path)){
				$request = Request::instance();
				$file = request()->file('file');
				if($file){
					$code = $file->rule('uniqid')->validate(["size"=>5000000])->move(ROOT_PATH .'upload/video/');
					if($code){
						$info['msg']="上传成功";
						$info['code']="1";
						$info['data']="http://www.media.com/upload/video/". $code->getFilename();
						return json($info);
					}else{ 
						$info['msg']="上传失败";
						$info['code']="0";
						return json($info);
					}
				}
			}	
		}

		//上传音频
		public function uploadAudio(){
			$path = "Upload/uploadAudio";
			if($this->GetAuth($path)){
				$request = Request::instance();
				$file = request()->file('file');
				if($file){
					$code = $file->rule('uniqid')->validate(["size"=>5000000])->move(ROOT_PATH .'public/upload/audio/');
					if($code){
						$info['msg']="上传成功";
						$info['code']="1";
						$info['data']="http://www.media.com/upload/audio/".$code->getFilename();
						return json($info);
					}else{ 
						$info['msg']="上传失败";
						$info['code']="0";
						return json($info);
					}
				}
			}
		}
	}
?>