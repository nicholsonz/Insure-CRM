<?php
include 'functions.php';

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $pdo->prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.

// MISSING SQL INFO HERE


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="./css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="./fontawesome/css/all.css">
	</head>
	<body>
		<nav class="navtop">
			<div>
            <h1>Ipe Financial & Insurance Services LLC</h1>
			<a href="home.php"><i class="fas fa-home"></i>Home</a>
			<a href="clients.php"><i class="fas fa-address-book"></i>Clients</a>
            <a href="leads.php"><i class="fas fa-address-book"></i>Leads</a>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
					<tr>
						<td> <a href="resetpsswd.php" class="btn btn-warning">Reset Your Password</a></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>