<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JustTalk extends CI_Controller {

    public function __construct(){
        parent::__construct();
			$this->load->model('boardsystem_model');
			$this->load->helper('url');
			$this->load->helper('cookie');
			
			session_start();
			
	}


    public function BoardList(){
		$data['record'] = $this->boardsystem_model->ShowBoardList();
		$data['count']=1;
		$data['tab']=1;
		$data['title'] = '看板列表';
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/board_list', $data);
		$this->load->view('templates/footer');
    }

    public function PostList(){
	
		$Bid=$_GET['Bid'];
		$data['tab']=2;
		if(isset($_GET['login'])){
			$data['login']=1;
		}
		$data['Bid']=$Bid;
		$IfBoardExsit=$this->boardsystem_model->CheckIfBoardExsit($Bid);
		if($IfBoardExsit){
			$data['record'] = $this->boardsystem_model->ShowPostList($Bid);
			$data['Bname'] = $this->boardsystem_model->GetBoardName($Bid)->Bname;
			$data['subboard']=$this->boardsystem_model->ShowSubBoard($Bid);
			//foreach ($data['Bname'] as $Bnames);
			foreach ($data['record'] as $records);
			$data['title'] = $data['Bname'];
			$_SESSION['Bname'] = $data['Bname'];
			$this->load->view('templates/header', $data);
			$this->load->view('BoardSystem/post_list', $data);
			$this->load->view('templates/footer');
		}else{
			show_404();
		}
	
	}
	
	public function PostView(){
		$Bid= $_GET['Bid'];
		$Aid= $_GET['Aid'];
		
		if(isset($_SESSION['UId'])){
			$UId=$_SESSION['UId'];
			$data['like'] = $this->boardsystem_model->Checkthumb($Bid,$Aid,$UId);
			$data['IsBM']=$this->IsManage($Bid,$UId);
		}else{
			$data['like']=array();
			$data['IsBM']=false;
		}
		$data['tab']=2;
		$data['Bid']=$Bid;
		$data['Aid']=$Aid;
		$data['post'] = $this->boardsystem_model->ShowPost($Bid,$Aid);
		$data['comment'] = $this->boardsystem_model->ShowComments($Aid);
		
		//$data['reply'] = $this->boardsystem_model->GetReply($Bid,$Aid);
		
		$data['title'] = $this->boardsystem_model->GetPostTitle($Bid,$Aid);
		$i=0;
		foreach ($data['post'] as $records):
			$gg=$this->imgDeal($records['main']);	
			$data['PostMain'][$i]=$gg;
			$i++;
		endforeach;
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/post_show',$data);
		$this->load->view('templates/footer');
	}
	
	public function GoPost(){
		$this->SessionCheck();
		$Bid=$_GET['Bid'];
		$data['tab']=2;
		
		$data['Bid']=$Bid;
		$data['record'] = $this->boardsystem_model->ShowSubBoard($Bid);
		$data['ans']=$this->boardsystem_model->GetNowAid($Bid);
		if($data['ans']>0){
			//foreach ($data['ans'] as $ans);
		
			$data['Aid'] = $data['ans']['Aid']+1;
		}else{
			$data['Aid']=1;
		}
		
		$data['title'] = '發文';
		$data['postcode'] =$this->GetCaptcha();
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/post_form', $data);
		$this->load->view('templates/footer');
	
    }
	public function EasyReply(){
		$Bid=$_GET['Bid'];
		$Aid=$_GET['Aid'];
		$title='RE：'.$_POST['title'];
		$ReplyMain=$_POST['ReplyMain'];
		$writer=$_SESSION['UId'];
		$write_time=date("Y-m-d")." ".date("H:i:s");
		$this->boardsystem_model->DoReply($Bid,$Aid,$title,$ReplyMain,$writer,$write_time);
		
		//echo json_encode($data);
    }
	
	public function GoComment(){
		$Bid=$_GET['Bid'];
		$Aid=$_GET['Aid'];
		$comment=$_POST['comment'];
		$Pid=$_POST['Pid'];
		$writer=$_SESSION['UId'];
		$write_time=date("Y-m-d")." ".date("H:i:s");
		$this->boardsystem_model->DoComment($Bid,$Pid,$Aid,$comment,$writer,$write_time);
		$data['writer']=$writer;
		$data['comment']=$comment;
		$data['write_time']=$write_time;
		echo json_encode($data);
    }
	
	public function GoThumb(){
		$Bid=$_GET['Bid'];
		$Aid=$_GET['Aid'];
		$Pid=$_POST['pid'];
		$UId=$_SESSION['UId'];
		$data=$_POST['x'];
		$create_time=date("Y-m-d")." ".date("H:i:s");
		$this->boardsystem_model->Dothumb($Bid,$Aid,$Pid,$UId,$data,$create_time);
		
		//$data['pid']=$Pid;
		//$data['data']=$data;
		//$data['create_time']=$create_time;
		//echo json_encode($data);
    }
			
	public function DoPost(){
		$Bid=$_GET['Bid'];
		$postTitle=$_POST['postTitle'];
		$postSubboard=$_POST['postSubboard'];
		$postType=$_POST['postType'];
		$postMain=$_POST['postMain'];
		$writer=$_SESSION['UId'];
		$write_time=date("Y-m-d")." ".date("H-i-s");
		$name=array();
		$id=array();
		$data['Info']=$this->boardsystem_model->GetSubBoardInfo($Bid);
		SWITCH($postType){
			case 'type_ask':
				$postType='【問題】';
				$postTitle=$postType.$postTitle;
				break;
			case 'type_talk':
				$postType='【討論】';
				$postTitle=$postType.$postTitle;
				break;
			case 'type_news':
				$postType='【情報】';
				$postTitle=$postType.$postTitle;
				break;
			case 'type_share':
				$postType='【心得】';
				$postTitle=$postType.$postTitle;
				break;
			case 'type_other':
				$postType='【其他】';
				$postTitle=$postType.$postTitle;
				break;
		}
		foreach($data['Info'] as $Infos){
			$name[]=$Infos['subboardName'];
			$id[]=$Infos['subboardId'];
		}
		
		for($i=0;$i<=(count($id)-1);$i++){
			while($postSubboard==$id[$i]){
				$postSubboard=$name[$i];
			}
		}
		$data['ans']=$this->boardsystem_model->GetNowAid($Bid);
		
		$now_Aid = $data['ans']['Aid']+1;
		$now_Aid=$this->GetNowId($now_Aid);
		$P_postMain=$this->CheckPostMain($postMain);	
		$P_postTitle=$this->CheckPostMain($postTitle);
		$this->boardsystem_model->DoPost($Bid,$now_Aid,$P_postTitle,$postSubboard,$postType,$P_postMain,$writer,$write_time);
		
    }
	
	
	
	public function Preview(){
		if(@$_POST['pvTitle']!=null && @$_POST['pvMain']!=null){
			$data['pvTitle']=$_POST['pvTitle'];
			//$data['pvMain']=$_POST['pvMain'];
		}else{
			show_404();
		}
		$data['title'] = '發文預覽頁面';
		$data['pvMain']=$this->CheckPostMain($_POST['pvMain']);
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/post_preview', $data);
		$this->load->view('templates/footer');
    }
	
	public function PreRegist(){
		$UMail=$_POST['UMail'];
		$data['ReturnMail']=$this->boardsystem_model->CheckMailRepeat($UMail);
		if(!$data['ReturnMail']){
			$data['result']=$this->boardsystem_model->GetNowUNo();
			foreach ($data['result'] as $result);
			$now_UNo = $result['UNo']+1;
			$now_UNo=$this->GetNowId($now_UNo);
			$this->boardsystem_model->DoPreRegist($now_UNo,$UMail);	
			$data['success']=1;
			$data['msg']='「'.$UMail.'」'.' 請至登記的信箱收信以完成註冊程序!';
		}else if($data['ReturnMail']){
			$data['success']=0;
			$data['msg']='「'.$UMail.'」'.' 此信箱已註冊過!';
			
		}
		echo json_encode($data);
	}
	
	public function LoginCheck(){
	
		$UId=$_POST['UId'];
		$UPd=$_POST['UPd'];
		$result['ReturnUPd']=$this->boardsystem_model->CheckUPd($UId);
		if(!empty($result['ReturnUPd'])){
			foreach ($result['ReturnUPd'] as $ans);
			if(password_verify($UPd,$ans['UPd'] )) {
				$result['UserInfo']=$this->boardsystem_model->GetUserInfo($UId);
				foreach ($result['UserInfo'] as $UserInfo);
				$data['success']=1;
				$data['msg']='「'.$UId.'」'.' 登入成功!';
				$_SESSION['status']=1;
				$_SESSION['UId']=$UserInfo['UId'];
				$_SESSION['UNick']=$UserInfo['UNick'];
				$_SESSION['Utype']=$UserInfo['Utype'];
				//setcookie( "LoginId",$UserInfo['UId'], time()+10);
				//$this->input->set_cookie( "LoginId",$UserInfo['UId'], time()+10);
			}else{
				$data['success']=0;
				$data['msg']='「'.$UId.'」'.' 密碼錯誤!';
			}
		}else{
			$data['success']=0;
			$data['msg']='「'.$UId.'」'.' 查無此帳號!';
			
		}
		echo json_encode($data);
	}
	
	public function LoginPage(){
		$data['title'] = '登入頁面';
		
		if(isset($_SESSION['UId'])){
			header('Location: '.'/');
		}
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/login_page', $data);
		$this->load->view('templates/footer');
		
	}
	
	public function LogOut(){
	
		//$UId=$_POST['UId'];
		//$UPd=$_POST['UPd'];
		//$result['ReturnUPd']=$this->boardsystem_model->CheckUPd($UId);
		if($_SESSION['status']==1){
			$data['success']=1;
			$data['msg']='「'.$_SESSION['UId'].'」'.' 登出成功!';
			$_SESSION['status']=0;
			setcookie( "LoginId","", time()-3600);
			session_destroy();
		}else if($_SESSION['status']==0){
			$data['success']=1;
			$data['msg']='「'.$_SESSION['UId'].'」'.' 已在其他位置登出!';
			session_destroy();
		}
		
		echo json_encode($data);
	}
	
	public function Register(){
	
		//$UId=$_POST['UId'];
		//$UPd=$_POST['UPd'];
		//$result['ReturnUPd']=$this->boardsystem_model->CheckUPd($UId);
		/*if($_SESSION['status']==1){
			$data['success']=1;
			$data['msg']='「'.$_SESSION['UId'].'」'.' 登出成功!';
			$_SESSION['status']=0;
			session_destroy();
		}else if($_SESSION['status']==0){
			$data['success']=1;
			$data['msg']='「'.$_SESSION['UId'].'」'.' 已在其他位置登出!';
			session_destroy();
		}
		
		echo json_encode($data);*/
		$data['title']='註冊頁面';
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/regist_form',$data);
		$this->load->view('templates/footer');
	}

	public function TheManBehind(){
		$data['title']='後臺管理';
		if($_SESSION['Utype']!="superuser"){
			header('Location: '.'./LoginPage');
		}
		$data['record'] = $this->boardsystem_model->ShowBoardList();
		$data['count']=1;
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/behind',$data);
		$this->load->view('templates/footer');

	}

	public function NewBoard(){
		
		$BName=$_POST['BName'];
		$BMan=$_POST['BMan']>0?$_POST['BMan']:NULL;
		$IsRepeat=$this->boardsystem_model->CheckBoardRepeat($BName);
		if($IsRepeat){
			$data['msg']="看板名稱重複!";
		}else{
			$Bid=($this->boardsystem_model->GetBoardNewId()->id)+1;
			$Bid=$this->GetNowId($Bid);
			$data['msg']=$this->boardsystem_model->AddNewBoard($Bid,$BName,$BMan);

		}
		echo json_encode($data);
	}

	public function DropBoard(){
		$Bid=$_POST['Bid'];
		$IsDrop=$this->boardsystem_model->DoDropBoard($Bid);
		if($IsDrop){
			$data['msg']="刪除成功";
		}else{
			$data['msg']="刪除失敗";
		}
		echo json_encode($data);

	}

	public function ShowManageList(){
		$data['title']="我管理的看板";
		//$this->IsManage();
		$Uid=isset($_SESSION['UId'])?$_SESSION['UId']:'';
		$data['count']=1;
		$data['record']=$this->boardsystem_model->GetBoardManaged($Uid);
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/managelist',$data);
		$this->load->view('templates/footer');
	}
	public function BoardManage(){
		$data['title']="管理看板";
		$data['tab']=2;
		$Bid=$_GET['Bid'];
		$UId=isset($_SESSION['UId'])?$_SESSION['UId']:"";
		if(!$this->IsManage($Bid,$UId)){
			header('Location: '.'./LoginPage');
		}
		$data['Bid']=$Bid;
		$_SESSION['Bname'] = $this->boardsystem_model->GetBoardName($Bid)->Bname;
		$data['Info']=$this->boardsystem_model->GetSubBoardInfo($Bid);
		$data['ReportedPost']=$this->boardsystem_model->GetReportedPostDetail($Bid);
		if($data['ReportedPost']==false){
			$data['ReportedPost']=null;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('BoardSystem/boardmanage',$data);
		$this->load->view('templates/footer');
	}

	public function NewSubBoard(){
		
		$Bid=$_POST['Bid'];
		$NewSub=$_POST['NewSub'];
		$IsRepeat=$this->boardsystem_model->CheckSubRepeat($NewSub,$Bid);
		if($IsRepeat){
			$data['msg']="子版名稱重複!";
		}else{
			
			$Subid=($this->boardsystem_model->GetSubNewId())+1;
			$Subid=$this->GetNowId($Subid);
			$BName=$this->boardsystem_model->GetBoardName($Bid)->Bname;
			$data['msg']=$this->boardsystem_model->AddNewSub($Bid,$BName,$Subid,$NewSub);

		}
		echo json_encode($data);
	}

	public function DropPost(){
		//data:{PostId:PostId,WhyDel:WhyDel},
		$UId=isset($_SESSION['UId'])?$_SESSION['UId']:"";
		$BId=$_GET['Bid'];
		if($this->IsManage($BId,$UId)){
			$PostId=isset($_POST['PostId'])?$_POST['PostId']:"";
			$WhyDel=isset($_POST['WhyDel'])?$_POST['WhyDel']:"";
			$WhoDel=isset($_SESSION['UId'])?$_SESSION['UId']:"";
			switch($WhyDel){
				case 1:{
					$WhyDel="與本版主題不符";
					break;
				}
				case 2:{
					$WhyDel="內含限制級字眼";
					break;
				}
				case 3:{
					$WhyDel="謾罵洗版";
					break;
				}
				case 4:{
					$WhyDel=html_escape($WhyDel);
					break;
				}
			}
			$result=$this->boardsystem_model->DoDropPost($WhyDel,$PostId,$WhoDel);
			$data['msg']="文章編號：".$PostId."\n\n刪除原因：".$WhyDel."\n\n結果：".$result."\n\n刪除者：".$WhoDel;
		}else{
			$data['msg']="access deny";
		}
		echo json_encode($data);

	}

	public function ReportPost(){
		$UId=isset($_SESSION['UId'])?$_SESSION['UId']:"";
		$BId=$_GET['Bid'];
		
		if($UId){
			$PostId=isset($_POST['PostId'])?$_POST['PostId']:"";
			$WhyReport=isset($_POST['WhyReport'])?$_POST['WhyReport']:"";
			$WhoReport=isset($_SESSION['UId'])?$_SESSION['UId']:"";
			$HasReported=$this->boardsystem_model->HasReported($WhoReport,$PostId);
			$WhenReport=date("Y-m-d")." ".date("H-i-s");
			if(!$HasReported){
				switch($WhyReport){
					case 1:{
						$WhyReport="與本版主題不符";
						break;
					}
					case 2:{
						$WhyReport="內含限制級字眼";
						break;
					}
					case 3:{
						$WhyReport="謾罵洗版";
						break;
					}
					case 4:{
						$WhyReport=html_escape($WhyReport);
						break;
					}
				}
				
				$result=$this->boardsystem_model->DoReportPost($BId,$PostId,$WhyReport,$WhoReport,$WhenReport);
				$result===true?$result="成功":$result="失敗";
				$data['msg']="文章編號：".$PostId."\n\n檢舉原因：".$WhyReport."\n\n檢舉者：".$WhoReport."\n\n結果：".$result;
			}else{
				$data['msg']="你已經檢舉過了";
			}
		}else{
			$data['msg']="login plz";
		}
	echo json_encode($data);
	} 
	//functions
	private function imgDeal($cc){ 
		$pattern = array(
			'/&lt;img&nbsp;src=&quot;/',
			"/&lt;\/img&gt;/",
			'/&gt;/',
			'/&quot;/'
		);
	$replace = array('<img src="','</img>','>','"');
	$gg=preg_replace($pattern, $replace, $cc);
	return $gg;
	}

	private function GetCaptcha(){
		$o_post_code=rand(0,1000);
			Switch(strlen($o_post_code)){
				case 1:
					$post_code="000".$o_post_code;
					break;
				case 2:
					$post_code="00".$o_post_code;
					break;
				case 3:
					$post_code="0".$o_post_code;
					break;
				case 4:
					$post_code=$o_post_code;
					break;
			}
		return $post_code;
	}

	private function GetNowId($now_id){
			Switch(strlen($now_id)){
				case 1:
					$now_id='0000'.$now_id;
					break;
				case 2:
					$now_id='000'.$now_id;
					break;
				case 3:
					$now_id='00'.$now_id;
					break;
				case 4:
					$now_id='0'.$now_id;
					break;
				case 5:
					$now_id=$now_id;
					break;
			}
			return $now_id;
	}
	
	private function CheckPostMain($data){
		$pattern = array(
			'/</',
			'/>/',
			'/"/',
			"/'/",
			'/ /',//半角下空格
			'/　/',//全角下空格
			'/\r\n/',//window 下换行符
			'/\n/',//Linux && Unix 下换行符
		);
		$replace = array('&lt;','&gt;','&quot;','&#39;','&nbsp;','&nbsp;','<br />','<br />');
		$data=preg_replace($pattern, $replace, $data);
		return $data;
	}

	private function SessionCheck(){
		if(isset($_SESSION['UId'])){
			return true;
		}else{
			header('Location: '.'./LoginPage');
		}
	}

	private function IsManage($BId,$UId){
		$IsBM=$this->boardsystem_model->CheckBmanager($BId,$UId);
		if($_SESSION['Utype']!='superuser' && !$IsBM){
			return false;
		}else{
			return true;
		}
	}

	
	////test function 
	public function apitest(){
		$Bid='00001';
		$data['ans']=$this->boardsystem_model->GetNowAid($Bid);
		//print_r ($data['ans']);
		//foreach($data['ans'] as $ans);
		echo $data['ans']['Aid'];
	}

	public function createhash(){
		$pwd=isset($_GET['a'])?$_GET['a']:'';
		if($pwd!=''){
			echo password_hash($pwd, PASSWORD_DEFAULT);

		}else{
			echo "none";
		}
		
	}


}