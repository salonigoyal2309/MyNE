<?php
	require('header.php');
	if(!isset($_SESSION['check'])){
		header('location:admin_logout.php');
	}
	$oldpass_error=""; $pass_error=""; $repass_error="";
	if(isset($_POST['change'])){
		$error=false;
		$oldpass=test_input($_POST['oldpass']);
		$newpass=test_input($_POST['newpass']);
		$re_newpass=test_input($_POST['re_newpass']);
		//form-validation
		if(empty($oldpass)||empty($newpass)||empty($re_newpass)||($newpass!==$re_newpass))$error=true;
		if(empty($oldpass))$oldpass_error="required";
		if(empty($re_newpass))$repass_error="required";
		if(empty($newpass))$pass_error="required";
		else{
			$passExp='/^[a-zA-Z0-9\#\$\&\@]+$/';
			if(!preg_match($passExp,$newpass))
			{
				$pass_error="Password can have only #, $, &, @ special characters";
				$error=true;
			}
		}
		if($newpass!==$re_newpass)$repass_error="Passwords should be same";
		//form-validation ends here
		
		//Searching entered old password
		if(!$error){
			$search_qry="SELECT * FROM adminpass WHERE password='".$oldpass."'";
			$execute=mysqli_query($link, $search_qry);
			$num=mysqli_num_rows($execute);
			if($num<=0)
			{
				echo "<script>alert('You entered wrong password');</script>;";
				$error=true;
			}
		//Search completed
			else{
				$upd_qry="UPDATE adminpass set password='".$newpass."'";
				if(mysqli_query($link, $upd_qry)){
					echo "<script>alert('Password updated');</script>";
					echo "<script>window.location.href = 'admin_pendingorders.php';</script>";
				}
				else{
					echo "<script>alert('ERROR!!!');</script>";
				}
			}
		}
	}
?>
	<div class="container">
			<div class="row">
				<div class="container">
				<form class="form-horizontal col-md-8" method="post">
					<div class="form-group">
						<h2><center><b>Change Password</b></center></h2>
							<label class="control-label col-sm-2 col-md-2">Old Password</label>
							<div class="col-md-10 col-sm-10">
								<input type="password" class="form-control" name="oldpass" value="<?php if(isset($_POST['change']))if($error)echo $oldpass;?>">
							</div>
							<span class="serror"><?php echo $oldpass_error;?></span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 col-md-2">New Password</label>
							<div class="col-md-10 col-sm-10">
								<input type="password" class="form-control" name="newpass" value="<?php if(isset($_POST['change']))if($error)echo $newpass;?>">
							</div>
							<span class="serror"><?php echo $pass_error;?></span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 col-md-2">Re-enter Password</label>
							<div class="col-md-10 col-sm-10">
								<input type="password" class="form-control" name="re_newpass">
							</div>
							<span class="serror"><?php echo $repass_error;?></span>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-sm-offset-2">
								<center><input type="submit" class="btn btn-success" name="change" value="Submit"></center>
							</div>
					</div>
				</form>
				</div>
			</div>
	</div>
</html>