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
						<h4 class="font-weight-bold mt-2">Welcome <small class="text-white-50"><?php echo $username; ?></small></h4>
					</div>
					<div class="card-body">
						<div class="nav nav-pills">
							<a href="#approve" class="nav-link active font-weight-bold text-capitalize" data-toggle="pill">approve</a>
							<a href="#suspend" class="nav-link font-weight-bold text-capitalize" data-toggle="pill">suspend</a>
						</div>
					</div>
				</div>

				<div class="card border-0 mt-3">
					<div class="tab-content">
						
						<div class="tab-pane fade active show" id="approve">
							<div class="card-header bg-primary text-light font-weight-bold text-capitalize">
								<h4 class="mt-2">approve user <small class="text-white-50">they wait for approve.</small></h4>
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
											<th>Approval</th>
											<th>managetment</th>
										</thead>
										<tbody>
											<?php 
											$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND attribute != 'Cleartext-Password' AND radcheck.username != '$username'");
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
													<td><button class="btn btn-block btn-sm btn-outline-info rounded-pill font-weight-bold" data-toggle="modal" data-target="#approve<?php echo $showUsername ?>">Approve</button></td>
													<td><div class="row">
														<div class="col"><button class="btn btn-block btn-sm btn-outline-warning text-dark rounded-pill font-weight-bold" data-toggle="modal" data-target="#edit<?php echo $showUsername ?>">Edit</button></div>
														<div class="col"><button class="btn btn-block btn-sm btn-outline-secondary rounded-pill font-weight-bold" data-toggle="modal" data-target="#del<?php echo $showUsername ?>">Delete</button></div>
													</div></td>
											 	</tr>

											 	<div class="modal fade" id="approve<?php echo $showUsername ?>">
											 		<div class="modal-dialog modal-dialog-centered">
											 			<div class="modal-content">
											 				<form method="post">
											 					<div class="modal-body bg-light">
											 						<div class="my-3 mx-3 text-secondary">
											 							<h4 class="font-weight-bold">Approve <small class="text-info"><?php echo $showUsername ?></small></h4>
											 							<hr>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Username</label>
											 								<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" value="<?php echo $showUsername ?>" disabled>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Name</label>
											 								<div class="input-group">
											 									<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" placeholder="Name" value="<?php echo $show['m_name'] ?>" required disabled>
																				<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Lastname" value="<?php echo $show['m_lastname'] ?>" required disabled>
											 								</div>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Group</label>
											 								<select class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" name="a_group">
											 									<?php if ($showG) { ?>
											 										<option value="<?php echo $showG['groupname'] ?>"><?php echo $showG['groupname'] ?></option>
											 									<?php } ?>
											 									<option value="Default">Default</option>
											 									<?php $loopGroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
											 									while ($loopG = mysqli_fetch_assoc($loopGroup)) { ?>
											 									 	<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
											 									<?php } ?>
											 								</select>
											 							</div>

											 							<div class="mt-4 text-center">
											 								<input type="hidden" name="a_username" value="<?php echo $showUsername ?>">
											 								<button class="btn btn-light px-5 btn-sm rounded text-capitalize font-weight-bold" type="button" data-dismiss="modal">cancle</button>
																			<button class="btn btn-info px-5 btn-sm rounded text-capitalize font-weight-bold" type="submit" name="app_rove">approve</button>
											 							</div>
											 						</div>
											 					</div>
											 				</form>
											 				<?php
											 					if (isset($_POST['app_rove'])) {
											 						$a_username = $_POST['a_username'];
											 						$a_group = $_POST['a_group'];

											 						$approveUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Cleartext-Password' WHERE username = '$a_username'");
											 						if ($a_group === 'Default') {
											 							$deG = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$a_username'");
											 						} else {
											 							$checkUIG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$a_username'");
											 							$checkUG = mysqli_num_rows($checkUIG);
											 							if ($checkUG === 1) {
											 								$upG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$a_group' WHERE username = '$a_username'");
											 							} else {
											 								$inG = mysqli_query($con, "INSERT INTO radgroupcheck (username, groupname, priority) VALUES ('$a_username', '$a_group', '1')");
											 							}
											 						}
											 						echo "<script>alert('Approve user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
											 					}
											 				?>
											 			</div>
											 		</div>
											 	</div>

											 	<div class="modal fade" id="edit<?php echo $showUsername ?>">
											 		<div class="modal-dialog modal-dialog-centered">
											 			<div class="modal-content">
											 				<form method="post">
											 					<div class="modal-body bg-light">
											 						<div class="my-3 mx-3 text-secondary">
											 							<h4 class="font-weight-bold">Edit <small style="color: #ff9800;"><?php echo $showUsername ?></small></h4>
											 							<hr>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Username</label>
											 								<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" value="<?php echo $showUsername ?>" disabled>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Name</label>
											 								<div class="input-group">
											 									<input type="text" name="e_name" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" placeholder="Name" value="<?php echo $show['m_name'] ?>" required>
																				<input type="text" name="e_lastname" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Lastname" value="<?php echo $show['m_lastname'] ?>" required>
											 								</div>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Group</label>
											 								<select class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" name="e_group">
											 									<?php if ($showG) { ?>
											 										<option value="<?php echo $showG['groupname'] ?>"><?php echo $showG['groupname'] ?></option>
											 									<?php } ?>
											 									<option value="Default">Default</option>
											 									<?php $loopGroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
											 									while ($loopG = mysqli_fetch_assoc($loopGroup)) { ?>
											 									 	<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
											 									<?php } ?>
											 								</select>
											 							</div>

											 							<div class="mt-4 text-center">
											 								<input type="hidden" name="e_username" value="<?php echo $showUsername ?>">
											 								<button class="btn btn-light px-5 btn-sm rounded text-capitalize font-weight-bold" type="button" data-dismiss="modal">cancle</button>
																			<button class="btn btn-info px-5 btn-sm rounded text-capitalize font-weight-bold" type="submit" name="edit_user">approve</button>
											 							</div>
											 						</div>
											 					</div>
											 				</form>
											 				<?php
											 					if (isset($_POST['edit_user'])) {
											 						$e_username = $_POST['e_username'];
											 						$e_name = $_POST['e_name'];
											 						$e_lastname = $_POST['e_lastname'];
											 						$e_group = $_POST['e_group'];

											 						$editUser = mysqli_query($con, "UPDATE member SET m_name = '$e_name', m_lastname = '$e_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$e_username'");
											 						if ($e_group === 'Default') {
											 							$deG = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$e_username'");
											 						} else {
											 							$checkUIG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$e_username'");
											 							$checkUG = mysqli_num_rows($checkUIG);
											 							if ($checkUG === 1) {
											 								$upG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$e_group' WHERE username = '$e_username'");
											 							} else {
											 								$inG = mysqli_query($con, "INSERT INTO radgroupcheck (username, groupname, priority) VALUES ('$e_username', '$e_group', '1')");
											 							}
											 						}
											 						echo "<script>alert('Edit user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
											 					}
											 				?>
											 			</div>
											 		</div>
											 	</div>

											 	<div class="modal fade" id="del<?php echo $showUsername ?>">
											 		<div class="modal-dialog modal-dialog-centered">
											 			<div class="modal-content">
											 				<form method="post">
											 					<div class="modal-body bg-light text-center">
											 						<div class="my-3 mx-3 text-secondary">
											 							
											 							<span class="font-weight-bold text-dark display-3"><i class="bi bi-trash"></i></span>
											 							<h5 class="text-capitalize mt-3">Are you really sure?</h5>
											 							<span class="mt-2 text-capitalize">Do you want to <strong>delete</strong> <span class="text-dark font-weight-bold"><?php echo $showUsername ?></span>?</span>

											 							<div class="mt-4 text-center">
											 								<input type="hidden" name="d_username" value="<?php echo $showUsername ?>">
											 								<button class="btn btn-light px-5 btn-sm rounded text-capitalize font-weight-bold" type="button" data-dismiss="modal">cancle</button>
																			<button class="btn btn-secondary px-5 btn-sm rounded text-capitalize font-weight-bold" type="submit" name="del_user">delete</button>
											 							</div>
											 						</div>
											 					</div>
											 				</form>
											 				<?php
											 					if (isset($_POST['del_user'])) {
											 						$d_username = $_POST['d_username'];

											 						$delUser = mysqli_query($con, "DELETE FROM member WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radcheck WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radacct WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radpostauth WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radreply WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$d_username'");
											 						echo "<script>alert('Delete user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
											 					}
											 				?>
											 			</div>
											 		</div>
											 	</div>

											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="suspend">
							<div class="card-header bg-primary text-light font-weight-bold text-capitalize">
								<h4 class="mt-2">suspend user <small class="text-white-50">who you want to susprnd.</small></h4>
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
											<th>suspend</th>
											<th>managetment</th>
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
													<td><button class="btn btn-block btn-sm btn-outline-dark rounded-pill font-weight-bold" data-toggle="modal" data-target="#suspend<?php echo $showUsername ?>">Suspend</button></td>
													<td><div class="row">
														<div class="col"><button class="btn btn-block btn-sm btn-outline-warning text-dark rounded-pill font-weight-bold" data-toggle="modal" data-target="#edit<?php echo $showUsername ?>">Edit</button></div>
														<div class="col"><button class="btn btn-block btn-sm btn-outline-secondary rounded-pill font-weight-bold" data-toggle="modal" data-target="#del<?php echo $showUsername ?>">Delete</button></div>
													</div></td>
											 	</tr>

											 	<div class="modal fade" id="suspend<?php echo $showUsername ?>">
											 		<div class="modal-dialog modal-dialog-centered">
											 			<div class="modal-content">
											 				<form method="post">
											 					<div class="modal-body bg-light">
											 						<div class="my-3 mx-3 text-secondary">
											 							<h4 class="font-weight-bold">Suspend <small class="text-info"><?php echo $showUsername ?></small></h4>
											 							<hr>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Username</label>
											 								<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" value="<?php echo $showUsername ?>" disabled>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Name</label>
											 								<div class="input-group">
											 									<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" placeholder="Name" value="<?php echo $show['m_name'] ?>" required disabled>
																				<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Lastname" value="<?php echo $show['m_lastname'] ?>" required disabled>
											 								</div>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Group</label>
											 								<select class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" name="s_group">
											 									<?php if ($showG) { ?>
											 										<option value="<?php echo $showG['groupname'] ?>"><?php echo $showG['groupname'] ?></option>
											 									<?php } ?>
											 									<option value="Default">Default</option>
											 									<?php $loopGroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
											 									while ($loopG = mysqli_fetch_assoc($loopGroup)) { ?>
											 									 	<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
											 									<?php } ?>
											 								</select>
											 							</div>

											 							<div class="mt-4 text-center">
											 								<input type="hidden" name="s_username" value="<?php echo $showUsername ?>">
											 								<button class="btn btn-light px-5 btn-sm rounded text-capitalize font-weight-bold" type="button" data-dismiss="modal">cancle</button>
																			<button class="btn btn-info px-5 btn-sm rounded text-capitalize font-weight-bold" type="submit" name="sus_pend">suspend</button>
											 							</div>
											 						</div>
											 					</div>
											 				</form>
											 				<?php
											 					if (isset($_POST['sus_pend'])) {
											 						$s_username = $_POST['s_username'];
											 						$s_group = $_POST['s_group'];

											 						$approveUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Password' WHERE username = '$s_username'");
											 						if ($s_group === 'Default') {
											 							$deG = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$s_username'");
											 						} else {
											 							$checkUIG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$s_username'");
											 							$checkUG = mysqli_num_rows($checkUIG);
											 							if ($checkUG === 1) {
											 								$upG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$s_group' WHERE username = '$s_username'");
											 							} else {
											 								$inG = mysqli_query($con, "INSERT INTO radgroupcheck (username, groupname, priority) VALUES ('$s_username', '$s_group', '1')");
											 							}
											 						}
											 						echo "<script>alert('Suspend user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
											 					}
											 				?>
											 			</div>
											 		</div>
											 	</div>

											 	<div class="modal fade" id="edit<?php echo $showUsername ?>">
											 		<div class="modal-dialog modal-dialog-centered">
											 			<div class="modal-content">
											 				<form method="post">
											 					<div class="modal-body bg-light">
											 						<div class="my-3 mx-3 text-secondary">
											 							<h4 class="font-weight-bold">Edit <small style="color: #ff9800;"><?php echo $showUsername ?></small></h4>
											 							<hr>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Username</label>
											 								<input type="text" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill" value="<?php echo $showUsername ?>" disabled>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Name</label>
											 								<div class="input-group">
											 									<input type="text" name="e_name" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" placeholder="Name" value="<?php echo $show['m_name'] ?>" required>
																				<input type="text" name="e_lastname" class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2" placeholder="Lastname" value="<?php echo $show['m_lastname'] ?>" required>
											 								</div>
											 							</div>
											 							<div class="form-group mb-2">
											 								<label class="form-text font-weight-bold text-capitalize">Group</label>
											 								<select class="form-control border-primary border-top-0 border-bottom-0 border-right-0 rounded-pill mb-2 mr-2" name="e_group">
											 									<?php if ($showG) { ?>
											 										<option value="<?php echo $showG['groupname'] ?>"><?php echo $showG['groupname'] ?></option>
											 									<?php } ?>
											 									<option value="Default">Default</option>
											 									<?php $loopGroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
											 									while ($loopG = mysqli_fetch_assoc($loopGroup)) { ?>
											 									 	<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
											 									<?php } ?>
											 								</select>
											 							</div>

											 							<div class="mt-4 text-center">
											 								<input type="hidden" name="e_username" value="<?php echo $showUsername ?>">
											 								<button class="btn btn-light px-5 btn-sm rounded text-capitalize font-weight-bold" type="button" data-dismiss="modal">cancle</button>
																			<button class="btn btn-info px-5 btn-sm rounded text-capitalize font-weight-bold" type="submit" name="edit_user">approve</button>
											 							</div>
											 						</div>
											 					</div>
											 				</form>
											 				<?php
											 					if (isset($_POST['edit_user'])) {
											 						$e_username = $_POST['e_username'];
											 						$e_name = $_POST['e_name'];
											 						$e_lastname = $_POST['e_lastname'];
											 						$e_group = $_POST['e_group'];

											 						$editUser = mysqli_query($con, "UPDATE member SET m_name = '$e_name', m_lastname = '$e_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$e_username'");
											 						if ($e_group === 'Default') {
											 							$deG = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$e_username'");
											 						} else {
											 							$checkUIG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$e_username'");
											 							$checkUG = mysqli_num_rows($checkUIG);
											 							if ($checkUG === 1) {
											 								$upG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$e_group' WHERE username = '$e_username'");
											 							} else {
											 								$inG = mysqli_query($con, "INSERT INTO radgroupcheck (username, groupname, priority) VALUES ('$e_username', '$e_group', '1')");
											 							}
											 						}
											 						echo "<script>alert('Edit user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
											 					}
											 				?>
											 			</div>
											 		</div>
											 	</div>

											 	<div class="modal fade" id="del<?php echo $showUsername ?>">
											 		<div class="modal-dialog modal-dialog-centered">
											 			<div class="modal-content">
											 				<form method="post">
											 					<div class="modal-body bg-light text-center">
											 						<div class="my-3 mx-3 text-secondary">
											 							
											 							<span class="font-weight-bold text-dark display-3"><i class="bi bi-trash"></i></span>
											 							<h5 class="text-capitalize mt-3">Are you really sure?</h5>
											 							<span class="mt-2 text-capitalize">Do you want to <strong>delete</strong> <span class="text-dark font-weight-bold"><?php echo $showUsername ?></span>?</span>

											 							<div class="mt-4 text-center">
											 								<input type="hidden" name="d_username" value="<?php echo $showUsername ?>">
											 								<button class="btn btn-light px-5 btn-sm rounded text-capitalize font-weight-bold" type="button" data-dismiss="modal">cancle</button>
																			<button class="btn btn-secondary px-5 btn-sm rounded text-capitalize font-weight-bold" type="submit" name="del_user">delete</button>
											 							</div>
											 						</div>
											 					</div>
											 				</form>
											 				<?php
											 					if (isset($_POST['del_user'])) {
											 						$d_username = $_POST['d_username'];

											 						$delUser = mysqli_query($con, "DELETE FROM member WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radcheck WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radacct WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radpostauth WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radreply WHERE username = '$d_username'");
											 						$delUser = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$d_username'");
											 						echo "<script>alert('Delete user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
											 					}
											 				?>
											 			</div>
											 		</div>
											 	</div>
											 	
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