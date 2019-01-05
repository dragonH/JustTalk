<style>
	.post_main{
		
		width:50%;
		height:75%;
		margin: auto;
		border: 3px solid green;
		padding: 10px;
	}
	.article_main{
		width: 100%;
		height: 75%;
		
	}	
	
	.form1{
		margin: auto;
		width: 80%;
		height: 75%;
	}
	
	
	
</style>


<div class="post_main">
	
	<form class='form1' border='1' method='post' onsubmit='return check_data();' id='form1' >;
	
	
	<span class="form_title"><h4>發表新文章</h4></span>
		<span><select id="postSubboard" name="postSubboard">
			<option value="subboard_unselect">請選擇子版</option>
			<?php foreach ($record as $records): ?>
				<option value='<?$record['subboardId']?>'><?php echo $record['subboardName']?></option>";
			<?php endforeach?>
		</select>&nbsp
		<select id="postType" name="postType">
			<option value="type_unselect">請選擇類型</option>
			<option value="type_ask">問題</option>
			<option value="type_talk">討論</option>
			<option value="type_news">情報</option>
			<option value="type_share">心得</option>
			<option value="type_other">其他</option> 
		</select><br><br>
		
		<input type="text" placeholder="請輸入標題..." size="70%" id="postTitle" name="postTitle" Required>
		</span><br><br>
		
		<textarea class="article_main" id="postMain" name="postMain"></textarea><br><br>
			<p>
				<lable>驗證碼：</lable>&nbsp&nbsp<?php echo $post_code?>&nbsp&nbsp&nbsp&nbsp
				<lable>請輸入左側驗證碼：</lable><input type="text" id="u_code" size="4" maxlength="4">&nbsp&nbsp&nbsp
				<button type="button" >取消發文</button>&nbsp&nbsp&nbsp
				<button type="button" onclick="preview()">預覽發文</button>&nbsp&nbsp&nbsp
				<button type="submit">發表文章</button>&nbsp&nbsp&nbsp
			</p>		
	</form>
	
</div>
	<form id="form2" method="post"target="_blank" action="/demo0625/pages/view/post_preview">
		<input type="hidden" id="pvTitle" name="pvTitle">
		<input type="hidden" id="pvMain" name="pvMain">
	</form>
<?php
	$sql="select Aid from article where Bid='$Bid'";
	$query=$pdo->query($sql);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	foreach($query as $row);
	echo $row['Aid']+1;
	?>
<script>

	function check_data(){
		var ans="<?php echo $post_code?>";
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
			alert(ans);
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
		
		var form=document.getElementById('form2');
		form.action='/demo0625/pages/view/post_preview?'+(new Date().getTime());
		form.pvTitle.value=$('#postTitle').val();
		form.pvMain.value=$('#postMain').val();
		form.submit();
	}
	
	function do_post(){
		var formdata=new FormData();
		formdata.append("postTitle",$('#postTitle').val());
		formdata.append("postSubboard",$('#postSubboard').val());
		formdata.append("postType",$('#postType').val());
		formdata.append("postMain",$('#postMain').val());
		alert(formdata.get('postMain'));
		
		$.ajax({
				url:"/demo0625/pages/view/goPost?Bid=<?php echo $Bid?>",
                type:"POST",
                data:formdata,
                processData:false,
                contentType:false,
				//timeout:"2000",
                success:function(data){
					alert("成功");
					//alert(data);
					window.location.replace("/demo0625/pages/view/article_list?Bid=<?php echo $Bid?>");
                },error:function(XMLHttpRequest,ajaxOption,err){
					//console.log(xhr.status);
					//console.log(xhr.responseText);
					//alert(err.Message);
					alert("發文失敗!");
					//return false;
					
					alert(XMLHttpRequest.readyState +"\n"+ XMLHttpRequest.status +"\n"+ XMLHttpRequest.responseText);  
				}
			
			
			
			
			
		});
		//alert(form.get('postTitle'));
		
	}
	
	
		
		
	</script>