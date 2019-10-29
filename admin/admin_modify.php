<?php
	require('header.php');
	//if(!isset($_SESSION['check'])){
	//	header('location:admin_logout.php');
	//}
	$item_qry = "Select * from items;";
	$execute = mysqli_query($link, $item_qry);
	$num = mysqli_num_rows($execute);
	if(isset($_POST['proceed'])){
		$itemid = $_POST['itemlist'];
		if($itemid==0){
			echo "<script>alert('Select appropriate item');</script>";
		}
		else{
			echo "<script>window.location.href='admin_upddel.php?id=$itemid'</script>";
		}
	}
	$item_name_error=""; $price_error=""; $tt_make_error=""; $count_error="";
	if(isset($_POST['add_item']))
	{
		$error=false;
		$item_name=test_input($_POST['item_name']);
		$price=test_input($_POST['price']);
		$tt_make=test_input($_POST['tt_make']);
		if(isset($_POST['availability']))
			$availability=test_input($_POST['availability']);  //checkbox
		else
			$availability='0';
		$count=test_input($_POST['count']);
		if(empty($item_name)||empty($price)||empty($tt_make)||empty($count) || $tt_make < 0 || $price <= 0 || $count <= 0)$error=true;
		if(empty($item_name)) $item_name_error="Item name required";
		if(empty($price)) $price_error="Price required";
		if($price <= 0)  $price_error="price should be a positive integer";
		if(empty($tt_make)) $tt_make_error="Time to make required";
		if($tt_make < 0)  $tt_make_error="Time To Make Can Not Be negative";
		if(empty($count)) $count_error="Count required";
		if($count <= 0)  $count_error="count should be a positive integer";
		
		if(!$error)
		{
			$search_qry="SELECT * FROM items WHERE item_name='".$item_name."'";
			$exe1=mysqli_query($link, $search_qry);
			$num1=mysqli_num_rows($exe1);
			if($num1>0)
			{
				echo "<script>alert('Item with this name already present');</script>;";
				$error=true;
			}
			else{
				$insert_qry="INSERT INTO items(item_name, price, tt_make, count, availability) values('".$item_name."', ".$price.", ".$tt_make.", ".$count.", '".$availability."');";
				if(mysqli_query($link, $insert_qry)){
					echo "<script>alert('Item inserted!');window.location.href='admin_modify.php';</script>";
				}
				else{
					echo "<script>alert('ERROR!!!');</script>";
				}
			}
		}
	}
?>
<!--<a href="admin_changepass.php">CHANGE PASSWORD</a>
<a href="logout.php">SIGN OUT</a>-->

<div class = "container">
	<div class="row">
		<br>
		<div class="col-md-8" >
		<center><h1>Add Item</h1></center>
		<br>
			<form class="form-horizontal col-md-11" method="post">
				
				<div class="form-group">
					<label class="control-label col-sm-2 col-md-2">ITEM NAME</label>
					<div class="col-md-10 col-sm-10">
						<input type="text" class="form-control" name="item_name" value="<?php if(isset($_POST['add_item']))if($error)echo $item_name;?>">
					</div>
					<span class="serror"><?php echo $item_name_error;?></span>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-md-2">PRICE</label>
					<div class="col-md-10 col-sm-10">
						<input type="text" class="form-control" name="price" value="<?php if(isset($_POST['add_item']))if($error)echo $price;?>">
					</div>
					<span class="serror"><?php echo $price_error;?></span>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-md-2">TIME TO MAKE</label>
					<div class="col-md-10 col-sm-10">
						<input type="text" class="form-control" name="tt_make" value="<?php if(isset($_POST['add_item']))if($error)echo $tt_make;?>">
					</div>
					<span class="serror"><?php echo $tt_make_error;?></span>
				</div>
				<br>
				<div class="form-group">
					<label class="control-label col-sm-2 col-md-2">AVAILABLITY</label>
					<div class="col-md-10 col-sm-10">
						<input type="checkbox"  name="availability" value="1" checked="checked">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-md-2">COUNT</label>
					<div class="col-md-10 col-sm-10">
						<input type="text" class="form-control" name="count" value="<?php if(isset($_POST['add_item']))if($error)echo $count;?>">
					</div>
					<span class="serror"><?php echo $count_error;?></span>
				</div>
				<input style="float: right;" type="submit" class="btn" name="add_item" value="Add Item">
			</form>
		</div>
		<div class="col-md-4">
			<center><h1>Update or Delete</h1></center>
			<br>
			<form method="post">
				<center>
					<select name="itemlist" >
						<option value="0">----SELECT AN ITEM----</option>
						<?php
							while($result = mysqli_fetch_array($execute)){
						?>
						<option value = <?php echo "'".$result['item_code']."'"; ?>><?php echo $result['item_name']; ?></option>
						<?php
							}
						?>
					</select>
				</center>
				<br><br>
				<center><input type="submit" class="btn" name="proceed" value="PROCEED"></center>
			</form>
		</div>
	</div>
</div>
