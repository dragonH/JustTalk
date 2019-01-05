<div class="container">
   
    <div class="row">
        <div class="btn-group" role="group">
            <?php foreach($Info as $Infos):?>
                <button type="button" class="btn btn-default"><?php echo $Infos['subboardName']?></button>
            <?php endforeach;?><br><br>
        </div>
    </div>
    <div class="row">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="輸入新子版名稱" id="newsubboard">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default" id="btnaddsub"><span class="glyphicon glyphicon-plus"></span></button>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if(isset($ReportedPost)){foreach($ReportedPost as $ReportedPosts):?>
        <p><?=$ReportedPosts['title'] ?></p>
        <?php endforeach;}?>
    </div>
</div>
<script>
   
   $('#btnaddsub').on('click',function(){
        	var Bid='<?php echo $Bid?>';
            var NewSub=$('#newsubboard').val();
            if(!NewSub){
                alert("請輸入子版名稱!");
                return false;
            }
          
			$.ajax({
				url:"/JustTalk/NewSubBoard",
				type:"POST",
				data:{Bid:Bid,NewSub:NewSub},
				dataType:"json",
				success:function(data){
					alert(data.msg);
					window.location.reload()
				},error:function(data){
                    alert(data.msg);
				}
			});
		
		
	});
</script>