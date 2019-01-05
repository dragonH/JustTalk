
<?php
	function commentlogincheck($Pid){
		if(isset($_SESSION['status']) && $_SESSION['status']==1){
			
			//$result="gocomment('".$Pid."');";
			return true;
		}else{
			$result='loginplz();';
			return  $result;
		}
		
	}
	
	function replylogincheck(){
		if(isset($_SESSION['status']) && $_SESSION['status']==1){
			
			$result="Reply();";
		}else{
			$result='loginplz();';
		}
	return  $result;	
	}
	
	function thumblogincheck($Test,$x){
		if(isset($_SESSION['status']) && $_SESSION['status']==1){
			
			$result="thumb(this,".$Test.",".$x.");";
		}else{
			$result='loginplz();';
		}
	return  $result;	
	}
	
	
?>
<?php $now_time=date("Y-m-d")." ".date("H:i:s")?>
<div class="modal fade" id="ModalPostOption" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">.
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="ModalOptionTitle"></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="WhyDel" id="LabelModalTitle"></label>
					<select class="form-control" id="WhyDel">
						<option value="1">與本版主題不符</option>
						<option value="2">內含限制級字眼</option>
						<option value="3">謾罵洗版</option>
						<option value="4">其他原因</option>
					</select>
				</div>
				<div class="form-group" style="display:none" id="DivWhyDelOther">
					<input type="text" class="form-control" placeholder="請輸入緣由..." id="WhyDelOther">
					<input type="hidden" id="HiddenPostId" value="">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" id="BtnModalDo" >送出</button>
				
			</div>
		</div>	
	</div>
</div>
<div class="container">
	<div name='return_list' align='right'>
		<a href='/JustTalk/PostList?Bid=<?php echo $Bid?>'>回到列表</a>
	</div>
