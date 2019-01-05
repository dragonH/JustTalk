

<script>
	$(document).ready(function(){
		//$('.div1').hide();
		$('.diva').on("click",function(){
		//$('.div1').show();
		
		$(this).after("<div ><img src='"+$(this).attr("id")+"'class='xx' width='480' height='360' ></img></div>");
		$(this).hide();
		
		
		});
	});	
</script>

<?php
//$pvMain='123';
$re = '/((?:https?:|www\.)[^\s]+(jpg|png))/';
$str=$pvMain;
preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

//$test=array();
if(count(($matches))>0){
	for($i=0;$i<count(($matches));$i++){
		$test[$i]=$matches[$i][0];
		
		//console.log($test);
		//$replace="<div ><img src='".$matches[$i][0]."'class='xx' width='240' height='240' ></img></div>";
		$replace="<a  href='#' class='diva' id='".$test[$i]."'>點我打開圖片</a>";
		$pattern=$matches[$i][0];
		//$pattern="這是第一行";
		//echo $matches[0][0]."<br>";
		$cc=preg_replace('~'.$pattern.'~', $replace, $str);
	}
}else{
	$cc=$str;
}

?>

<center><table name="article_main" width=50% class="table table-bordered table-striped table-hover">
	
	<tr>
		<td><center><?php echo $pvTitle?></td>
	</tr>
	<tr>
		<td><center>作者</td>
	</tr>
	<tr>
		<td><?php echo $cc?></td>
	</tr>
	<tr>
		<td><center>發布時間：<?php echo date("H:i:s")?></td>
	</tr>
	<tr>
		<td><input type="button" onclick="notifyMe();" value="test"></td>
	</tr>
	
</table>
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
});

function notifyMe() {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.'); 
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    var notification = new Notification('Notification title', {
      icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
      body: "Hey there! You've been notified!",
	  
    });

    notification.onclick = function () {
      window.open("http://stackoverflow.com/a/13328397/1269037");      
    };
    
  }

}

</script>