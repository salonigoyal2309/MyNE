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
<li><a href="index.html">Main Page</a></li>
  <li><a href="home.php">Home</a></li>
  <li><a href="changepass.php">Change Password</a></li>
  <li><a href="myorders.php">My Orders</a></li>
  <li><a href="logout.php">Sign Out</a></li>
  <li style="float:right;"><a>Welcome <?php if(isset($_SESSION['username']))echo $_SESSION['username']; ?></a></li>
  <br>
</ul>