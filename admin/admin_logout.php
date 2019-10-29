<?php
	include('connect.php');
	session_destroy();
	header('LOCATION:admin_login.php');
?>