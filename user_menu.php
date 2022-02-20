<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<div class="nav flex-column mx-2" style="min-height: 100vh;">
		<a href="<?php echo "user_index.php?id=$id" ?>" class="navbar-brand text-center mt-5"><span class="badge badge-primary px-3 pt-2"><h4 class="font-weight-bold">IT</h4></span><h5 class="font-weight-bold text-secondary text-uppercase mt-2">ctc <span class="text-primary">network</span></h5></a>
		<hr width="100%">
		<a href="#" class="nav-link font-weight-bold disabled text-primary">Management</a>
		<a href="<?php echo "user_index.php?id=$id" ?>" class="nav-link ml-3 text-secondary">Dashboard</a>
		<a href="<?php echo "user_profile.php?id=$id" ?>" class="nav-link ml-3 text-secondary">Profile</a>
		<hr width="100%">
		<button class="btn btn-danger btn-block rounded text-capitalize font-weight-bold" type="button" data-toggle="modal" data-target="#logout">log out</button>
	</div>

</body>
</html>