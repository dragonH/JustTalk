<div class="container">
<center><table name="board_list" class="table table-bordered table-striped ">
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
		<td><center><?php echo $count?></td>
		<td><center><div class="picture"><a href='/JustTalk/PostList?Bid=<?php echo $records['Bid']?>'><img src='<?php echo $records['BoardImgUrl']?>' alt="img load fail"  ></img></a></div></td>
		<td><center><a href='/JustTalk/PostList?Bid=<?php echo $records['Bid']?>'><?php echo $records['Bname']?></a></td>
	</tr>
<?php $count++;endforeach?>
	</tbody>
</table>
</div>
<style>
	.picture {
		display:block;width:100%; height:auto;padding:0px;
	}


	
</style>