<?php $i=1;foreach ($post as $records):{?>
	<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
	<?php if($records['status']!=='del'){?>
		<div class='panel panel-default' id="posts_<?php echo $records['id']?>">
			<div class='panel-heading'>
				<div class="row postrow">
					<h4><?php echo $records['title']?></h4>
				</div><hr>
				<div class="row postrow">
					&nbsp;<button type="button" class="btn btn-default"><?php echo $i."樓"?></button>
					<a href="javascript:void(0)"><?php echo $records['writer']?></a>
					<a href="javascript:void(0)"><?php echo $records['writer']?></a>
				</div><br>
				<div class="row postrow">
					&nbsp;&nbsp;<span><?php echo $records['write_time']?></span>
				</div>
			</div>
			<div class='panel-body' >
				<article style="min-height: 100pt;">
				<?php //echo $records['main']?>
				<?php echo "<h4>".$PostMain[$i-1]."</h4>";?>
				</article><br>
				<?php 
				
			//	echo print_r($ids)."<br>".$records['id']?><br>
				<div class="button-bar" style="display: inline-flex;">
					<?php 
					
					if (!empty($like)){
						$ids = array_column($like, 'Pid');
						if(in_array($records['id'],$ids)){
							foreach($like as $likes){
								if($likes['Pid']==$records['id']){
									if($likes['data']=='1') {
											echo "<div class='gp_group' style='width:100px;'>";
											echo "<button type='button' class='btn btn-default btn-success active' id='thumbup_".$records['id']."' onclick='".thumblogincheck($records['id'],'1')."'><i class='material-icons'>thumb_up</i></button>";
											echo "&nbsp;<a href='#'>-</a>";
											echo "</div>";
											echo "<div class='bp_group' style='width:100px;'>";
											echo "<button type='button' class='btn btn-default' id='thumbdown_".$records['id']."' onclick='".thumblogincheck($records['id'],'2')."'><i class='material-icons'>thumb_down</i></button>";
											echo "&nbsp;<a href='#'>-</a>";
											echo "</div>";
										}else if($likes['data']=='2'){	
											echo "<div class='gp_group' style='width:100px;'>";
											echo "<button type='button' class='btn btn-default ' id='thumbup_".$records['id']."' onclick='".thumblogincheck($records['id'],'1')."'><i class='material-icons'>thumb_up</i></button>";
											echo "&nbsp;<a href='#'>-</a>";
											echo "</div>";
											echo "<div class='bp_group' style='width:100px;'>";
											echo "<button type='button' class='btn btn-default btn-danger active' id='thumbdown_".$records['id']."' onclick='".thumblogincheck($records['id'],'2')."'><i class='material-icons'>thumb_down</i></button>";
											echo "&nbsp;<a href='#'>-</a>";
											echo "</div>";
										}
								}
							}
						}else{
							echo "<div class='gp_group' style='width:100px;'>";
							echo "<button type='button' class='btn btn-default ' id='thumbup_".$records['id']."' onclick='".thumblogincheck($records['id'],'1')."'><i class='material-icons'>thumb_up</i></button>";
							echo "&nbsp;<a href='#'>-</a>";
							echo "</div>";
							echo "<div class='bp_group' style='width:100px;'>";
							echo "<button type='button' class='btn btn-default' id='thumbdown_".$records['id']."' onclick='".thumblogincheck($records['id'],'2')."'><i class='material-icons'>thumb_down</i></button>";
							echo "&nbsp;<a href='#'>-</a>";
							echo "</div>";
						}
						
					}else{
						echo "<div class='gp_group' style='width:100px;'>";
						echo "<button type='button' class='btn btn-default ' id='thumbup_".$records['id']."' onclick='".thumblogincheck($records['id'],'1')."'><i class='material-icons'>thumb_up</i></button>";
						echo "&nbsp;<a href='#'>-</a>";
						echo "</div>";
						echo "<div class='bp_group' style='width:100px;'>";
						echo "<button type='button' class='btn btn-default' id='thumbdown_".$records['id']."' onclick='".thumblogincheck($records['id'],'2')."'><i class='material-icons'>thumb_down</i></button>";
						echo "&nbsp;<a href='#'>-</a>";
						echo "</div>";
					} 
					?>
						<div class="dropdown">
							<button type="button" class="btn btn-default dropdown-toggle btn-lg" id="dropdownMenu1" data-toggle="dropdown">
								<li class="glyphicon glyphicon-th-list"></li>		
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<?php if($IsBM){?>
								<li><a href="#" data-id="<?php  echo $records['id']?>" data-toggle="modal" data-target="#ModalPostOption" data-action="DelPost">刪除</a></li>
							<?php }?>
							<?php if(isset($_SESSION['UId'])){?>
								<li><a href="#" data-id="<?php  echo $records['id']?>" data-toggle="modal" data-target="#ModalPostOption" data-action="ReportPost">檢舉</a></li>
								<li><a href="#">回復</a></li>
							<?php }?>	
								<li role="separator" class="divider"></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</div>
				</div>
			</div>
			<div class='panel-footer'>
				<div class="comments_<?php echo $records['id']?>">
				<?php foreach ($comment as $comments):if($records['id']==$comments['Pid'])?>
					
						<?php if($records['id']==$comments['Pid']){
							echo "<div class='row' id='comment_list'>";
							echo "<div class='col-sm-1'>";
							echo "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Antu_im-invisible-user.svg/2000px-Antu_im-invisible-user.svg.png' alt='...' class='img-circle user-img' width='40px' height='40px'></div>";
							echo "<div class='col-sm-11' id='comment_main'>";
							echo "<div class='row'>";
							echo "<a href='#'>".$comments['writer']."</a>";
							echo "<article style='display:inline;'>：&nbsp;".$comments['Comment']."</article>";
							echo "</div>";
							echo "<div class='row' id='time'><h6 style='display:inline;'>&nbsp;".$comments['write_time']."</h6></div>";
							echo "</div>";
							echo "</div><hr class='comment-hr'>";
						}?>	
						
					
				<?php  endforeach?>	
				</div>
				<div class="row">
					<div class="col-sm-1">
						<?php echo "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Antu_im-invisible-user.svg/2000px-Antu_im-invisible-user.svg.png' alt='...' class='img-circle user-img' width='40px' height='40px'>";?>
					</div>
					<div class="col-sm-11">
						<div class="row" id="commentEdit">
							<textarea class="commentarea" placeholder="按此輸入留言..." id="commentEdit_<?php echo $records['id']?>"  style="width:100%;height:100%;resize:none;overflow:hidden" maxlength="80" data-id="<?php echo $records['id']?>" onclick="<?php echo commentlogincheck($records['id']);?>"></textarea>
						</div>							

					</div>	
				</div>
			</div>
		</div>	
	<?php }else{?>
		<div class='panel panel-default' id="posts_<?php echo $records['id']?>">
			<div class='panel-heading'>
				<?php echo "【已刪除】 ".$records['whodel']."：".$records['whydel']?>
			</div>
		</div>

	<?php }?>
	</div>
	<div class="col-sm-2"></div>	
	</div>
	<?php $i++; }endforeach?>
	
	
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<div class='panel panel-default' id="ReplyEdit">
			<div class='panel-heading'>
				<h5>回復</h5>
			</div>
			<div class='panel-body'>
				<textarea class="form-control" placeholder="快來回復搶 <?php echo $i?> 樓吧!" style="min-height: 100pt;" id="ReplyMain"></textarea>
			</div>	
			<div class='panel-footer'>
				<div class="form-group text-right">
					<button type="button" class="btn btn-default" id="replybtn"onclick="<?php echo replylogincheck();?>">送出</button>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>

