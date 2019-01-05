<?php
class Boardsystem_model extends CI_Model{
	public function __construct(){
		$this->load->database("DB1");
		date_default_timezone_set("Asia/Taipei");
	}
	
	public function ShowBoardList()
	{
		$sql="select * from board_info";
        $query=$this->db->query($sql);
        return $query->result_array();
    }
	
	public function CheckIfBoardExsit($Bid)
	{
		$sql="SELECT * FROM `board_info` WHERE `Bid` = ? ";
        $query=$this->db->query($sql,array($Bid));
        return $query->num_rows()>0?true:false;
	}
	
	public function ShowPostList($Bid)
	{
		$sql="SELECT `id`, `Bid`, `Aid`, `title`, `subboard`, `type`, `main`, `writer`, MAX(write_time) as write_time,COUNT(*) FROM `posts` where Bid=? GROUP BY Aid ORDER BY MAX(write_time) DESC";
		
        $query=$this->db->query($sql,array($Bid));
        return $query->result_array();
    }
			
	public function ShowPost($Bid,$Aid)
	{
		$sql="select * from posts Where Bid=? AND Aid=?";
        $query=$this->db->query($sql,array($Bid,$Aid));
		return $query->result_array();
		//return $query->row_array();
    }
	
	public function ShowComments($Aid)
	{
		$sql="select * from board_comments Where Aid=?";
        $query=$this->db->query($sql,array($Aid));
        return $query->result_array();
    }
	
	public function GetPostTitle($Bid,$Aid)
	{
		$sql="select * from posts Where Bid=? AND Aid=? order by write_time ASC";
        $query=$this->db->query($sql,array($Bid,$Aid));
        $row=$query->row();
		return $row->title;
    }
	
	public function DoReply($Bid,$Aid,$title,$ReplyMain,$writer,$write_time)
	{
		$sql="INSERT INTO `posts` (`id`, `Bid`, `Aid`, `title`, `subboard`, `type`, `main`, `writer`, `write_time`) VALUES (NULL, ?, ?, ?, NULL, NULL, ?, ?, ?)";
        $query=$this->db->query($sql,array($Bid,$Aid,$title,$ReplyMain,$writer,$write_time));
    }
	
	public function DoComment($Bid,$Pid,$Aid,$comment,$writer,$write_time)
	{
		$sql="INSERT INTO `board_comments` (`id`, `Bid`, `Pid`, `Aid`, `comment`, `writer`, `write_time`, `status`) VALUES (NULL, ?, ?, ?, ?, ?, ?,default)";
        $query=$this->db->query($sql,array($Bid,$Pid,$Aid,$comment,$writer,$write_time));
    }
	
	public function ShowSubBoard($Bid)
	{
		$sql="select * from board_subboards where Bid=?";
        $query=$this->db->query($sql,array($Bid));
        return $query->result_array();
    }
	
	public function GetNowAid($Bid)
	{
		$sql="select Aid from posts where Bid=? ORDER BY Aid ASC";
		$query=$this->db->query($sql,array($Bid));
		//return $query->result_array();
		$row = $query->last_row('array');
		
		return $row;
	
    }
	
	public function GetBoardName($Bid)
	{
		$sql="select Bname from board_info where Bid=?";
        $query=$this->db->query($sql,array($Bid));
        return $query->row();
    }
	
	public function GetBoardNewId()
	{
		$sql="select id from board_info";
        $query=$this->db->query($sql);
        return $query->num_rows()>0?$query->last_row():"00000";
    }
	public function GetSubBoardInfo($Bid)
	{
		$sql="select subboardName,subboardId from board_subboards where Bid=?";
        $query=$this->db->query($sql,array($Bid));
        return $query->result_array();
    }
	
	public function DoPost($Bid,$now_Aid,$P_postTitle,$postSubboard,$postType,$P_postMain,$writer,$write_time)
	{
		$sql="INSERT INTO `posts` (`id`, `Bid`, `Aid`, `title`, `subboard`, `type`, `main`, `writer`, `write_time`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
        $query=$this->db->query($sql,array($Bid,$now_Aid,$P_postTitle,$postSubboard,$postType,$P_postMain,$writer,$write_time));
    }
	
	public function Dothumb($Bid,$Aid,$Pid,$UId,$data,$create_time)
	{
		$sql="INSERT INTO `posts_likes` (`id`, `Bid`, `Aid`, `Pid`, `Uid`, `data`, `create_time`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
        $query=$this->db->query($sql,array($Bid,$Aid,$Pid,$UId,$data,$create_time));
    }
	
	public function Checkthumb($Bid,$Aid,$UId)
	{
		$sql="select Pid,data from posts_likes where Bid=? And Aid=? And UId=?";
        $query=$this->db->query($sql,array($Bid,$Aid,$UId));
        return $query->result_array();
    }
	public function DoPreRegist($now_UNo,$UMail)
	{
		$sql="INSERT INTO `users` (`id`, `UNo`, `UId`, `UPd`, `UNick`, `UMail`, `UPic`, `ULastLogin`, `RegistWhen`,`UStatus`) VALUES (NULL, ?, NULL, NULL, NULL, ?, NULL, NULL, NULL,NULL)";
        $query=$this->db->query($sql,array($now_UNo,$UMail));
       
    }
	
	public function CheckMailRepeat($UMail)
	{
		$sql="select UNo from users where UMail=?";
        $query=$this->db->query($sql,array($UMail));
        return $query->result_array();
       
    }
	
	public function GetNowUNo()
	{
		$sql="select UNo from users order by UNo";
        $query=$this->db->query($sql);
        return $query->result_array();
    }
	
