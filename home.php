<?php
	require('header.php');
	if(!isset($_SESSION['username'])){
		header('location:logout.php');
	}
	
	$tblcolor = array("success", "danger", "active", "info", "warning");
	$tbi=0;
	$error = false;
	
	$item_qry = "Select * from items where availability='1' and count>0;";
	$execute = mysqli_query($link, $item_qry);
	$num = mysqli_num_rows($execute);
	
	if(isset($_POST['placeorder'])){
		//Finding order_id
		$findcount="SELECT COUNT(*) AS ordercount FROM orders";
		$exe1=mysqli_query($link, $findcount);
		$res1=mysqli_fetch_array($exe1);
		$order_id=$res1['ordercount'];
		$order_id=$order_id+1;
		//Completed	
		
		//Finding total time to make AND total price
		$tt_make = 0; $price = 0;
		$exe2=mysqli_query($link, $item_qry);
		$no2=mysqli_num_rows($exe2);
		if($no2>0){
			while($res2=mysqli_fetch_array($exe2)){
				$str1=$res2['item_code']."_count";
				$count = test_input($_POST[$str1]);
				if($count==0)continue;
				$tt_make = $tt_make + $count*$res2['tt_make'];
				$price = $price + $count*$res2['price'];
			}
		}
		//Completed
		
		//Entry into order table
		$insert_qry="INSERT INTO orders(orderid, userid, tt_complete, price) VALUES (".$order_id.", '".$_SESSION['email']."', ".$tt_make.", ".$price.")";
		//echo $insert_qry."<br>";
			if(mysqli_query($link, $insert_qry)){
			}
			else{
				echo "<script>alert('ERROR in order entry!!!');</script>";
			}
			//Completed
		
			//Updating count and entry into orderitems table
			$exe=mysqli_query($link, $item_qry);
			$no=mysqli_num_rows($exe);
			if($no>0){
				while($res=mysqli_fetch_array($exe)){
					$str1=$res['item_code']."_count";
					//$str2=$res['item_code']."_check";
					$count=test_input($_POST[$str1]);
					if($count==0)continue;
					$upd_qry="UPDATE items set count=count-".$count." where item_code=".$res['item_code'];
					//echo $upd_qry."<br>";
					mysqli_query($link, $upd_qry);
					$ins_qry="INSERT INTO orderitems(orderid, item_code, item_quantity) VALUES (".$order_id.", ".$res['item_code'].", ".$count.")";
					if(mysqli_query($link, $ins_qry)){
					}
					else{
						echo "<script>alert('ERROR in orderitems entry!!!');</script>";
					}
					//echo $ins_qry."<br><br>";
				}
			}
			echo "<script>alert('ORDER PLACED SUCCESSFULLY'); window.location.href='yourorder.php?id=$order_id'</script>";
		//Completed
	}
?>
<div class = "container">
	<div class="row">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<h3><center><b>LIST OF AVAILABLE ITEMS</b></center></h3>
				<tr class="default">
					<th>NAME</th>
					<th>PRICE</th>
				</tr>
				<?php
					if($num>0){
						while($result=mysqli_fetch_array($execute)){
				?>
				<tr class="<?php echo $tblcolor[$tbi]; $tbi=($tbi+1)%5; ?>">
					<td><?php echo $result['item_name']; ?></td>
					<td><?php echo $result['price']; ?></td>
				</tr>
				<?php
						}
					}
				?>
			</table>
		</div>
	</div>
	<?php $tbi=0; ?>
	<div class="row">
		<form method="post">
			<div class="table-responsive">
			<table class="table table-hover table-bordered">
				<tr class="default">
					<th>NAME</th>
					<th>PRICE</th>
					<th>COUNT AVAILABLE</th>
					<th>NO. OF ITEMS</th>
				</tr>
				<?php
					$item_qry2 = "Select * from items where availability='1' and tt_make!=0 and count>0;";
					$execute = mysqli_query($link, $item_qry2);
					$num = mysqli_num_rows($execute);
					if($num>0){
						while($result=mysqli_fetch_array($execute)){
				?>
				<tr class="<?php echo $tblcolor[$tbi]; $tbi=($tbi+1)%5; ?>">
					<td><?php echo $result['item_name'];?></td>
					<td><?php echo $result['price']; ?></td>
					<td><?php echo $result['count']; ?></td>
					<td><input type="text" class="form-control" name=<?php echo "'".$result['item_code']."_count'"; ?> id=<?php echo "'".$result['item_code']."_countid'"; ?>></td>
				</tr>
				<?php		
						}
					}
				?>
			</table>
			</div>
			<center><input type="submit" class="btn btn-danger" name="placeorder" value="Place Order"></center>
		</form>
	</div>
</div>