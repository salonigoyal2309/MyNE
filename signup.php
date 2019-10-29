<?php
	require('connect.php');
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	date_default_timezone_set('Asia/Calcutta');
	if(isset($_SESSION['username'])){
		echo '<script>window.location.href="home.php";</script>';
	}
	$user_error=""; $pass_error=""; $repass_error=""; $email_error="";
	if(isset($_POST['register'])){
		$error=false;
		$username=test_input($_POST['username']);
		$email=test_input($_POST['email']);
		$password=test_input($_POST['password']);
		$repassword=test_input($_POST['repassword']);
		//form-validation
		if(empty($username)||empty($password)||empty($repassword)||empty($email)||($password!==$repassword))$error=true;
		if(empty($username))$user_error="Username required";
		if(empty($email))$email_error="Email required";
		if(empty($password))$pass_error="Password required";
		else{
			$passExp='/^[a-zA-Z0-9\#\$\&\@]+$/';
			if(!preg_match($passExp,$password))
			{
				$pass_error="Password can have only #, $, &, @ special characters";
				$error=true;
			}
		}
		if(empty($repassword))$repass_error="Password required";
		else if($password!==$repassword)$repass_error="Passwords should be same";
		//form-validation ends here
		
		//Searching for username
		if(!$error){
			$search_qry="SELECT * FROM user_account WHERE email='".$email."'";
			$execute=mysqli_query($link, $search_qry);
			$num=mysqli_num_rows($execute);
			if($num>0)
			{
				echo "<script>alert('Email address already registered');</script>;";
				$error=true;
			}
			//Search completed
			else{
				$insert_qry="INSERT INTO user_account(username, email, password) values('".$username."', '".$email."', '".$password."');";
				if(mysqli_query($link, $insert_qry)){
					echo "<script>alert('Account created...Redirecting to login page......');window.location.href='login.php'</script>";
				}
				else{
					echo "<script>alert('ERROR!!!');</script>";
				}
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
    <form class="register-form" method="post">
      <input type="text" placeholder="username" name="username" value="<?php if(isset($_POST['register']))if($error)echo $username;?>">
	  <span class="serror"><?php echo $user_error;?></span>
	  <input type="text" placeholder="email address" name="email" value="<?php if(isset($_POST['register']))if($error)echo $email;?>">
	  <span class="serror"><?php echo $email_error;?></span>
	  <input type="password" placeholder="password" name="password" value="<?php if(isset($_POST['register']))if($error)echo $password;?>">
	  <span class="serror"><?php echo $pass_error;?></span>
	  <input type="password" placeholder="Re-Enter password" name="repassword">
	  <span class="serror"><?php echo $repass_error;?></span>
      <button type="submit" class="btn btn-danger" name="register">REGISTER</button>
      <p class="message">Already registered? <a href="login.php">Login</a></p>
    </form>
  </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="assets/js/index.js"></script>

<!-----------------------------------------------------------------------------------------------------------
	<div class="container">
		<div class="row">
			<h1>SIGNUP PAGE</h1>
		</div>
			<div class="row">
				<div class="container">
				<form class="form-horizontal col-md-8" method="post">
					<div class="form-group">
						<label class="control-label col-sm-2 col-md-2">USERNAME</label>
						<div class="col-md-10 col-sm-10">
							<input type="text" class="form-control" name="username" value="<?php if(isset($_POST['register']))if($error)echo $username;?>">
						</div>
						<span class="serror"><?php echo $user_error;?></span>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2 col-md-2">EMAIL</label>
						<div class="col-md-10 col-sm-10">
							<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['register']))if($error)echo $email;?>">
						</div>
						<span class="serror"><?php echo $email_error;?></span>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2 col-md-2">PASSWORD</label>
						<div class="col-md-10 col-sm-10">
							<input type="password" class="form-control" name="password" value="<?php if(isset($_POST['register']))if($error)echo $password;?>">
						</div>
						<span class="serror"><?php echo $pass_error;?></span>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2 col-md-2">RE-ENTER PASSWORD</label>
						<div class="col-md-10 col-sm-10">
							<input type="password" class="form-control" name="repassword">
						</div>
						<span class="serror"><?php echo $repass_error;?></span>
					</div>
					<div class="form-group">
						<label><a href="login.php">Already have an account?</a></label>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-sm-offset-2">
							<input type="submit" class="btn btn-danger" name="register">
						</div>
					</div>
				</form>
				</div>
			</div>
	</div>
	--->
</html>