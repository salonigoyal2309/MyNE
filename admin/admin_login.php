<?php
	require('connect.php');
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	date_default_timezone_set('Asia/Calcutta');
	$pass_error="";
	if(isset($_POST['login'])){
		$error=false;
		$password=test_input($_POST['password']);
		
		//form-validation
		if(empty($password))$error=true;
		if(empty($password))$pass_error="Password required";
		//form-validation ends here
		
		//Procedure for login
		if(!$error){
			$search_qry="SELECT * FROM adminpass WHERE password='".$password."';";
			$execute=mysqli_query($link, $search_qry);
			$num=mysqli_num_rows($execute);
			$result=mysqli_fetch_array($execute);
			if($result)
			{
				$_SESSION['check']=1;
				echo '<script>alert("Welcome");window.location.href="admin_pendingorders.php";</script>';
			}
		//Search completed
			else{
				$error=true;
				echo "<script>alert('Invalid password.....');</script>";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/login_style.css">
	</head>
<body>


	<div class="login-page">
	  <div class="form">
		<form class="login-form" method="post">
		  <input type="password" placeholder="Enter password" name="password" value="<?php if(isset($_POST['login']))if($error)echo $password;?>">
			<span class="serror"><?php echo $pass_error;?></span>
		  <br>
		  <button type="submit" name="login">LOGIN</button>
		</form>
	  </div>
	</div>
</body>
</html>