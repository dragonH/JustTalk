<div class="container">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<ul class="nav nav-tabs nav-justified" role="tablist" id="mtab">
				<li role="presentation" class="active"><a href="#Login" aria-controls="Login" role="tab" data-toggle="tab">登入</a></li>
				<li role="presentation"><a href="#Regist" aria-controls="Regist" role="tab" data-toggle="tab">註冊</a></li>
			</ul><br>
			
		
		<div class="tab-content" >
			<div role="tabpanel" class="tab-pane fade in active" id="Login">
				<form>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="請輸入帳號" id="fUId" Required><br>
						<input type="password" class="form-control" placeholder="請輸入密碼" id="fUPd"  Required>
					</div><br>
					<div class="btn-group btn-group-justified" role="group">
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default" id="ToRegistBtn">我還沒有帳號</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default" id="fLoginBtn">登入</button>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="Regist">
				<form>
					<div class="form-group">
						<input type="email" class="form-control" placeholder="請輸入E-Main" Required><br>
					</div>
					<div class="btn-group btn-group-justified" role="group">
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-default" id="RegistBtn">確認</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		</div>
		
		<div class="col-sm-4">
			
		</div>
	</div>
</div>
<script>
	$('#ToRegistBtn').on('click',function(){
		$('#mtab a[href="#Regist"]').tab('show');		
	});

	$('#fLoginBtn').on('click',function(){
		
		flogin();
	});

	function flogin(){
		var fUId=$('#fUId').val();
		var fUPd=$('#fUPd').val();
		
		if(!fUId || !fUPd ){
			alert("帳號密碼不能為空白!");
			return false;
		}
		$.ajax({
			url:"/JustTalk/LoginCheck",
			type:"POST",
            data:{UId:fUId,UPd:fUPd},
            cache: false,
			dataType: 'json',
			success:function(data){
				alert(data.msg);
				if(data.success){
					window.location.replace("/JustTalk/BoardList");
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