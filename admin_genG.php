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
						<div class="card border-0 bg-light">
							<div class="card-header bg-primary text-light">
								<h4 class="mt-2 text-capitalize font-weight-bold">Generate Group</h4>
							</div>
							<div class="card-body">
								<?php $showProfile = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
								$showP = mysqli_fetch_assoc($showProfile); ?>
								<form method="post">
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Group Name</label>
										<input type="text" name="g_groupN" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Group Name" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Simultaneous Use</label>
										<input type="text" name="g_use" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Simultaneous Use" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Idle Timeout</label>
										<input type="text" name="g_idle" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Idle Timeout" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Session Timeout</label>
										<input type="text" name="g_session" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Session Timeout" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Download</label>
										<input type="text" name="g_down" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Download" required>
									</div>
									<div class="form-group mb-2">
										<label class="form-text font-weight-bold text-capitalize">Upload</label>
										<input type="text" name="g_up" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" placeholder="Upload" required>
									</div>
									<hr>
									<button class="btn btn-block btn-sm font-weight-bold btn-primary rounded" type="submit" name="gen_group">Generate Group</button>
								</form>
							</div>
						</div>

						<div class="card border-0 bg-light">
							<?php if (isset($_POST['gen_group'])) {
								$g_groupN = $_POST['g_groupN'];
								$g_use = $_POST['g_use'];
								$g_idle = $_POST['g_idle'];
								$g_session = $_POST['g_session'];
								$g_down = $_POST['g_down'];
								$g_up = $_POST['g_up'];

								$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$g_groupN', 'Auth-type', ':=', 'Accept')");
								$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$g_groupN', 'Simultaneous-Use', ':=', '$g_use')");
								$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_groupN', 'Acct-Interim-Interval', ':=', '60')");
								$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_groupN', 'Idle-Timeout', ':=', '$g_idle')");
								$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_groupN', 'Session-Timeout', ':=', '$g_session')");
								$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_groupN', 'WISPr-Bandwidth-Max-Down', ':=', '$g_down')");
								$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_groupN', 'WISPr-Bandwidth-Max-Up', ':=', '$g_up')"); ?>

								<div class="card-header bg-secondary text-light">
									<h4 class="font-weight-bold text-capitalize mt-2">Group</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive-lg">
										<table class="table table-bordered border-secondary">
											<tr>
												<th class=" bg-light">Group Name</th>
												<td><?php echo $g_groupN ?></td>
											</tr>
											<tr>
												<th class=" bg-light">Simultaneous Use</th>
												<td><?php echo $g_use ?></td>
											</tr>
											<tr>
												<th class=" bg-light">Idle Timeout</th>
												<td><?php echo $g_idle ?></td>
											</tr>
											<tr>
												<th class=" bg-light">Session Timeout</th>
												<td><?php echo $g_session ?></td>
											</tr>
											<tr>
												<th class=" bg-light">Download</th>
												<td><?php echo $g_down ?></td>
											</tr>
											<tr>
												<th class=" bg-light">Upload</th>
												<td><?php echo $g_up ?></td>
											</tr>
										</table>
									</div>

									<form method="post">
										<button class="btn btn-block btn-sm font-weight-bold btn-secondary rounded" type="submit" name="btn_re">Refresh</button>
									</form>
								</div>

							<?php if (isset($_POST['btn_re'])) {
								echo "<script>window.location.href='admin_genG.php?id=$id'</script>";
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