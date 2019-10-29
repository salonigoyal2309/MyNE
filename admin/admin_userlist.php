<?php
	require('header.php');
	if(!isset($_SESSION['check'])){
		header('location:admin_logout.php');
	}
	
	$tblcolor = array("success", "danger", "active", "info", "warning");
	$tbi=0;
	
	$userqry = "SELECT username, email from user_account";
	$exe0 = mysqli_query($link, $userqry);
	$no0 = mysqli_num_rows($exe0);
?>


<div class = "container">
	<div class="row">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<h3><center><b>List of Users</b></center></h3>
				<tr class="default">
					<th>USERNAME</th>
					<th>EMAIL</th>
				</tr>
				<?php
					if($no0>0){
						while($res0=mysqli_fetch_array($exe0)){
				?>
				<tr class="<?php echo $tblcolor[$tbi]; $tbi=($tbi+1)%5; ?>">
					<td><a href = "admin_userorders.php?email=<?php echo $res0['email']; ?>"><?php echo $res0['username']; ?></a></td>
					<td><?php echo $res0['email']; ?></td>
				</tr>
				<?php
						}
					}
				?>
			</table>
		</div>
	</div>
</div>