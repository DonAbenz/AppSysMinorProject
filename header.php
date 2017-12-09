<?php
//header.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Hotel Management System</title>
		<script src="js/jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>  
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="center">Hotel Management System</h2>

			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a href="index.php" class="navbar-brand"><span class="glyphicon glyphicon-home"></span> Hotel Status</a>
					</div>
					<ul class="nav navbar-nav">
						<?php
						if($_SESSION['type'] == 'master'){
							?>
							<li><a href="room.php">Rooms</a></li>
							<li><a href="booking.php">Booking</a></li>
							<li><a href="#">Profit</a></li>
							<li><a href="user.php"> <span class="glyphicon glyphicon-user"></span> User</a></li>
							<?php
						}else{
							?>
							<li><a href="room.php">Rooms</a></li>
							<li><a href="booking.php">Booking</a></li>
							<li><a href="#">Profit</a></li>
							<li><a href="#">Next Checkouts</a></li>
							<?php
						}
						?>
						<!-- <li><a href="order.php">Order</a></li> -->
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["user_name"]; ?></a>
							<ul class="dropdown-menu">
								<li><a href="profile.php"><span class="glyphicon glyphicon-floppy-disk"></span> Profile</a></li>
								<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</nav>