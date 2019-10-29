<?php
	require('header.php');
	if(!isset($_SESSION['check'])){
		header('location:admin_logout.php');
	}
	if(isset($_GET['id'])){
		$item_code = $_GET['id'];
	}
	$qry = "SELECT * from items where item_code = $item_code";
	$exe = mysqli_query($link, $qry);
	$result = mysqli_fetch_array($exe);
	$itemname_error=""; $price_error=""; $ttmake_error="";
	if(isset($_POST['update'])){
		$error=false;
		$item_code = test_input($result['item_code']);
		$item_name = test_input($_POST['item_name']);
		$tt_make = test_input($_POST['tt_make']);
		$price = test_input($_POST['price']);
		if(empty($item_name)||empty($price)||$tt_make=="" || $tt_make < 0 || $price <= 0)$error=true;
		if(empty($item_name))$itemname_error = "Field Required";
		if(empty($price))$price_error = "Field Required";
		if($price <= 0)  $price_error="price should be a positive integer";
		if($tt_make=="")$ttmake_error = "Field Required";
		if($tt_make < 0)  $ttmake_error="Time To Make Can Not Be negative";
		if($item_name!=$result['item_name']){
			$search_qry="SELECT * FROM items WHERE item_name='".$item_name."'";
			$exe1=mysqli_query($link, $search_qry);
			$num1=mysqli_num_rows($exe1);
			if($num1>0)
			{
				echo "<script>alert('Item with this name already present');</script>;";
				$error=true;
			}
		}
		$updqry = "UPDATE items SET item_name = '$item_name', price = $price, tt_make = $tt_make WHERE item_code = $item_code";
		if(!$error){
			if(mysqli_query($link, $updqry))
			{
				echo "<script>alert('Item updated'); window.location.href = 'admin_modify.php';</script>";
			}
			else{
				$error=true;
				echo "<script>alert('Error while updating current item');</script>";
			}
		}
	}
	if(isset($_POST['delete'])){
		$error=false;
		$delqry = "DELETE from items where item_code = $item_code";
		if(mysqli_query($link, $delqry)){
			echo "<script>alert('Item deleted'); window.location.href = 'admin_modfiy.php';</script>";
		}
		else{
			echo "<script>alert('Error while deleting item');</script>;";
		}
	}
?>
<!--<a href="admin_changepass.php">CHANGE PASSWORD</a>
<a href="logout.php">SIGN OUT</a>-->
<div class = "container">
	<div class="row">
		<h3><center><b>Update or Delete</b></center></h3>
		<form method="post">
			<div class="form-group">
				<label class="control-label col-sm-2 col-md-2">ITEM CODE</label>
				<div class="col-md-10 col-sm-10">
					<input type="text" class="form-control" name="item_code" disabled="disabled" value="<?php echo $result['item_code'];?>">
				</div>
				<br><br>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2 col-md-2">ITEM NAME</label>
				<div class="col-md-10 col-sm-10">
					<input type="text" class="form-control" name="item_name" value="<?php 
					if(isset($_POST['update']))
					{if($error)echo $item_name;}
					else echo $result['item_name'];?>">
				</div>
				<br><br>
				<span class="serror"><?php echo $itemname_error;?></span>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2 col-md-2">PRICE</label>
				<div class="col-md-10 col-sm-10">
					<input type="text" class="form-control" name="price" value="<?php 
					if(isset($_POST['update']))
					{if($error)echo $price;}
					else echo $result['price'];?>">
				</div>
				<br><br>
				<span class="serror"><?php echo $price_error;?></span>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2 col-md-2">TIME TO MAKE</label>
				<div class="col-md-10 col-sm-10">
					<input type="text" class="form-control" name="tt_make" value="<?php 
					if(isset($_POST['update']))
					{if($error)echo $tt_make;}
					else echo $result['tt_make'];?>">
				</div>
				<br><br>
				<span class="serror"><?php echo $ttmake_error;?></span>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2 col-md-2">AVAILABLITY</label>
				<div class="col-md-10 col-sm-10">
					<input type="checkbox" disabled = "disabled" name="availability" value="<?php echo $result['availability'];?>" <?php if($result['availability']=='1')echo "checked='checked'"; ?>>
				</div>
				<br><br>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2 col-md-2">COUNT</label>
				<div class="col-md-10 col-sm-10">
					<input type="text" class="form-control" disabled="disabled" name="count" value="<?php echo $result['count'];?>">
				</div>
				<br><br>
			</div>
			<center><input type="submit" class="btn" name="update" value="UPDATE">
			<input type="submit" class="btn" name="delete" value="DELETE"></center>
		</form>
	</div>
</div>