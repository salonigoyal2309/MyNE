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
	$email_error=""; $pass_error="";;
	if(isset($_POST['login'])){
		$error=false;
		$email=test_input($_POST['email']);
		$password=test_input($_POST['password']);
		
		//form-validation
		if(empty($email)||empty($password))$error=true;
		if(empty($email))$email_error="Email required";
		if(empty($password))$pass_error="Password required";
		//form-validation ends here
		
		//Procedure for login
		if(!$error){
			$search_qry="SELECT * FROM user_account WHERE email='".$email."' AND password='".$password."';";
			$execute=mysqli_query($link, $search_qry);
			$num=mysqli_num_rows($execute);
			$result=mysqli_fetch_array($execute);
			if($result)
			{
				$_SESSION['username']=$result['username'];
				$_SESSION['email']=$result['email'];
				echo '<script>alert("Welcome");window.location.href="home.php";</script>';
			}
		//Search completed
			else{
				$error=true;
				echo "<script>alert('Invalid username or password.....');</script>";
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
      <input type="text" placeholder="Email-ID" name="email" value="<?php if(isset($_POST['login']))if($error)echo $email;?>">
      <span class="serror"><?php echo $email_error;?></span>
	  <br>
	  <input type="password" placeholder="password" name="password" value="<?php if(isset($_POST['login']))if($error)echo $password;?>">
	  <span class="serror"><?php echo $pass_error;?></span>
	  <br>
      <button type="submit" name="login">LOGIN</button>
      <p class="message">Not registered? <a href="signup.php">Create an account</a></p>
    </form>
  </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="assets/js/index.js"></script>
</body>
</html>