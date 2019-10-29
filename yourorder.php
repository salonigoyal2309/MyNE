<?php
	require('header.php');
	if(!isset($_SESSION['username'])){
		header('location:logout.php');
	}
	$tblcolor = array("success", "danger", "active", "info", "warning");
	$tbi=0;
	
	if(isset($_GET['id']))
		$orderid=$_GET['id'];
	$qry = "SELECT * from orderitems o NATURAL JOIN items i where o.orderid=$orderid order by o.orderid";
	$exe = mysqli_query($link, $qry);
?>

<br><br>
<div class="container">
<div class="row">
<table class="table table-responsive table-hover table-bordered">
	<h3><center><b>Current Order</b></center></h3>
	<tr class="default">
		<th>Item Name</th>
		<th>Quantity</th>
		<th>Item Total Price</th>
	</tr>
<?php
	$num = mysqli_num_rows($exe);
	$total_price=0; $tt_make=0;
	if($num>0){
		$pr=0;
		while($result=mysqli_fetch_array($exe)){
?>
	<?php //$tt_make +=  ($result['item_quantity']*$result['tt_make']);?>
	<tr class="<?php echo $tblcolor[$tbi]; $tbi=($tbi+1)%5; ?>">
		<td><?php echo $result['item_name']; ?></td>
		<td><?php echo $result['item_quantity']; ?></td>
		<td><?php  $pr = $result['item_quantity']*$result['price']; echo $pr; $total_price += $pr;?></td>
	</tr>
<?php
		}
	}
	$timeqry = "SELECT * from orders where orderid<=$orderid && tt_complete!=0";
	$exe1 = mysqli_query($link, $timeqry);
	$num1 = mysqli_num_rows($exe1);

	$exe2 = mysqli_query($link, $timeqry);
	$res2 = mysqli_fetch_array($exe2);
	$abc = strtotime($res2['order_time']);
	$cum_sum = 0;
	$order = 0; $tt_make = 0;
	if($num1>0){
		while($res1 = mysqli_fetch_array($exe1)){
			$orderi = strtotime($res1['order_time']);
			if($cum_sum + $abc <= $orderi){
				$cum_sum = $res1['tt_complete']*60;
				$order = $orderi;
				//change
				$abc = $orderi;
				//change
			}
			else{
				$cum_sum +=  $res1['tt_complete']*60;
			}
			$currtime = strtotime(date('Y-m-d h:i:sa'));
			if($currtime - $order <= $cum_sum){
				$tt_make = $cum_sum - $currtime + $order;	
			}
		}
	}
?>
</table>
</div>
<div class="row">
	<h4 style="float:right;"><b>Total Price: <?php echo $total_price; ?></b></h4><br><br>
	<p id="tt" style="display: none;"><?php echo $tt_make; ?></p>
	<p id="total_time" style="font-size: 80px; text-align: center;"></p><br><br>
	<p style="text-align: center;"><a href="home.php" class="btn btn-primary">Place new order</a><p>
</div>

</div>
<script>
	var tt_make = document.getElementById("tt").textContent;
	if(tt_make!=0){
	var oid = <?php echo $orderid;?>;
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
  document.getElementById("total_time").innerHTML = hours + " : " + minutes + " : " + seconds;

  if (distance < 0) {
    clearInterval(x);
    document.getElementById("total_time").innerHTML = "ORDER READY";
  }
}, 1000);
	}
	else{
		document.getElementById("total_time").innerHTML = "ORDER READY";
	}
</script>