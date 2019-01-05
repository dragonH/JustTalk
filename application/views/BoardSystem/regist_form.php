<div class="container">
	<div =class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<form >
			
				<div class="form-group">
					<label  class="control-label">帳號:</label>
					<input type="text" class="form-control" id="UId">
				</div>
				
				<div class="form-group">
					<label  class="control-label">密碼:</label>
					<input type="password" class="form-control" id="UPdst">
				</div>
				
				<div class="form-group">
					<label  class="control-label">再輸入一次密碼:</label>
					<input type="password" class="form-control" id="UPdnd" onblur="PwdCheck();">
					<p id="msg"></p>
				</div>
				
				<div class="form-group">
					<label  class="control-label">暱稱:</label>
					<input type="text" class="form-control" id="UNick">
				</div>
				<div class="form-group text-right">
					<button type="button" class="btn btn-default">Close</button>
					<button type="button" class="btn btn-primary" id="GoBtn">確定</button>
				</div>
				
			</form>
		</div>
		<div class="col-sm-4">
			<i class="material-icons">face</i>
		</div>
	</div>
</div>
<script>
	function PwdCheck(){
		
		var UPdst=$('#UPdst').val();
		var UPdnd=$('#UPdnd').val();
		if(UPdst==UPdnd){
			//alert("123");
			$('#msg').text('密碼相符');
		}else{
			$('#msg').text('密碼不符');
		}
	}
</script>