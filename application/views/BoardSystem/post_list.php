

<div class="container">

<ul class="nav nav-pills navbar-toggle collapsed nav-justified pills-trigger" data-toggle="collapse" data-target="#pills" aria-expanded="false">
	<li role="presentation" class="active"><a href="#">選擇子版</a></li>
	
</ul>

<div class="navbar-collapse collapse" id="pills">
<ul class="nav nav-pills nav-justified">
	<?php 
		echo "<li role='presentation' class='active'><a href='#'>全部主題</a></li>";
		$countpills=1;
		foreach($subboard as $subboards){
			echo "<li role='presentation'><a href='#'>".$subboards['subboardName']."</a></li>";
			$countpills++;
			if($countpills==5){
				echo "</ul>";
				echo "<ul class='nav nav-pills nav-justified'>";
				$countpills=0;
			}
		}
	?>



</ul>
</div>
	<div class="table-responsive">
		<table name='show_forum'  width=100% class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>子版</th>
					<th>文章標題</th>
					<th>推</th>
					<th>回復/人氣</th>
					<th>最後發表</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($record as $records):?>
				<tr>
					<td><?php echo $records['subboard']?></td>
					<td><a href='/JustTalk/PostView?Bid=<?php echo $records['Bid']."&Aid=".$records['Aid']?>'><?php echo $records['title']?></a></td>
					<td>null</td>
					<td><?php  echo ($records['COUNT(*)']-1).'/';?></td>
					<td><?php echo $records['writer']." ".$records['write_time']?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>