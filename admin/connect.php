<?php
	$hostname="localhost";
	$username="root";
	$password="";
	$db="canteen";
	$link=mysqli_connect($hostname, $username, $password, $db) or die('No connection established');
	session_start();
?>