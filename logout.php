<?php
	include('connect.php');
	session_destroy();
	header('LOCATION:login.php');
?>