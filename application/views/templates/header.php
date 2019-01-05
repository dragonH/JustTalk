<!DOCTYPE HTML>
<?php 

?>
<html>
<?php
date_default_timezone_set("Asia/Taipei");

//$_SESSION['status']=0;

?>

<head>
	<title><?php echo $title ?> - JustTalk</title>
	<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('/assets/js/bootstrap.min.js')?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('/assets/css/bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?php echo base_url('/assets/css/justtalk.css')?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	
	<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet' type='text/css'>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
				
	
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">		
		
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mynavbar" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="/" class="navbar-brand">
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
					JustTalk
				</a>
			</div>
				
			<div class="navbar-collapse collapse" id="mynavbar">
				<div class="row subnav">
				<ul class="nav navbar-nav">
					
					<li><a href="/JustTalk/BoardList">討論版</a></li>
					
				</ul>	
					
				<ul class="nav navbar-nav navbar-right">
					
					<?php
					//$IsLogin=false;
					//$IsLogin=0;
						if(isset($_SESSION['status']) && $_SESSION['status']==1){
							echo "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false' ><span class='glyphicon glyphicon-user'></span> ".$_SESSION['UId']."</a>";
								echo "<ul class='dropdown-menu'>";
								echo "<li><a href='#'>個人頁面</a></li>";
								echo "<li><a href='#'>設定</a></li>";
								echo "<li><a href='#'>Action</a></li>";
								echo "<li><a href='#'>Action</a></li>";
								if(isset($_SESSION['Utype']) && $_SESSION['Utype']=='superuser'){
									echo "<li role='separator' class='divider'></li>";
									echo "<li><a href='/JustTalk/TheManBehind'>後臺管理</a></li>";
									echo "<li><a href='/JustTalk/ShowManageList'>看板管理</a></li>";
								}else if(isset($_SESSION['Utype']) && $_SESSION['Utype']=='bm'){
									echo "<li role='separator' class='divider'></li>";
									echo "<li><a href='/JustTalk/ShowManageList'>看板管理</a></li>";
								}
								echo "</ul>";
							echo "</li>";
							echo "<li data-toggle='modal' data-target='#Modals' data-togo='登出' id='LogoutBtn'><a href='#' ><span class='glyphicon glyphicon-log-out'></span> 登出 </a></li>";
						}else{
							echo "<li data-toggle='modal' data-target='#Modals' data-togo='登入' id='LoginBtn'><a href='#Modals' ><span class='glyphicon glyphicon-log-in'></span> 登入 </a></li>";
							echo "<li data-toggle='modal' data-target='#Modals' data-togo='註冊' id='registBtn'><a href='#'><span class='glyphicon glyphicon-pencil' ></span> 註冊 </a></li>";
						}
					?>
					
				</ul>
				</div>
			<?php if(isset($tab)){?>
				<div class="row subnav">
					<ul class="nav nav-tabs ">
						<?php echo ($tab==1)?("<li role='presentation' class='active'><a href='/JustTalk/BoardList'>看板列表</a></li>"):("<li role='presentation'><a href='/JustTalk/BoardList'>看板列表</a></li>")?>
						<?php echo (isset($_SESSION['Bname'])?(($tab==2)?("<li role='presentation' class='active'><a href='/JustTalk/PostList?Bid=".$Bid."'>".$_SESSION['Bname']."</a></li>"):""):"")?>
						<?php echo (isset($Bid))?("<li role='presentation' class='navbar-right'><a href='/JustTalk/GoPost?Bid=".$Bid."'>發表文章</a></li>"):""?>
						<li class='disabled'><a href='#'>備用1</a></li>
						<li class='disabled'><a href='#'>備用2</a></li>
					</ul>	
				</div>
				<?php }?>
			</div>
			
		</div>	
	</nav>
	<!--登入pop modal begin-->
	<div class="modal fade bs-example-modal-sm" id="Modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">登入</h4>
				</div>
				<div class="modal-body">
					<form id="form1" style="display:none;">
						<div class="form-group">
							<label  class="control-label">帳號:</label>
							<input type="text" class="form-control" id="UId">
						</div>
						
						<div class="form-group">
							<label  class="control-label" id="test">密碼:</label>
							<input type="password" class="form-control" id="UPd">
						</div>
						
						<div class="checkbox">
							<label>
							<input type="checkbox" id="NotAtHome">這是公開電腦,不需保留登入資訊
							</label>
						</div>
					</form>
					<form id="form2" style="display:none;">
						<div class='form-group'>
							<label  class='control-label'>請輸入E-Mail:</label>
							<input type='email' class='form-control' id='UMail' placeholder='xxxx@mail.com' required>
						</div>
					</form>
					
					<p id="logoutmsg">確定要登出嗎?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="GoBtn">確定</button>
				</div>
			</div>
		</div>		
	</div>
	<!--登入pop modal end-->
	<br><br><br><br><br><br>
	

<script>

	var title;
	
	/*swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this imaginary file!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			swal("Poof! Your imaginary file has been deleted!", {
			  icon: "success", 
			});
		  } else {
			swal("Your imaginary file is safe!"); 
		  }
		});*/
		
		/*swal({
		  text: 'Search for a movie. e.g. "La La Land".',
		  content: "input",
		  button: {
			text: "Search!",
			closeModal: false,
		  },
		})
		.then(name => {
		  if (!name) throw null;
		 
		  return fetch(`https://itunes.apple.com/search?term=${name}&entity=movie`);
		})
		.then(results => {
		  return results.json();
		})
		.then(json => {
		  const movie = json.results[0];
		 
		  if (!movie) {
			return swal("No movie was found!");
		  }
		 
		  const name = movie.trackName;
		  const imageURL = movie.artworkUrl100;
		 
		  swal({
			title: "Top result:",
			text: name,
			icon: imageURL,
		  });
		})
		.catch(err => {
		  if (err) {
			swal("Oh noes!", "The AJAX request failed!", "error");
		  } else {
			swal.stopLoading();
			swal.close();
		  }
		});
		*/
	$('#Modals').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		title = button.data('togo'); // Extract info from data-* attributes
				
		var modal = $(this);
		
		modal.find('.modal-title').text(title);
		if(button[0].id=='LogoutBtn'){
			$('#logoutmsg').show();	
			$('#form1').hide();
			$('#form2').hide();
			
		}else if(button[0].id=='registBtn'){
			$('#logoutmsg').hide();	
			$('#form1').hide();
			$('#form2').show();
		}else if(button[0].id=='LoginBtn'){
			$('#logoutmsg').hide();	
			$('#form2').hide();
			$('#form1').show();
			
		} 
		//modal.find('.modal-body input').val(title)
	});
	
	$('#GoBtn').on('click',function(){
		
		switch(title){
			case '登出':
				logout();
				break;
			case '登入':
				login();
				break;
			case '註冊':
				regist();
				break;				
		}
	});
	
	function regist(){
		var UMail=$('#UMail').val();
		if(!UMail){
			alert("信箱不能為空白!");
			return false;
		}
		$.ajax({
			url:"/JustTalk/PreRegist",
			type:"POST",
            data:'UMail='+UMail,
            cache: false,
			dataType: 'json',
			success:function(data){
				alert(data.msg);
				if(data.success){
					window.location.reload();
				}else{
					return false;
				}
				},error:function(XMLHttpRequest,ajaxOption,err){
				alert("錯誤!");
				document.write(XMLHttpRequest.responseText)	;				
				}
			
		});
	}	
	
	function login(){
		var UId=$('#UId').val();
		var UPd=$('#UPd').val();
		
		if(!UId || !UPd ){
			alert("1帳號密碼不能為空白!");
			return false;
		}
		$.ajax({
			url:"/JustTalk/LoginCheck",
			type:"POST",
            data:{UId:UId,UPd:UPd},
            cache: false,
			dataType: 'json',
			success:function(data){
				alert(data.msg);
				if(data.success){
					window.location.reload();
				}else{
					return false;
				}
				},error:function(XMLHttpRequest,ajaxOption,err){
				alert("錯誤!");
				document.write(XMLHttpRequest.responseText)	;				
				}
			
		});	
		
	}
	
	function logout(){
		$.ajax({
			url:"/JustTalk/LogOut",
			type:"POST",
            //data:{UId:UId,UPd:UPd},
            cache: false,
			dataType: 'json',
			success:function(data){
				alert(data.msg);
				if(data.success){
					window.location.reload();
				}else{
					return false;
				}
				},error:function(XMLHttpRequest,ajaxOption,err){
				alert("錯誤!");
				document.write(XMLHttpRequest.responseText)	;				
				}
			
		});	
		
	}
	
	</script>
	<!--<script id="_waudvn">var _wau = _wau || []; _wau.push(["classic", "ygfhlfvfs3qs", "dvn"]);
	(function() {var s=document.createElement("script"); s.async=true;
	s.src="//widgets.amung.us/classic.js";
	document.getElementsByTagName("head")[0].appendChild(s);
	})();</script>-->

	