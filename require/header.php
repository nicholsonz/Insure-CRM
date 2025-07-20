<?php
    include('./include/config.php');

// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
    session_start();

  $key = hash('sha256', $_SERVER['REMOTE_ADDR']);
    $_SESSION['DoubleCheck'] = $key;
  }

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== $_SESSION['DoubleCheck']){
	header("Location: index.php");
  exit();
   }

  // Set some global variables
$acct_id = $_SESSION['id'];


// Assign variable to PDO connect function in config.php
$pdo = pdo_connect_mysql();

// SQL statement used to test whether the user is Admin
$admchk = "SELECT acct_type FROM accounts WHERE id = '$acct_id'";
$chkres = mysqli_query($con, $admchk);
$rowchk = mysqli_fetch_assoc($chkres);

// Check if user is Admin 
if($rowchk['acct_type'] == "Admin"){   
    include('./admnstr/admin_sql.php');
} else {
    include('./action/user_sql.php');
}

?>

<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<meta name="referrer" content="same-origin">
	        <?php function template_header($title) {echo "<title>" . $title . "</title>";}?>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="./css/bootstrap.min.css">
			<link rel="stylesheet" href="./css/fontawesome/all.min.css">
			<link rel="stylesheet" href="./css/w3.css">
			<link rel="stylesheet" href="./css/style.css">
			<!-- <link rel="stylesheet" href="./css/bootstrap.mod.css"> -->
      		<link rel="icon" href="./favicon.ico">
			<!-- Load Javascript files -->
			<script src="./js/chart.min.js"></script>
			<script src="./js/jquery-3.7.1.min.js"></script>
			<script src="./js/bootstrap.min.js"></script>
			<script src="./js/alertify/alertify.min.js"></script>
		</head>
<body>
<?php if($rowchk['acct_type'] == "Admin"): ?>

    <div class="w3-sidebar w3-bar-block w3-collapse w3-card-4 w3-animate-left w3-custom-blue" id="mySidebar">
    <button class="w3-bar-item w3-button w3-large w3-hide-large" id="w3close">Close &times;</button>
 			<div class="w3-logo">
				<a href="home.php" class="w3-bar-logo w3-padding w3-hover-text-blue"><h3><i class="fas fa-home w3-margin-right"></i> Insure CRM</h3></a>
			</div>
				<a href="taskmngr.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-hourglass w3-margin-right"></i> Tasks</a>
				<a href="clients.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-address-book w3-margin-right"></i> Clients</a>
				<a href="leads.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-address-book w3-margin-right"></i> Leads</a>
				<a href="admnstr.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-user-circle w3-margin-right"></i> Admin</a>
				<a href="./action/logout.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-sign-out-alt w3-margin-right"></i> Logout</a>
				<hr></hr>
			<div class="w3-dropdown-hover">
				<a href="" class="task-mngr w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-bell w3-margin-right"></i> Tasks Due
				<?php

				if($num_tasks >= 1 && $num_tasks2 >= 1){
					echo "<span class='badgecur'>". number_format($num_tasks) ."</span>";
					echo "<span class='badgepas'>". number_format($num_tasks2) ."</span></a>";
				}elseif($num_tasks >= 1 && $num_tasks2 < 1){
					echo "<span class='badgecur'>". number_format($num_tasks) ."</span></a>";
				}elseif($num_tasks2 >= 1 && $num_tasks < 1){
					echo "<span class='badgepas'>". number_format($num_tasks2) ."</span></a>";
				}else{
					echo "<span></span></a>";
				}

				if($num_tasks >= 1 || $num_tasks2 >= 1) { ?>
				<div class="w3-dropdown-content w3-bar-block">
					<table class="w3-table">
						 <?php
							while($row = mysqli_fetch_assoc($res)){
								$objects = $row['object'];
								$task_id = $row['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id'>" . $objects . "</a>";
								echo "</td>";
								echo "</tr>";
							}
							while($row2 = mysqli_fetch_assoc($res2)){
								$objects2 = $row2['object'];
								$task_id2 = $row2['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id2'>" . $objects2 . "</a>";
								echo "</td>";
								echo "</tr>";
							}

					 }else{
						echo "<div></div>";
					 }
				?>
<?php else: ?>
	</div>
</div>
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card-4 w3-animate-left w3-custom-blue" id="mySidebar">
   	 <button class="w3-bar-item w3-button w3-large w3-hide-large" id="w3close">Close &times;</button>
 			<div class="w3-logo">
				<a href="home.php" class="w3-bar-logo w3-padding w3-hover-text-blue"><h3><i class="fas fa-home w3-margin-right"></i> Insure CRM</h3></a>
			</div>
				<a href="taskmngr.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-hourglass w3-margin-right"></i> Tasks</a>
				<a href="clients.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-address-book w3-margin-right"></i> Clients</a>
				<a href="leads.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-address-book w3-margin-right"></i> Leads</a>
				<a href="./action/logout.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-sign-out-alt w3-margin-right"></i> Logout</a>
				<hr></hr>
      		<div class="w3-dropdown-hover">
				<a href="" class="task-mngr w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-bell w3-margin-right"></i> Tasks Due
				<?php
				if($num_tasks >= 1 && $num_tasks2 >= 1){
					echo "<span class='badgecur'>". number_format($num_tasks) ."</span>";
					echo "<span class='badgepas'>". number_format($num_tasks2) ."</span></a>";
				}elseif($num_tasks >= 1 && $num_tasks2 < 1){
					echo "<span class='badgecur'>". number_format($num_tasks) ."</span></a>";
				}elseif($num_tasks2 >= 1 && $num_tasks < 1){
					echo "<span class='badgepas'>". number_format($num_tasks2) ."</span></a>";
				}else{
					echo "<span></span></a>";
				}

				if($num_tasks >= 1 || $num_tasks2 >= 1) { ?>
				<div class="w3-dropdown-content w3-bar-block">
					<table class="w3-table">
						 <?php
							while($row = mysqli_fetch_assoc($res)){
								$objects = $row['object'];
								$task_id = $row['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id'>" . $objects . "</a>";
								echo "</td>";
								echo "</tr>";
							}
							while($row2 = mysqli_fetch_assoc($res2)){
								$objects2 = $row2['object'];
								$task_id2 = $row2['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id2'>" . $objects2 . "</a>";
								echo "</td>";
								echo "</tr>";
							}

					 }else{
						echo "<div></div>";
					 }

				?>
<?php endif;?>
					</table>
			</div>
		</div>
	</div>
</div>
	<div class="">
    <button class="w3-button w3-xlarge w3-hide-large" id="w3open">&#9776;</button>
  	<div class="w3-container">
		</div>
	</div>