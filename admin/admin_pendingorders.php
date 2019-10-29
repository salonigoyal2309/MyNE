<?php
	require('header.php');
	if(!isset($_SESSION['check'])){
		header('location:admin_logout.php');
	}
	$tblcolor = array("success", "danger", "active", "info", "warning");
	$tbi=0;
	$selectqry = "SELECT o.orderid, o.receipt, o.userid, o.tt_complete, o.order_time, o.price, u.username from orders o INNER JOIN user_account u on o.userid = u.email order by o.orderid";
	$execute = mysqli_query($link, $selectqry);
	$num= mysqli_num_rows($execute);
	
	$exe1 = mysqli_query($link, $selectqry);
	$res1 = mysqli_fetch_array($exe1);
	$abc = strtotime($res1['order_time']);
?>
<script>
function reloadFunc(){
	location.reload(true);
}
function calcTimer(var1, var2, var3){
	var tt_make = document.getElementById(var1).textContent;
	if(tt_make!=0){
	var nowDateObj = new Date();
	
	var newTime = nowDateObj.getTime() + tt_make*1000;
	var x = setInterval(function() {

  // Get todays date and time
	var now = new Date();
	var distance = newTime - now.getTime();
	var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	if(hours<10)hours="0"+hours;
	if(minutes<10)minutes="0"+minutes;
	if(seconds<10)seconds="0"+seconds;
  document.getElementById(var2).innerHTML = hours + " : " + minutes + " : " + seconds;
  if (distance < 0) {
    clearInterval(x);
    document.getElementById(var2).innerHTML = "ORDER READY";
	document.getElementById(var3).innerHTML = "Print";
  }
}, 1000);
	}
	else{
		document.getElementById(var2).innerHTML = "ORDER READY";
		document.getElementById(var3).innerHTML = "Print";
	}
}
</script>
<body>
<div class="container">
	<div class="row">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<h3><center><b>LIST OF PENDING ORDERS</b></center></h3>
				<tr class="<?php echo $tblcolor[$tbi]; $tbi=($tbi+1)%5; ?>">
					<th>ORDERID</th>
					<th>USERNAME</th>
					<th>USERID</th>
					<th>PRICE</th>
					<th>TIME</th>
					<th>TIME LEFT</th>
					<th>Print Receipt</th>
				</tr>
				<?php
					$cum_sum = 0;
					$order = 0; $tt_make = 0;
					if($num>0){
						while($result=mysqli_fetch_array($execute)){
				?>
				<?php
							$orderi = strtotime($result['order_time']);
							if($cum_sum + $abc <= $orderi){
								$cum_sum = $result['tt_complete']*60;
								$order = $orderi;
								//change
								$abc = $orderi;
								//change
							}
							else{
								$cum_sum +=  $result['tt_complete']*60;
							}
							$currtime = strtotime(date('Y-m-d h:i:sa'));
							if($currtime - $order <= $cum_sum){
								$tt_make = $cum_sum - $currtime + $order;
							}
							if($result['receipt']=='0'){
				?>
				<tr class="<?php echo $tblcolor[$tbi]; $tbi=($tbi+1)%5; ?>">
					<td><?php echo $result['orderid']; ?></td>
					<td><?php echo $result['username']; ?></td>
					<td><?php echo $result['userid']; ?></td>
					<td><?php echo $result['price']; ?></td>
					<td><?php echo($result['tt_complete']); ?></td>
					<td>
						<p id=<?php echo "'time".$result['orderid']."'"; ?>>
						</p>
					</td>
					<td style="display:none;"><p id=<?php echo "'tt".$result['orderid']."'";?>><?php if($result['tt_complete']!=0)echo $tt_make; else echo "0";?></p></td>
					<td><a href = "printReceipt.php?id=<?php echo $result['orderid'];?>" target="_blank" onclick="reloadFunc()"><p id="<?php echo "receipt_".$result['orderid'];?>"></p></a></td>
					<script>
						calcTimer('<?php echo('tt'.$result['orderid']); ?>', '<?php echo('time'.$result['orderid']); ?>', '<?php echo ('receipt_'.$result['orderid']); ?>');
					</script>
				</tr>
				<?php
							}
						}
					}
				?>
			</table>
		</div>
	</div>
</div>
</body>