<script>


	function loginplz(){
		alert("請先登入再進行留言或回覆!");
		
		document.location.href="./LoginPage";
	}
	
	$('.commentarea').on('keypress',function(e){
		var idd=this.id;
		var Pid=this.attributes[5].value;
		if(e.which == 13){
			if(this.value!=''){
				
				Comment(Pid);
				console.log('done');
			}
			return false;
		}
	
	});

	function gocomment(Pid){
	$('#commentEdit').on( 'change keyup keydown paste cut', 'textarea', function (){
    $(this).height(0).height(this.scrollHeight);
	}).find( 'textarea' ).change();
	}

	$('#ModalPostOption').on('show.bs.modal',function(e){
		var PostId=$(e.relatedTarget).data('id');
		$('#HiddenPostId').val(PostId);
		switch($(e.relatedTarget).data('action')){
			case 'DelPost':{
				$('#ModalOptionTitle').text("刪除貼文");
				$('#LabelModalTitle').text("請選擇刪文緣由：");
				$('#BtnModalDo').data("action", "DelPost");
				break;
			}
			case 'ReportPost':{
				$('#ModalOptionTitle').text("檢舉貼文");
				$('#LabelModalTitle').text("請選擇檢舉緣由：");
				$('#BtnModalDo').data('action','ReportPost');
				
				break;
			}
		}
		
		
		//console.log($('#BtnDelPost').data('id'));
	});

	$('#WhyDel').on('change',function(){
		var val=$(this).val();
		if(val=='4'){
			$('#DivWhyDelOther').show();
		}else{
			$('#DivWhyDelOther').hide();
		}
	});

	$('#BtnModalDo').on('click',function(){
		var WhyDel=$('#WhyDel').val();
		var PostId=$('#HiddenPostId').val();
		if(WhyDel=='4'){
			var WhyDel=$('#WhyDelOther').val();
			!WhyDel?alert("請輸入緣由!"):"";
		}
		switch($('#BtnModalDo').data('action')){
			case 'DelPost':{
				DelPost(WhyDel,PostId);
				break;
			}
			case 'ReportPost':{
				let WhyReport=WhyDel;
				ReportPost(WhyReport,PostId);
				break;
			}
		}
			
				
	});

	function DelPost(WhyDel,PostId){
		
		$.ajax({
				url:"/JustTalk/DropPost?Bid=<?=$records['Bid']?>",
				type:"POST",
				data:{PostId:PostId,WhyDel:WhyDel},
				dataType:"json",
				success:function(data){
					alert(data.msg);
				
					window.location.reload()
				},error:function(data){
					alert(data.msg);
					
									
				}
			});
	}
	
	function ReportPost(WhyReport,PostId){
		
		$.ajax({
				url:"/JustTalk/ReportPost?Bid=<?=$records['Bid']?>",
				type:"POST",
				data:{PostId:PostId,WhyReport:WhyReport},
				dataType:"json",
				success:function(data){
					//alert(data.msg);
					console.log(data);
					//window.location.reload()
				},error:function(data){
					//alert(data.msg);
					console.log(data);
									
				}
			});
	//console.log(PostId+" ： "+WhyDel);
	}
	
	
		
	
	function Comment(Pid){
		var comment=$('#commentEdit_'+Pid).val();
	
		$.ajax({
				url:"/JustTalk/GoComment?<?php echo 'Bid='.$Bid.'&Aid='.$Aid?>",
				type:"POST",
				data:{Pid:Pid,comment:comment},
				cache: false,
				dataType: 'json',
				success:function(data){
		
					$('.comments_'+Pid).append(
					"<div class='row'>"+
						"<div class='col-sm-1'>"+
							"<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Antu_im-invisible-user.svg/2000px-Antu_im-invisible-user.svg.png' alt='...' class='img-circle' height='20px' width='20px'>"+
						"</div>"+
						"<div class='col-sm-11'>"+
							"<div class='row'>"+
								"<a herf='#'><?php  echo (isset($_SESSION['UId']))? $_SESSION['UId']: ''?></a>"+
								"<article  style='display:inline;'>：&nbsp;"+$('#commentEdit_'+Pid).val()+"</article>"+
							"</div>"+
							"<div class='row' id='time'>"+
								"<h6 style='display:inline;'>&nbsp;"+data.write_time+"</h6>"+
							"</div>"+
						"</div>"+
					"</div>");
					$('#commentEdit_'+Pid).val("");
				
				},error:function(XMLHttpRequest,ajaxOption,err){
					alert("錯誤!");
					//document.write(XMLHttpRequest.responseText);				
				}
			});
		
	}

	function Reply(){
		
		var title='<?php echo $title?>';
		var ReplyMain=$('#ReplyMain').val();
		if(ReplyMain!=''){
			if(confirm("確定回復嗎?")){
				$.ajax({
					url:"/JustTalk/EasyReply?<?php echo 'Bid='.$Bid.'&Aid='.$Aid?>",
					type:"POST",
					data:{title:title,ReplyMain:ReplyMain},
					cache: false,
					//dataType: 'json',
					success:function(data){
						alert("回復成功!");
						window.location.reload();
					},error:function(XMLHttpRequest,ajaxOption,err){
						alert("錯誤!");
						//alert(XMLHttpRequest.responseText+err);
						document.write(XMLHttpRequest.responseText);				
					}
				});
			}else{
				return false;
			}
		}else{
			alert("回復內容不得為空!");
			return false;
		}	
	}	
	
	function getCookie(cookieName) {
	  var name = cookieName + "=";
	  var ca = document.cookie.split(';');
	  for(var i=0; i<ca.length; i++) {
		  var c = ca[i];
		  while (c.charAt(0)==' ') c = c.substring(1);
		  if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	  }
	  return "";
	}
	
	function gg(e){
		if(!getCookie("LoginId")){
			alert("未登入!");
		}else{
			thumb(e);
		}
	}
	
	function thumb(e,pid,x){
		
		switch(e.textContent){
			case "thumb_up":
				var down=$('#thumbdown_'+pid);
				if(!down.hasClass("active")){
					if(e.classList.contains("active")){
						//$('#'+e.id).removeClass("active");
						alert("無法收回GP!");
						//$('#'+e.id).removeClass("btn-success");
						//$('#'+e.id).addClass("btn-default");
						
						return false;
					}else{
						$.ajax({
							url:"/JustTalk/Gothumb?<?php echo 'Bid='.$Bid.'&Aid='.$Aid?>",
							type:"POST",
							data:{pid:pid,x:x},
							cache: false,
							//dataType: 'json',
							success:function(data){
								$('#'+e.id).removeClass("btn-default");
								$('#'+e.id).addClass("btn-success");
								$('#'+e.id).addClass("active");
								alert("按讚成功!");
								//window.location.reload();
							},error:function(XMLHttpRequest,ajaxOption,err){
								alert("錯誤!");
								//alert(XMLHttpRequest.responseText+err);
								document.write(XMLHttpRequest.responseText);				
							}
						});
					}
				}else{
					alert("你已經給BP了!");
				}
			break;

			case "thumb_down":
				var up=$('#thumbup_'+pid);
				
				if(!up.hasClass("active")){
					if(e.classList.contains("active")){
						//$('#'+e.id).removeClass("active");
						alert("無法收回BP!");
						//$('#'+e.id).removeClass("btn-danger");
						//$('#'+e.id).addClass("btn-default");
						
						return false;
					}else{
						$.ajax({
							url:"/JustTalk/Gothumb?<?php echo 'Bid='.$Bid.'&Aid='.$Aid?>",
							type:"POST",
							data:{pid:pid,x:x},
							cache: false,
							//dataType: 'json',
							success:function(data){
								$('#'+e.id).removeClass("btn-default");
								$('#'+e.id).addClass("btn-danger");
								$('#'+e.id).addClass("active");
								alert("按爛成功!");
								//window.location.reload();
							},error:function(XMLHttpRequest,ajaxOption,err){
								alert("錯誤!");
								//alert(XMLHttpRequest.responseText+err);
								document.write(XMLHttpRequest.responseText);				
							}
						});
						
						
					}
				}else{
					alert("你已經給GP了!");
				}
			break;			
		}
	}
	
	
	
</script>

