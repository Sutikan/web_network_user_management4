<?php 
	@session_start();
	include 'connect.php';	
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
<body style="background-color: #e5e5e9; min-height: 100vh;" class="d-flex justify-content-center align-items-center">

<div class="card border-0">
	<div class="card-header bg-primary text-light">
		<div class="nav nav-tabs card-header-tabs">
			<a href="#login" class="nav-link font-weight-bold text-capitalize active" data-toggle="tab">Log in</a>
			<a href="#signup" class="nav-link font-weight-bold text-capitalize" data-toggle="tab">sign up</a>
		</div>
	</div>
	<div class="card-body bg-light">
		<div class="tab-content mx-3 my-4">
			<div class="tab-pane fade active show" id="login">
				<h3 class="mt-4 font-weight-bold text-primary text-center">CTC NETWORK</h3>
				<h5 class="text-secondary font-weight-bold text-uppercase text-center mb-3">User login</h5>

				<form method="post">
					<input type="text" name="l_username" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Username" required>
					<input type="password" name="l_pass" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Password" required>

					<button class="btn btn-primary btn-block font-weight-bold rounded text-capitalize mt-3" type="submit" name="log_in">log in</button>
				</form>
				<?php 
					if (isset($_POST['log_in'])) {
						$loginUser = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '".trim($_POST['l_username'])."' AND value = '".trim($_POST['l_pass'])."'");
						$data = mysqli_fetch_assoc($loginUser);
						if ($data) {
							if ($data['attribute'] === 'Cleartext-Password') {
								$id = $data['id'];
								$_SESSION['id'] = $data['id'];
								$_SESSION['username'] = $data['username'];

								if ($data['username'] === 'admin') {
									echo "<script>window.location.href='admin_index.php?id=$id'</script>";
								} else {
									echo "<script>window.location.href='user_index.php?id=$id'</script>";
								}
							} else {
								echo "<script>alert('This username has been suspended!')</script>";
								echo "<script>window.location.href='index.php'</script>";
							}
						} else {
							echo "<script>alert('Username or password is not correct!')</script>";
							echo "<script>window.location.href='index.php'</script>";
						}
					}
				?>
			</div>
			<div class="tab-pane fade" id="signup">
				<h3 class="mt-4 font-weight-bold text-primary text-center">CTC NETWORK</h3>
				<h5 class="text-secondary font-weight-bold text-uppercase text-center mb-3">User register</h5>

				<form method="post">
					<div class="input-group">
						<input type="text" name="s_name" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" placeholder="Name" required>
						<input type="text" name="s_lastname" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Lastname" required>
					</div>
					<input type="text" name="s_username" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Username" required>
					<input type="password" name="s_pass" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Password" required>

					<button class="btn btn-secondary btn-block font-weight-bold rounded text-capitalize mt-3" type="submit" name="sign_up">sign up</button>
				</form>
				<?php 
					if (isset($_POST['sign_up'])) {
						$s_name = $_POST['s_name'];
						$s_lastname = $_POST['s_lastname'];
						$s_username = $_POST['s_username'];
						$s_pass = $_POST['s_pass'];

						$checkName = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '$s_username'");
						$checkN = mysqli_num_rows($checkName);
						if ($checkN === 1) {
							echo "<script>alert('This username is already exisit!')</script>";
							echo "<script>window.location.href='index.php'</script>";
						} else {
							$signupUser = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$s_username', 'Password', ':=', '$s_pass')");
							$signupUser = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$s_username', '$s_name', '$s_lastname')");
							echo "<script>alert('Sign up successful, Please wait for approve')</script>";
							echo "<script>window.location.href='index.php'</script>";
						}
					}
				?>
			</div>
		</div>
	</div>
</div>

</body>
</html>