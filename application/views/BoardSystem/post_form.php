<div class="container">
	<div class="row">
		<div class="col-sm-2"></div>	
		<div class="col-sm-8">
			<form class='post-form' border='1' method='post' onsubmit='return check_data();'>
				<div class="form-group">
					<div class="row">
						<label class="control-lable">發表新文章</label>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<select id="postSubboard" name="postSubboard" class="form-control">
								<option value="subboard_unselect">請選擇子版</option>
								<?php foreach ($record as $records): ?>
								<option value='<?php echo $records['subboardId']?>'><?php echo $records['subboardName']?></option>;
								<?php endforeach?>
							</select>
						</div>
						<div class="col-sm-6">
							<select id="postType" name="postType" class="form-control">
								<option value="type_unselect">請選擇類型</option>
								<option value="type_ask">問題</option>
								<option value="type_talk">討論</option>
								<option value="type_news">情報</option>
								<option value="type_share">心得</option>
								<option value="type_other">其他</option> 
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="請輸入標題..." size="10" id="postTitle" name="postTitle" Required>
							</div>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-12">
						<textarea class="form-control"id="postMain" name="postMain" rows="15"></textarea><br><br>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-3">
							<label class="form-control">驗證碼：&nbsp&nbsp<?php echo $postcode?></label>
						</div>
						<div class="col-sm-2"></div>
						<div class="col-sm-7">
							<input type="text" id="u_code" maxlength="4"   class="form-control" placeholder="請輸入驗證碼">
						</div>	
					</div>	
				</div><br>	
				<div class="row">
					<div class="btn-group btn-group-justified" role="group">
					  <div class="btn-group" role="group">
						<button type="button" class="btn btn-default">取消發文</button>
					  </div>
					  <div class="btn-group" role="group">
						<button type="button" class="btn btn-default" onclick="preview()">預覽發文</button>
					  </div>
					  <div class="btn-group" role="group">
						<button type="submit" class="btn btn-default">發表文章</button>
					  </div>
					</div>
				</div>
			</form>
			
		
			<form id="FormPre" method="post" target="_blank" action="/JustTalk/Preview">
				<input type="hidden" id="pvTitle" name="pvTitle" value="">
				<input type="hidden" id="pvMain" name="pvMain" value="">
				
			</form>
			
		</div>
		<div class="col-sm-2"><?php echo $Aid?></div>	
	</div>	
</div>	
<script>

	function check_data(){
		var ans="<?php echo $postcode?>";
		var u_code=document.getElementById('u_code').value;
		if(document.getElementById('postSubboard').value=='subboard_unselect'){
			alert("請選擇子版!");
			return false;
		}
		if(document.getElementById('postType').value=='type_unselect'){
			alert("請選擇類型!");
			return false;
		}
		if(!document.getElementById('postMain').value){
			alert("請輸入文章內容!");
			return false;
		}
		if(!(u_code==ans)){
			//alert(ans);
			alert("驗證碼錯誤!");
			return false;
		}
		if(confirm("確定發布此文嗎?")){
			
			do_post();
			return false;
			
		}else{
			alert("發布失敗!");
			return false;
		}
		
	}
	
	function preview(){
		
		var form=document.getElementById("FormPre");
		
		
		form.action='/JustTalk/Preview?'+(new Date().getTime());
		
		form.pvTitle.value=$('#postTitle').val();
	
		form.pvMain.value=$('#postMain').val();
		//form.target="_blank";
		form.submit();
	}
	
	function do_post(){
		var formdata=new FormData();
		formdata.append("postTitle",$('#postTitle').val());
		formdata.append("postSubboard",$('#postSubboard').val());
		formdata.append("postType",$('#postType').val());
		formdata.append("postMain",$('#postMain').val());
		//alert(formdata.get('postMain'));
		
		$.ajax({
				url:"/JustTalk/DoPost?Bid=<?php echo $Bid?>",
                type:"POST",
                data:formdata,
                processData:false,
                contentType:false,
				//timeout:"2000",
                success:function(data){
					alert("發文成功");
					//alert(data);
					window.location.replace("/JustTalk/PostList?Bid=<?php echo $Bid?>");
                },error:function(XMLHttpRequest,ajaxOption,err){
					//console.log(xhr.status);
					//console.log(xhr.responseText);
					//alert(err.Message);
					alert("發文失敗!");
					
					//return false;
					//alert(XMLHttpRequest.readyState +"\n"+ XMLHttpRequest.status +"\n"+ XMLHttpRequest.responseText); 
					document.write(XMLHttpRequest.responseText)	;				
				}
			
			
			
			
			
		});
		//alert(form.get('postTitle'));
		
	}
	</script>