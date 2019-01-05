<div class="container">
    <div class="div-addnewboard"align='right'>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalNewBoard">
            <span class="glyphicon glyphicon-plus"></span>
            Add New
        </button>
    </div>
<center><table name="board_list" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th><center>編號</th>
			<th><center>看板圖片</th>
			<th><center>看板名稱</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($record as $records): ?>
	<tr>
		<td><center><button type="button" class="close btndelboard" data-dismiss="modal" aria-label="Close" data-bid=<?php echo $records['Bid']?>><span aria-hidden="true">&times;</span></button><?php echo $count?></td>
		<td><center><div class="picture"><a href='/JustTalk/PostList?Bid=<?php echo $records['Bid']?>'><img src='<?php echo $records['BoardImgUrl']?>' alt="img load fail"  ></img></a></div></td>
		<td><center><a href='/JustTalk/PostList?Bid=<?php echo $records['Bid']?>'><?php echo $records['Bname']?></a></td>
	</tr>
<?php $count++;endforeach?>
	</tbody>
</table>
</div>
<!--NewBoard Modal Strat-->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalNewBoard">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3>新增看板</h3>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label  class="control-label">看板名稱：</label>
					<input type="text" class="form-control" id="NewBoardName">
				</div>
				<div class="form-group">
					<label  class="control-label">版主名稱：</label>
					<input type="text" class="form-control" id="NewBoardMan">
				</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnaddboard">確定</button>
			</div>
		</div>
	</div>
</div>
<!--NewBoard Modal End-->
<script>
	$('.btndelboard').on('click',function(){
		if(confirm('確定要刪除此看板?')){
			var Bid=this.dataset.bid;
			$.ajax({
				url:"/JustTalk/DropBoard",
				type:"POST",
				data:{Bid:Bid},
				dataType:"json",
				success:function(data){
					alert(data.msg);
					window.location.reload()
				},error:function(data){
					alert(data.msg);
				}
			});
		}
		
	});

	$('#btnaddboard').on('click',function(){
		var BName=$('#NewBoardName').val();
		var BMan=$('#NewBoardMan').val();
		$.ajax({
			url:"/JustTalk/NewBoard",
			type:"POST",
			data:{BName:BName,BMan:BMan},
			dataType:'json',
			
			success:function(data){
				alert(data.msg);
				window.location.reload();
			},error:function(data){
				alert(data.msg);
			}
		});
		
	});

</script>