<?php
	require('connect.php');
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	date_default_timezone_set('Asia/Calcutta');
	if(!isset($_SESSION['check'])){
		header('location:admin_logout.php');
	}
	if(isset($_GET['id']))
		$orderid=$_GET['id'];
	
	$updqry = "UPDATE orders set receipt = '1' WHERE orderid = $orderid";
	mysqli_query($link, $updqry);
	
	$qry = "SELECT * from orderitems o NATURAL JOIN items i where o.orderid=$orderid";
	$exe = mysqli_query($link, $qry);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
<body>
<br><br>
<div class="container">
<div class="row">
<table class="table table-responsive table-hover table-bordered">
	<tr class="default">
		<th>ITEM NAME</th>
		<th>QUANTITY</th>
		<th>ITEM TOTAL PRICE</th>
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
?>
	<h3 align="center"><?php echo "PRICE: ₹ ".$total_price;?></h3>
<script>
	window.print();
</script>