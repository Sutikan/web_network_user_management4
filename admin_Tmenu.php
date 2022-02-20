<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<div class="navbar navbar-light bg-white d-block d-md-none">
		<div class="container-fluid">
			<a href="<?php echo "admin_index.php?id=$id" ?>" class="navbar-brand d-block d-md-none"><span class="badge badge-primary px-3 pt-2"><h4 class="font-weight-bold">IT</h4></span><span class="ml-2 font-weight-bold text-secondary text-uppercase mt-2">ctc <span class="text-primary">network</span></span></a>
			<button class="navbar-toggler d-block d-md-none" data-toggle="collapse" data-target="#menu"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse d-lg-none" id="menu">
				<a href="#" class="nav-link font-weight-bold disabled text-primary">Management</a>
				<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link ml-3 text-secondary">Dashboard</a>
				<a href="<?php echo "admin_profile.php?id=$id" ?>" class="nav-link ml-3 text-secondary">Profile</a>
				<a href="#" class="nav-link font-weight-bold disabled text-primary">Generate</a>
				<a href="<?php echo "admin_genG.php?id=$id" ?>" class="nav-link ml-3 text-secondary">Generate Group</a>
				<a href="<?php echo "admin_genU.php?id=$id" ?>" class="nav-link ml-3 text-secondary">Generate Users</a>
				<a href="#" class="nav-link font-weight-bold disabled text-primary">Report</a>
				<a href="<?php echo "admin_report.php?id=$id" ?>" class="nav-link ml-3 text-secondary">Network & Time</a>
				<hr width="100%">
				<button class="btn btn-danger btn-block rounded text-capitalize font-weight-bold" type="button" data-toggle="modal" data-target="#logout">log out</button>
			</div>
		</div>		
	</div>

	<div class="modal fade" id="logout">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="post">
					<div class="modal-body">
						<div class="my-3 mx-3 text-center text-secondary">
							<h1 class="display-3 font-weight-bold text-danger mb-3"><i class="bi bi-box-arrow-right"></i></h1>
							<h5 class="mt-3">Are you really sure?</h5>
							<span class="mt-2 text-capitalize">Do you want to <span class="font-weight-bold text-danger text-capitalize">log out</span>?</span>

							<div class="mt-4">
								<button class="btn btn-light px-5 btn-sm rounded text-capitalize font-weight-bold" type="button" data-dismiss="modal">cancle</button>
								<button class="btn btn-danger px-5 btn-sm rounded text-capitalize font-weight-bold" type="submit" name="log_out">log out</button>
							</div>
						</div>
					</div>
				</form>
				<?php 
					if (isset($_POST['log_out'])) {
						session_destroy();
						echo "<script>window.location.href='index.php'</script>";
					}
				?>
			</div>
		</div>
	</div>

</body>
</html>