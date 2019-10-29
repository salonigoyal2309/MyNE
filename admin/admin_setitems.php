<?php
	require('header.php');
	if(!isset($_SESSION['check'])){
		header('location:admin_logout.php');
	}
	$item_qry = "Select * from items;";
	$execute = mysqli_query($link, $item_qry);
	$num = mysqli_num_rows($execute);
	
	if(isset($_POST['setItems'])){
		$exe=mysqli_query($link, $item_qry);
		$no=mysqli_num_rows($exe);
		if($no>0){
			while($res=mysqli_fetch_array($exe)){
				$str1=$res['item_code']."_count";
				$str2=$res['item_code']."_check";
				$count=test_input($_POST[$str1]);
				$avi = 0;
				if(isset($_POST[$str2]))$avi = $_POST[$str2];
				else $count = 0;
				if($count < 0)$count = 0;
				if($count==0 && $avi = '1')$avi = 0;
				$upd_qry="UPDATE items set count=".$count.", availability ='".$avi."' where item_code=".$res['item_code'];
				//echo $upd_qry."<br>";
				mysqli_query($link, $upd_qry);
				if(mysqli_query($link, $upd_qry)){
					echo "<script>window.location.href='admin_pendingorders.php';</script>";
				}
				else{
					echo "<script>alert('ERROR in items entry!!!');</script>";
				}
			}
		}
		//Completed
	}
?>
<!--<a href="admin_changepass.php">CHANGE PASSWORD</a>
<a href="logout.php">SIGN OUT</a>-->
<div class = "container">
	<div class="row">
		<form method="post">
			<div class="table-responsive">
			<table class="table table-hover table-bordered">
				<h3><center><b>SET ITEMS FOR TODAY</b></center></h3>
				<tr>
					<th>NAME</th>
					<th>PRICE</th>
					<th>NO. OF ITEMS AVAILABLE</th>
					<th>AVAILABILITY</th>
				</tr>
				<?php
					$execute = mysqli_query($link, $item_qry);
					$num = mysqli_num_rows($execute);
					if($num>0){
						while($result=mysqli_fetch_array($execute)){
				?>
				<tr>
					<td><?php echo $result['item_name'];?></td>
					<td><?php echo $result['price']; ?></td>
					<td><input type="text" class="form-control" name=<?php echo "'".$result['item_code']."_count'"; ?> value=<?php echo $result['count']; ?>></td>
					<td><input type="checkbox" class="form-control" name = <?php echo "'".$result['item_code']."_check'"; ?> checked="checked" value="1"></td>
				</tr>
				<?php		
						}
					}
				?>
			</table>
			</div>
			<center><input type="submit" class="btn btn-primary" name="setItems" value="SET ITEMS"></center>
		</form>
	</div>
</div>