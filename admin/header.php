<?php
	require('connect.php');
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	date_default_timezone_set('Asia/Calcutta');
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
<body>

<ul>
<li><a href="admin_pendingorders.php">Home</a></li>
<li><a href="admin_setitems.php">Set Items</a></li>
  <li><a href="admin_modify.php">Modify Items</a></li>
  <li><a href="admin_placeorder.php">Place Item Orders</a></li>
  <li><a href="admin_userlist.php">Show Users List</a></li>
  <li><a href="admin_changepass.php">Change Password</a></li>
  <li><a href="admin_logout.php">Sign Out</a></li>
  <br>
</ul>

	