	public function CheckUPd($UId)
	{
		$sql="select UPd from users where UId=?";
        $query=$this->db->query($sql,array($UId));
        return $query->result_array();
       
    }
	
	public function GetUserInfo($UId)
	{
		$sql="select * from users where UId=?";
        $query=$this->db->query($sql,array($UId));
        return $query->result_array();
       
    }
	
	public function GetReply($BId,$AId)
	{
		$sql="select * from posts where BId=? AND AId=?";
        $query=$this->db->query($sql,array($BId,$AId));
        return $query->result_array();
       
	}

	public function AddNewBoard($Bid,$BName,$BMan){
		$sql="INSERT INTO `board_info` (`id`, `Bid`, `Bname`, `Bmanager`, `BoardImgUrl`) VALUES (NULL,?,?,?,NULL)";
		
		$query=$this->db->query($sql,array($Bid,$BName,$BMan));
		if($query){
			return "新增成功!";

		}else{
			return "新增失敗!";
		}
	}

	public function CheckBoardRepeat($BName){
		$sql="select * from board_info where Bname=?";
		$query=$this->db->query($sql,array($BName));
		
		return $query->num_rows()>0?true:false;
	
	}

	public function DoDropBoard($Bid){
		$sql="DELETE FROM `board_info` WHERE `board_info`.`Bid`=?";
		$query=$this->db->query($sql,array($Bid));
		return $query?true:false;
	}

	public function DoDropPost($WhyDel,$PostId,$WhoDel){
		$sql="UPDATE `posts` SET `status` = 'del', `whydel` = ?, `whodel` = ? WHERE `posts`.`id` = ?";
		$query=$this->db->query($sql,array($WhyDel,$WhoDel,$PostId));
		return $query?true:false;
	}

	public function DoReportPost($BId,$PostId,$WhyReport,$WhoReport,$WhenReport){
		$sql="INSERT INTO `posts_reported` (`id`, `Bid`, `Pid`, `whyreport`, `whoreport`, `whenreport`, `status`) VALUES (NULL,?,?,?,?,?,default)";
		$query=$this->db->query($sql,array($BId,$PostId,$WhyReport,$WhoReport,$WhenReport));
		return $query?true:false;
	}

	/*public function GetReportedPost($Bid){
		$sql="SELECT `Pid` FROM `posts_reported` WHERE `posts_reported`.`Bid`=? AND `posts_reported`.`status`='reported'";
		$query=$this->db->query($sql,array($Bid));
		return $query->num_rows()>0?$query->result_array():false;
	}*/
	//$sql  = 'SELECT `posts_reported`.`id`,`posts_reported`.`Bid`,`posts_reported`.`Pid`,`posts`.`Aid`,`posts`.`title`,`posts`.`writer`,`posts_reported`.`whyreport`,`posts_reported`.`whenreport`,`posts_reported`.`whoreport`,`posts`.`status` FROM `posts`,`posts_reported` WHERE `posts`.`id` =`posts_reported`.`Pid` AND `posts_reported`.`Bid`=\'00001\'';

	public function GetReportedPostDetail($Bid){
		$sql  = 'SELECT `posts_reported`.`id`,`posts_reported`.`Bid`,`posts_reported`.`Pid`,`posts`.`Aid`,`posts`.`title`,`posts`.`writer`,`posts_reported`.`whyreport`,`posts_reported`.`whenreport`,`posts_reported`.`whoreport`,`posts`.`status` FROM `posts`,`posts_reported` WHERE `posts`.`id` =`posts_reported`.`Pid` AND `posts_reported`.`Bid`=?';
		$query=$this->db->query($sql,array($Bid));
		return $query->num_rows()>0?$query->result_array():false;
	}

	public function HasReported($WhoReport,$Pid){
		$sql="SELECT * FROM `posts_reported` WHERE `posts_reported`.`whoreport` = ? AND `posts_reported`.`Pid`=?";
		$query=$this->db->query($sql,array($WhoReport,$Pid));
		return $query->num_rows()>0?true:false;
	}
	//
	public function GetBoardManaged($Uid){
		if($Uid=='61811'){
			$sql="select * from board_info";
			$query=$this->db->query($sql);
		}else{
			$sql="select * from board_info where Bmanager=?";
			$query=$this->db->query($sql,array($Uid));
		}
		
		return $query->num_rows()>0?$query->result_array():false;
	}

	public function CheckSubRepeat($NewSub,$Bid){
		$sql="select * from board_subboards where subboardName=? and Bid=?";
		$query=$this->db->query($sql,array($NewSub,$Bid));
		
		return $query->num_rows()>0?true:false;
	
	}

	public function GetSubNewId()
	{
		$sql="select id from board_subboards";
        $query=$this->db->query($sql);
        return $query->num_rows()>0?$query->last_row()->id:"00000";
	}
	
	public function AddNewSub($Bid,$BName,$Subid,$NewSub){
		$sql="INSERT INTO `board_subboards` (`id`, `Bid`, `boardName`, `subboardId`, `subboardName`, `subboardAbout`) VALUES (NULL,?,?,?,?,NULL)";
		
		$query=$this->db->query($sql,array($Bid,$BName,$Subid,$NewSub));
		if($query){
			return "新增成功!";

		}else{
			return "新增失敗!";
		}
	}

	public function CheckBmanager($BId,$UId){
		$sql="select * from board_info where Bid=? AND Bmanager=?";
		$query=$this->db->query($sql,array($BId,$UId));
		return $query->num_rows()>0?true:false;
	}

	

	

	
	
}

?>