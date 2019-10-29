<?php
	require('header.php');
	if(!isset($_SESSION['check'])){
		header('location:admin_logout.php');
	}
?>
<a href="admin_changepass.php">CHANGE PASSWORD</a>
<a href="admin_logout.php">SIGN OUT</a><br>
<div>
	<a href = "admin_setitems.php" class="btn btn-primary">SET ITEMS</a><br><br>
	<a href = "admin_modify.php" class="btn btn-primary">MODIFY ITEMS</a><br><br>
	<a href = "admin_pendingorders.php" class="btn btn-primary">PENDING ORDERS</a><br>
	<a href = "admin_placeorder.php" class="btn btn-primary">PLACE ITEMS ORDER</a>
	<a href = "admin_userlist.php" class="btn btn-primary">SHOW USER LIST</a>
</div>