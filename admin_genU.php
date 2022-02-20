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
		
		<div class="col-auto col-sm-auto col-md-auto bg-white d-none d-md-block"><?php include 'admin_menu.php'; ?></div>
		<div class="col col-sm col-md" style="padding: 0;">
			
			<?php include 'admin_Tmenu.php'; ?>

			<div class="container-fluid">
				
				<div class="card border-0 mt-3 bg-transparent">

					<div class="card-deck">
						<div class="card border-0 bg-transparent">
							<div class="card-header bg-primary text-light">
								<h4 class="mt-2 text-capitalize font-weight-bold">Generate Users <small class="text-white-50">For generate more 1 user</small></h4>
							</div>
							<div class="card-body bg-light">
								<?php $showProfile = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
								$showP = mysqli_fetch_assoc($showProfile); ?>
								<form method="post">
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Number Of User</label>
										<input type="text" name="us_number" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Number Of User" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Group</label>
										<select class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" name="us_group">
											<option value="Default">Default</option>
											<?php $loopGroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
											 	while ($loopG = mysqli_fetch_assoc($loopGroup)) { ?>
											 		<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
											 <?php } ?>
										</select>
									</div>
									<hr>
									<button class="btn btn-block btn-sm font-weight-bold btn-primary rounded" type="submit" name="gen_users">Generate Users</button>
								</form>
							</div>
							<div class="card-header bg-light text-secondary mt-2">
								<h4 class="mt-2 text-capitalize font-weight-bold">Generate User <small class="text-dark-50">For generate only 1 user</small></h4>
							</div>
							<div class="card-body bg-light">
								<?php $showProfile = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
								$showP = mysqli_fetch_assoc($showProfile); ?>
								<form method="post">
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">name</label>
										<div class="input-group">
											<input type="text" name="u_name" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mr-2" placeholder="Name" required>
											<input type="text" name="u_lastname" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mr-2" placeholder="Lastname" required>
										</div>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">username</label>
										<input type="text" name="u_username" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Username" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Password</label>
										<input type="password" name="u_pass" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Password" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Group</label>
										<select class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" name="u_group">
											<option value="Default">Default</option>
											<?php $loopGroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
											 	while ($loopG = mysqli_fetch_assoc($loopGroup)) { ?>
											 		<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
											 <?php } ?>
										</select>
									</div>
									<hr>
									<button class="btn btn-block btn-sm font-weight-bold btn-secondary rounded" type="submit" name="gen_user">Generate User</button>
								</form>
							</div>
						</div>

						<div class="card border-0 bg-light">
							<?php if (isset($_POST['gen_users'])) {
								$us_number = $_POST['us_number'];
								$us_group = $_POST['us_group'];

								?>

								<div class="card-header bg-secondary text-light">
									<h4 class="font-weight-bold text-capitalize mt-2">Users</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive-lg">
										<table class="table table-bordered border-secondary text-center">
											<thead class="text-capitalize">
												<th>Username</th>
												<th>Password</th>
												<th>Group</th>
											</thead>
											<tbody>
												<?php for ($i=0; $i <$us_number ; $i++) { 
													$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
													$num = "1234567890";
													$subC = str_shuffle($char);
													$subN = str_shuffle($num);
													$us_username = substr($us_group, 0, 3).substr($subC, 0, 3).substr($subN, 0, 2);
													$us_pass = substr($subN, 0, 6);

													$genUsers = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$us_username', '$us_username', '$us_group')");
													$genUsers = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$us_username', 'Cleartext-Password', ':=', '$us_pass')");
													if ($us_group !== 'Default') {
														$genUGs = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$us_username', '$us_group', '1')"); 
													} ?>
													<tr>
														<td><?php echo $us_username ?></td>
														<td><?php echo $us_pass ?></td>
														<td><?php if ($us_group === 'Default') {
															echo " - ";
														} else {
															echo $us_group;
														} ?></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>

									<form method="post">
										<button class="btn btn-block btn-sm font-weight-bold btn-secondary rounded" type="submit" name="btn_re">Refresh</button>
									</form>
								</div>

							<?php if (isset($_POST['btn_re'])) {
								echo "<script>window.location.href='admin_genU.php?id=$id'</script>";
							} } elseif (isset($_POST['gen_user'])) {
								$u_username = $_POST['u_username'];
								$u_name = $_POST['u_name'];
								$u_lastname = $_POST['u_lastname'];
								$u_pass = $_POST['u_pass'];
								$u_group = $_POST['u_group'];

								$genUser = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$u_username', '$u_name', '$u_lastname')");
								$genUser = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$u_username', 'Cleartext-Password', ':=', '$u_pass')");
								if ($u_group !== 'Default') {
									$genUG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$u_username', '$u_group', '1')"); 
								} ?>
								<div class="card-header bg-secondary text-light">
									<h4 class="font-weight-bold text-capitalize mt-2">User</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive-lg">
										<table class="table table-bordered border-secondary text-center">
											<thead class="text-capitalize">
												<th>Username</th>
												<th>Password</th>
												<th>Group</th>
											</thead>
											<tbody>
												<td><?php echo $u_username ?></td>
												<td><?php echo $u_pass ?></td>
												<td><?php if ($u_group === 'Default') {
													echo " - ";
												} else {
													echo $u_group;
												} ?></td>
											</tbody>
										</table>
									</div>

									<form method="post">
										<button class="btn btn-block btn-sm font-weight-bold btn-secondary rounded" type="submit" name="btn_re">Refresh</button>
									</form>
								</div>
							<?php if (isset($_POST['btn_re'])) {
								echo "<script>window.location.href='admin_genU.php?id=$id'</script>";
							} } else { ?>
								<div class="d-flex justify-content-center align-items-center h-100">
									<h1 class="font-weight-bold text-uppercase text-secondary">CTC <span class="text-primary">network</span></h1>
								</div>
							<?php } ?>
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