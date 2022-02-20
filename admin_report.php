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
				
				<div class="card mt-3 border-0">
					<div class="card-header bg-secondary text-light">
						<h4 class="font-weight-bold mt-2">Network & Time</h4>
					</div>
					<div class="card-body">
						<div class="nav nav-pills">
							<a href="#network" class="nav-link active font-weight-bold text-capitalize" data-toggle="pill">network</a>
							<a href="#time" class="nav-link font-weight-bold text-capitalize" data-toggle="pill">time</a>
						</div>
					</div>
				</div>

				<div class="card border-0 mt-3">
					<div class="tab-content">
						
						<div class="tab-pane fade active show" id="network">
							<div class="card-header bg-primary text-light font-weight-bold text-capitalize">
								<h4 class="mt-2">network Report</h4>
							</div>
							<div class="card-body bg-light">
								<div class="table-responsive-lg">
									<table class="table table-hover text-center">
										<thead class="font-weight-bold text-capitalize" style="background-color: #f5f5f9;">
											<th>ID</th>
											<th>Username</th>
											<th>Group</th>
											<th>IP Address</th>
											<th>Start</th>
											<th>Stop</th>
											<th>Session</th>
											<th>Note</th>
										</thead>
										<tbody>
											<?php 
											$showdata = mysqli_query($con, "SELECT * FROM radcheck, radacct WHERE radcheck.username = radacct.username AND attribute = 'Cleartext-Password' AND radcheck.username != '$username'");
											while ($show = mysqli_fetch_assoc($showdata)) {
											 	$showUsername = $show['username']; ?>
											 	<tr>
											 		<td><?php echo $show['id'] ?></td>
													<td><?php echo $showUsername ?></td>
													<td><?php 
														$showGroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$showUsername'");
														$showG = mysqli_fetch_assoc($showGroup);
														if ($showG) {
															echo $showG['groupname'];
														} else {
															echo " - ";
														}
													 ?></td>
													<td><?php echo $show['framedipaddress'] ?></td>
													<td><?php echo $show['acctstarttime'] ?></td>
													<td><?php echo $show['acctstoptime'] ?></td>
													<td><?php echo $show['acctsessiontime'] ?></td>
													<td><?php echo $show['acctterminatecause'] ?></td>
											 	</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="time">
							<div class="card-header bg-primary text-light font-weight-bold text-capitalize">
								<h4 class="mt-2">suspend Report <small class="text-white-50">who you want to susprnd.</small></h4>
							</div>
							<div class="card-body bg-light">
								<div class="table-responsive-lg">
									<table class="table table-hover text-center">
										<thead class="font-weight-bold text-capitalize" style="background-color: #f5f5f9;">
											<th>ID</th>
											<th>Username</th>
											<th>Name</th>
											<th>Lastname</th>
											<th>Group</th>
											<th>Update</th>
											<th>By</th>
										</thead>
										<tbody>
											<?php 
											$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND attribute = 'Cleartext-Password' AND radcheck.username != '$username'");
											while ($show = mysqli_fetch_assoc($showdata)) {
											 	$showUsername = $show['username']; ?>
											 	<tr>
											 		<td><?php echo $show['id'] ?></td>
													<td><?php echo $showUsername ?></td>
													<td><?php echo $show['m_name'] ?></td>
													<td><?php echo $show['m_lastname'] ?></td>
													<td><?php 
														$showGroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$showUsername'");
														$showG = mysqli_fetch_assoc($showGroup);
														if ($showG) {
															echo $showG['groupname'];
														} else {
															echo " - ";
														}
													 ?></td>
													<td><?php echo $show['m_update'] ?></td>
													<td><?php echo $show['m_who'] ?></td>
											 	</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
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