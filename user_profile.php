<?php 
	@session_start();
	include 'connect.php';
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];
	if (!isset($_SESSION['id'])) {
		echo "<script>window.location.href='index.php'</script>";
	} else {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC NETWORK</title>
	<link rel="stylesheet" type="text/css" href="bootstrap-4.6.1-dist/css/bootstrap.css">
	<script type="text/javascript" src="jquery/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.6.1-dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap-icons-1.7.2/bootstrap-icons.css">
</head>
<body style="background-color: #e5e5e9;">

<div class="container-fluid h-100">
	<div class="row h-100">
		
		<div class="col-auto col-sm-auto col-md-auto bg-white d-none d-md-block"><?php include 'user_menu.php'; ?></div>
		<div class="col col-sm col-md" style="padding: 0;">
			
			<?php include 'user_Tmenu.php'; ?>

			<div class="container-fluid">
				
				<div class="card mt-3 border-0">
					<div class="card-header text-secondary">
						<h4 class="font-weight-bold text-capitalize mt-2">My profile</h4>
					</div>
				</div>

				<div class="card border-0 mt-3 bg-transparent">
					<div class="card-deck">
						<div class="card border-0 bg-white">
							<div class="card-header bg-primary text-light">
								<h4 class="mt-2 text-capitalize font-weight-bold">Update Profile</h4>
							</div>
							<div class="card-body">
								<?php $showProfile = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
								$showP = mysqli_fetch_assoc($showProfile); ?>
								<form method="post">
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Username</label>
										<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" value="<?php echo $username ?>" disabled>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Name</label>
										<div class="input-group">
											 <input type="text" name="p_name" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" placeholder="Name" value="<?php echo $showP['m_name'] ?>" required>
											<input type="text" name="p_lastname" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Lastname" value="<?php echo $showP['m_lastname'] ?>" required>
										</div>
									</div>
									<hr>
									<button class="btn btn-block btn-sm font-weight-bold btn-primary rounded" type="submit" name="up_pro">Update</button>
								</form>
								<?php if (isset($_POST['up_pro'])) {
									$p_name = $_POST['p_name'];
									$p_lastname = $_POST['p_lastname'];

									$upPro = mysqli_query($con, "UPDATE member SET m_name = '$p_name', m_lastname = '$p_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$username'");
									echo "<script>alert('Update profile successful!')</script>";
									echo "<script>window.location.href='user_profile.php?id=$id'</script>";
								} ?>
							</div>
						</div>

						<div class="card border-0 bg-white">
							<div class="card-header bg-secondary text-light">
								<h4 class="mt-2 text-capitalize font-weight-bold">Change Password</h4>
							</div>
							<div class="card-body">
								<?php $showProfile = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
								$showP = mysqli_fetch_assoc($showProfile); ?>
								<form method="post">
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Old Password</label>
										<input type="password" name="c_oldpass" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Old Password" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">New Password</label>
										<input type="password" name="c_newpass" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="New Password" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Confirm Password</label>
										<input type="password" name="c_conpass" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Confirm Password" required>
									</div>
									<hr>
									<button class="btn btn-block btn-sm font-weight-bold btn-secondary rounded" type="submit" name="change_pass">Change</button>
								</form>
								<?php if (isset($_POST['change_pass'])) {
									$c_oldpass = $_POST['c_oldpass'];
									$c_newpass = $_POST['c_newpass'];
									$c_conpass = $_POST['c_conpass'];

									$checkOpass = mysqli_query($con, "SELECT * FROM radcheck WHERE value = '$c_oldpass' AND username = '$username'");
									$checkO = mysqli_num_rows($checkOpass);
									if ($checkO === 1) {
										if ($c_newpass === $c_conpass) {
											$changePass = mysqli_query($con, "UPDATE radcheck SET value = '$c_newpass' WHERE username = '$username'");
											echo "<script>alert('Change password successful!')</script>";
											echo "<script>window.location.href='user_profile.php?id=$id'</script>";
										} else {
											echo "<script>alert('Password not match!')</script>";
											echo "<script>window.location.href='user_profile.php?id=$id'</script>";
										}
									} else {
										echo "<script>alert('Your old password is not correct!')</script>";
										echo "<script>window.location.href='user_profile.php?id=$id'</script>";
									}
								} ?>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>

	</div>
</div>

</body>
</html>
<?php } ?>