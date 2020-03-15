<?php
namespace app\index\controller;

use think\Controller;
use \think\Request;
use think\Db;
use think\Cookie;
use think\Cache;
use \think\View;
class Show extends Controller
{
    public $list=[];

    
	public function index(){
		header("Access-Control-Allow-Origin: *");
        $request = Request:: instance();
        $id=$request->get('id');//���Ҳid
		$p=$request->get('p');//���������ƶ��˻���pc��
        $cc=db::table('yunque_landing_page')->where('Landingpage_Id',$id)->field('Template')->find();//��ѯģ��id
		$a= 'template/'.$cc['Template'].'/'.$p.'/index.html';
		if($p=="w"){
			$page=$this->W($id);
		}else{

			$page=$this->p($id);
		}
 
        $this->assign('data',$page);
        return $this->fetch($a);
    }


    public function select2($data,$id,$i){
        foreach($data as $key=>$val){
            if($val['PID']==$id){
                array_push($this->list,$val);
                $this->select2($data,$val["ID"],$i);
            }
        }
    }

    //��Ⱦ�����ҳ pc
    public function P(){
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        $Landingpage_Id = $request->get('id');		
		$data=Db::table('yunque_landing_page')->where('Landingpage_Id',$Landingpage_Id)->where('Status','1')->find();
		if(!$data){
			return null;
			//Ӧ ��ת�� ����ҳ��
			//$info['msg'] = '�Բ��������ʵ�ҳ�治����';
			//$info['code'] = '0';
			//return json($info);
		}
        // $code=Db::table('yunque_template')->where('Template_Id',$data['Template'])->field('Path')->find();
		//$a = 'p/index.html';
          //����ͳ�ƴ���
          $CensusCode = $data['CensusCode'];
          //��ע��
          $FllowNum = $data['FllowNum'];
          //������
          $VisitNum =$data['VisitNum'];
        $page['CensusCode'] = $CensusCode;
        $page['FllowNum'] = $FllowNum;
        $page['VisitNum'] = $VisitNum;
		$page['Landingpage_Id'] = $data['Landingpage_Id'];

        if(Cookie::has('id')){
            $service = Cookie::get('id');
            $pageuser = json_decode($data['CustomerService_Id'],true);
            //�жϿͷ���Ϣ�Ƿ����
            if($pageuser){
				foreach($pageuser as $key=>$val){
					if($val['Id'] == $service){
						$customer = $val;
					}
				}
				for($i = 0; $i < count($pageuser); $i++){
					if($pageuser[$i]['Id'] == $service){
						$customer = $pageuser[$i];
						$i = count($pageuser) + 1;
					}
				}
				if($i <= count($pageuser)){
					$customer = [];
					$customer = [
						'Photo' => null,
						'CustomerService_Name'=> null,
						'CustomerService_Tel'=> null,
						'CustomerService_Wechat' => null,
						'QrCode' =>null,
					];
				}
            }else{
				$customer = [];
				$customer = [
					'Photo' => null,
					'CustomerService_Name'=> null,
					'CustomerService_Tel'=> null,
					'CustomerService_Wechat' => null,
					'QrCode' =>null,
				];
            }
			if($data['Question']){
				$data['Question'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Question']);
				$data['Question'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Question']);
				$data['Question'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Question']);
				$data['Question'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Question']);
				$data['Question'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Question']);
			}
            if($data['Reply']){
				$data['Reply'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Reply']);
				$data['Reply'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Reply']);
				$data['Reply'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Reply'] );
				$data['Reply'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Reply']);
				$data['Reply'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Reply']);
			}
            //���Ĳ���������
            $Group = Db::table('yunque_landing_page')->where('Group_Id',$data['Group_Id'])->field('Landingpage_Id,Question')->select();
            foreach ($Group as $key => $val) {
              $Group[$key]['Question'] = json_decode($val['Question'],true);
            }
            $page['Group'] = $Group;
            $page['Question']= json_decode($data['Question'],true);
            $page['Copyright'] = $data['Copyright'];

            $page['answer'] = [];
            $reply = json_decode($data["Reply"],true);
            for($i=0;$i<count($reply);$i++){
                if(""==$reply[$i]["PID"]){
                    array_push($page['answer'],$reply[$i]);
                }
            } 
			array_multisort(array_column($page['answer'],'time'),SORT_ASC,$page['answer']);
            for($k=0;$k<count($page['answer']);$k++){
                $page['answer'][$k]["comment"] = [];
                $this->select2($reply,$page["answer"][$k]["ID"],$k);
                $page['answer'][$k]["comment"] = $this->list;
				array_multisort(array_column( $page['answer'][$k]["comment"],'time'),SORT_ASC, $page['answer'][$k]["comment"]);
                $this->list=[];
            }
            //���岽��Ⱦ����
			return $page;
            //$this->assign('data',$page);
            //return $this->fetch($a);
        }
		//��һ����ȡ����
		// $data=Db::table('yunque_landing_page')->where('Landingpage_Id',135)->find();
		//����ͳ�ƴ���
		// $CensusCode = $data['CensusCode'];
		//�ڶ�������ͷ�
		// $cid = array_rand(json_decode($data['CustomerService_Id'],true),1);
		$pageuser = json_decode($data['CustomerService_Id'],true);
		//��ѯ�û��� �ͷ��Ƿ���ڣ��ͷ�״̬�����ǿ�����
		if($pageuser){
			$pageuserId = [];
			foreach( $pageuser as $key){
				array_push($pageuserId,$key['Pid']);
			}
			$pageuserId = array_unique($pageuserId);
			$user = Db::table('yunque_userinfo')->where('User_Id','in',$pageuserId)->field('User_Id,Status')->select();
			$userId = [];
			foreach($user as $key){
				array_push($userId,$key['User_Id']);
			}
			//�ж� ���ҳ�ͷ��Ƿ� ���� ���ݲ�ƥ��  �û������Ϣ
			$code = array_diff($pageuserId,$userId);
			if($code){
				// �������� ���ҳid �ͷ�id ��˾id
				$this->page($Landingpage_Id,$code,$data['Corporate_Id']);
			}
			//�ж� �û���� �ͷ����״̬ �Ƿ� Ϊ1
			for($i = 0; $i < count($user); $i++){
				if($user[$i]['Status'] == '0'){
					for($j = 0; $j < count($pageuser); $j++) {
						if($pageuser[$j]['Pid'] == $user[$i]['User_Id']){
							array_splice($pageuser,$j,1);
							$j--;
						}
					}
				}

			}
			for($j = 0; $j < count($pageuser); $j++) {
				if($pageuser[$j]['Status'] == '0'){
					array_splice($pageuser,$j,1);
					$j--;  
				}
			}		
			
			//�ж��Ƿ���ڿͷ�
			if(!count($pageuser)){
				$customer = [];
				$customer = [
					'Photo' => null,
					'CustomerService_Name'=> null,
					'CustomerService_Tel'=> null,
					'CustomerService_Wechat' => null,
					'QrCode' =>null
				];
			}else{
				$customer = $pageuser[array_rand($pageuser,1)];
				Cookie::set('id',$customer['Id'],3600);	
			}
        }else{
			$customer = [];
				$customer = [
					'Photo' => null,
					'CustomerService_Name'=> null,
					'CustomerService_Tel'=> null,
					'CustomerService_Wechat' => null,
					'QrCode' =>null
				];
        }
        //�������滻�ͷ�
       if($data['Question']){
			$data['Question'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Question']);
			$data['Question'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Question']);
			$data['Question'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Question']);
			$data['Question'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Question']);
			$data['Question'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Question']);
		}
		if($data['Reply']){
			$data['Reply'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Reply']);
			$data['Reply'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Reply']);
			$data['Reply'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Reply'] );
			$data['Reply'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Reply']);
			$data['Reply'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Reply']);
		}
        //���Ĳ���������
        $Group = Db::table('yunque_landing_page')->where('Group_Id',$data['Group_Id'])->field('Landingpage_Id,Question')->select();
        foreach ($Group as $key => $val) {
          $Group[$key]['Question'] = json_decode($val['Question'],true);
        }
        $page['Group'] = $Group;
        $page['Question']= json_decode($data['Question'],true);
        $page['Copyright'] = $data['Copyright'];
        $page['answer'] = [];
        $reply = json_decode($data["Reply"],true);
        for($i=0;$i<count($reply);$i++){
            if(""==$reply[$i]["PID"]){
                array_push($page['answer'],$reply[$i]);
            }
        }
        array_multisort(array_column($page['answer'],'time'),SORT_ASC,$page['answer']);
        for($k=0;$k<count($page['answer']);$k++){
			$page['answer'][$k]["comment"] = [];
			$this->select2($reply,$page["answer"][$k]["ID"],$k);
			$page['answer'][$k]["comment"] = $this->list;
			array_multisort(array_column( $page['answer'][$k]["comment"],'time'),SORT_ASC, $page['answer'][$k]["comment"]);
			$this->list=[];
        }
		//dump($page);
		//exit;
        //���岽��Ⱦ����
        //$this->assign('data',$page);
       // return $this->fetch($a);
	   return $page;
    }

    //��Ⱦ�����ҳ wap
    public function W(){
        header("Access-Control-Allow-Origin: *");
        $request = Request::instance();
        $Landingpage_Id = $request->get('id');
        //$Landingpage_Id = 155;
        $data=Db::table('yunque_landing_page')->where('Landingpage_Id',$Landingpage_Id)->where('Status','1')->find();
		if(!$data){
			return null;
			//Ӧ ��ת�� ����ҳ��
			//$info['msg'] = '�Բ��������ʵ�ҳ�治����';
			//$info['code'] = '0';
			//return json($info);
		}
        // $code=Db::table('yunque_template')->where('Template_Id',$data['Template'])->field('Path')->find();
        $a = 'w/index.html';
          //����ͳ�ƴ���
          $CensusCode = $data['CensusCode'];
          //��ע��
          $FllowNum = $data['FllowNum'];
          //������
          $VisitNum =$data['VisitNum'];
        $page['CensusCode'] = $CensusCode;
        $page['FllowNum'] = $FllowNum;
        $page['VisitNum'] = $VisitNum;
		$page['Landingpage_Id'] = $data['Landingpage_Id'];
        if(Cookie::has('id')){
            $service = Cookie::get('id');
            
            $pageuser = json_decode($data['CustomerService_Id'],true);
            //�жϿͷ���Ϣ�Ƿ����
            if($pageuser){
				foreach($pageuser as $key=>$val){
					if($val['Id'] == $service){
						$customer = $val;
					}
				}
				for($i = 0; $i < count($pageuser); $i++){
					if($pageuser[$i]['Id'] == $service){
						$customer = $pageuser[$i];
						$i = count($pageuser) + 1;
					}
				}
				if($i <= count($pageuser)){
					$customer = [];
					$customer = [
						'Photo' => null,
						'CustomerService_Name'=> null,
						'CustomerService_Tel'=> null,
						'CustomerService_Wechat' => null,
						'QrCode' =>null,
					];
				}
            }else{
				$customer = [];
				$customer = [
					'Photo' => null,
					'CustomerService_Name'=> null,
					'CustomerService_Tel'=> null,
					'CustomerService_Wechat' => null,
					'QrCode' =>null,
				];
            }
			if($data['Question']){
				$data['Question'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Question']);
				$data['Question'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Question']);
				$data['Question'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Question']);
				$data['Question'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Question']);
				$data['Question'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Question']);
			}
            if($data['Reply']){
				$data['Reply'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Reply']);
				$data['Reply'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Reply']);
				$data['Reply'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Reply'] );
				$data['Reply'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Reply']);
				//$data['Reply'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Reply']);
				$data['Reply'] = str_replace("[qrcode]","",$data['Reply']);
			}
            //���Ĳ���������
            $Group = Db::table('yunque_landing_page')->where('Group_Id',$data['Group_Id'])->field('Landingpage_Id,Question')->select();
            foreach ($Group as $key => $val) {
              $Group[$key]['Question'] = json_decode($val['Question'],true);
            }
            $page['Group'] = $Group;
            $page['Question']= json_decode($data['Question'],true);
            $page['Copyright'] = $data['Copyright'];

            $page['answer'] = [];
            $reply = json_decode($data["Reply"],true);
            for($i=0;$i<count($reply);$i++){
                if(""==$reply[$i]["PID"]){
                    array_push($page['answer'],$reply[$i]);
                }
            }
			array_multisort(array_column($page['answer'],'time'),SORT_ASC,$page['answer']);
            for($k=0;$k<count($page['answer']);$k++){
                $page['answer'][$k]["comment"] = [];
                $this->select2($reply,$page["answer"][$k]["ID"],$k);
                $page['answer'][$k]["comment"] = $this->list;
				array_multisort(array_column( $page['answer'][$k]["comment"],'time'),SORT_ASC, $page['answer'][$k]["comment"]);
                $this->list=[];
            }
            // dump($page);
            // exit;
            //���岽��Ⱦ����
            //$this->assign('data',$page);
            //return $this->fetch($a);
			return $page;
        }
        //��һ����ȡ����
        // $data=Db::table('yunque_landing_page')->where('Landingpage_Id',135)->find();
        //����ͳ�ƴ���
        // $CensusCode = $data['CensusCode'];
        //�ڶ�������ͷ�
        // $cid = array_rand(json_decode($data['CustomerService_Id'],true),1);
        $pageuser = json_decode($data['CustomerService_Id'],true);
        //��ѯ�û��� �ͷ��Ƿ���ڣ��ͷ�״̬�����ǿ�����
        if($pageuser){
			$pageuserId = [];
			foreach( $pageuser as $key){
				array_push($pageuserId,$key['Pid']);
			}
			$pageuserId = array_unique($pageuserId);
			$user = Db::table('yunque_userinfo')->where('User_Id','in',$pageuserId)->field('User_Id,Status')->select();
			$userId = [];
			foreach($user as $key){
				array_push($userId,$key['User_Id']);
			}
			//�ж� ���ҳ�ͷ��Ƿ� ���� ���ݲ�ƥ��  �û������Ϣ
			$code = array_diff($pageuserId,$userId);
			if($code){
				// �������� ���ҳid �ͷ�id ��˾id
				$this->page($Landingpage_Id,$code,$data['Corporate_Id']);
			}
			//�ж� �û���� �ͷ����״̬ �Ƿ� Ϊ1
			for($i = 0; $i < count($user); $i++){
				if($user[$i]['Status'] == '0'){
					for($j = 0; $j < count($pageuser); $j++) {
						if($pageuser[$j]['Pid'] == $user[$i]['User_Id']){
							array_splice($pageuser,$j,1);
							$j--;
						}
					}
				}
			}

			for($j = 0; $j < count($pageuser); $j++) {
				if($pageuser[$j]['Status'] == '0'){
					array_splice($pageuser,$j,1);
					$j--;  
				}
			}		
			//�ж��Ƿ���ڿͷ�
			if(!count($pageuser)){
				$customer = [];
				$customer = [
					'Photo' => null,
					'CustomerService_Name'=> null,
					'CustomerService_Tel'=> null,
					'CustomerService_Wechat' => null,
					'QrCode' =>null
				];
			}else{
				$customer = $pageuser[array_rand($pageuser,1)];
				Cookie::set('id',$customer['Id'],3600);	
			}
        }else{
			$customer = [];
            $customer = [
				'Photo' => null,
                'CustomerService_Name'=> null,
                'CustomerService_Tel'=> null,
                'CustomerService_Wechat' => null,
                'QrCode' =>null
            ];
        }
        //�������滻�ͷ�
        if($data['Question']){
				$data['Question'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Question']);
				$data['Question'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Question']);
				$data['Question'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Question']);
				$data['Question'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Question']);
				$data['Question'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Question']);
			}
            if($data['Reply']){
				$data['Reply'] = str_replace("[avatar]","<img src='".$customer["Photo"]."' />",$data['Reply']);
				$data['Reply'] = str_replace("[nickname]",$customer["CustomerService_Name"],$data['Reply']);
				$data['Reply'] = str_replace("[tel]","<span class='dx-tel'>".$customer["CustomerService_Tel"]."</span>",$data['Reply'] );
				$data['Reply'] = str_replace("[wechat]","<span class='dx-wchat'>".$customer["CustomerService_Wechat"]."</span>",$data['Reply']);
				//$data['Reply'] = str_replace("[qrcode]","<img src='".$customer["QrCode"]."' />",$data['Reply']);
				$data['Reply'] = str_replace("[qrcode]","",$data['Reply']);
			}
        //���Ĳ���������
        $Group = Db::table('yunque_landing_page')->where('Group_Id',$data['Group_Id'])->field('Landingpage_Id,Question')->select();
        foreach ($Group as $key => $val) {
          $Group[$key]['Question'] = json_decode($val['Question'],true);
        }
        $page['Group'] = $Group;
        $page['Question']= json_decode($data['Question'],true);
        $page['Copyright'] = $data['Copyright'];
        $page['answer'] = [];
        $reply = json_decode($data["Reply"],true);
        for($i=0;$i<count($reply);$i++){
            if(""==$reply[$i]["PID"]){
                array_push($page['answer'],$reply[$i]);
            }
        }
        array_multisort(array_column($page['answer'],'time'),SORT_ASC,$page['answer']);
        for($k=0;$k<count($page['answer']);$k++){
          $page['answer'][$k]["comment"] = [];
          $this->select2($reply,$page["answer"][$k]["ID"],$k);
          $page['answer'][$k]["comment"] = $this->list;
          array_multisort(array_column( $page['answer'][$k]["comment"],'time'),SORT_ASC, $page['answer'][$k]["comment"]);
          $this->list=[];
        }
        //���岽��Ⱦ����
        // dump($page);
        // exit;
        //$this->assign('data',$page);
        //return $this->fetch($a);
		return $page;
    }

    //ɾ�� ���ҳ �ͷ�
    //���ҳ id , ����Ŀͷ� $code,��˾id $Corporate_Id
      public function page($id,$code,$Corporate_Id){
        $data=Db::table('yunque_landing_page')->where(['Landingpage_Id'=>$id,'Corporate_Id'=>$Corporate_Id])->find();
        $user = json_decode($data['CustomerService_Id'],true);
        for($i = 0; $i < count($code); $i++){
            foreach( $user as $key=>$val){
                if($val['Pid'] == $code[$i]){
                    array_splice($user,$key,1);
                }
            }
        }
        $data['CustomerService_Id'] = json_encode($user,true);
        Db::table('yunque_landing_page')->where(['Landingpage_Id'=>$id,'Corporate_Id'=>$Corporate_Id])->update(['CustomerService_Id' => $data['CustomerService_Id']]);
      }
}
?>