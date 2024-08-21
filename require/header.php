<?php
    include('./include/dbconfig.php');

// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("Location: index.php");
  exit();
   }

  // Set some global variables
$acct_id = $_SESSION['id'];


// Connect to MySQL database
$pdo = pdo_connect_mysql();

?>

<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<?php function template_header($title) {echo "<title>" . $title . "</title>";}?>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="./css/style.css">
			<link rel="stylesheet" href="./css/w3.css">
			<link rel="stylesheet" href="../fontawesome/css/all.css">
      <link rel="icon" href="./favicon.ico">
			<script src="./js/jquery-3.7.1.min.js"></script>
			<script src="./js/chart.min.js"></script>
			<!-- <script src="./js/alertify.min.js"></script> -->
		</head>
<body>
<?php
// Check which account belongs to user and grant specific access
$sqlchk = "SELECT acct_type FROM accounts WHERE id = '$acct_id'";
$chkres = mysqli_query($con, $sqlchk);
while($row = mysqli_fetch_assoc($chkres)){
if($row['acct_type'] == "Admin" || $row['acct_type'] == "Agent"){ ?>

    <div class="w3-sidebar w3-bar-block w3-collapse w3-card-4 w3-animate-left w3-custom-blue" id="mySidebar">
		<button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
 			<div class="w3-logo">
				<a href="home.php" class="w3-bar-logo w3-padding w3-hover-text-blue"><h3><i class="fas fa-home w3-margin-right"></i> Simple CRM</h3></a>
			</div>
			<a href="taskmngr.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-hourglass w3-margin-right"></i> Tasks</a>
			<a href="clients.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-address-book w3-margin-right"></i> Clients</a>
            <a href="leads.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-address-book w3-margin-right"></i> Leads</a>
			<a href="profile.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-user-circle w3-margin-right"></i> Profile</a>
			<a href="./action/logout.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-sign-out-alt w3-margin-right"></i> Logout</a>
      <hr></hr>
			<div class="w3-dropdown-hover">
				<a href="" class="task-mngr w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-bell w3-margin-right"></i> Tasks Due
				<?php
				$sql_tasks = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND (NOW() BETWEEN DATE_SUB(DATE(deadline), INTERVAL 8 DAY) AND DATE(deadline)) ORDER BY deadline ASC";
				$res = mysqli_query($con, $sql_tasks);
				$num_tasks = mysqli_num_rows($res);



				$sql_tasks2 = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND DATE(NOW()) >= DATE(deadline) ORDER BY deadline ASC";
				$res2 = mysqli_query($con, $sql_tasks2);
				$num_tasks2 = mysqli_num_rows($res2);

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
								$names = $row['name'];
								$task_id = $row['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id'>" . $names . "</a>";
								echo "</td>";
								echo "</tr>";
							}
							while($row2 = mysqli_fetch_assoc($res2)){
								$names2 = $row2['name'];
								$task_id2 = $row2['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id2'>" . $names2 . "</a>";
								echo "</td>";
								echo "</tr>";
							}

					 }else{
						echo "<div></div>";
					 }
?>
<?php }else{ ?>
</div>
</div>
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card-4 w3-animate-left w3-custom-blue" id="mySidebar">
		<button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
 			<div class="w3-logo">
				<a href="home.php" class="w3-bar-logo w3-padding-large w3-hover-text-blue"><h3><i class="fas fa-home w3-margin-right"></i> Simple CRM</h3></a>
			</div>
			<a href="taskmngr.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-hourglass w3-margin-right"></i> Tasks</a>
            <a href="leads.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-address-book w3-margin-right"></i> Leads</a>
			<a href="./action/logout.php" class="w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-sign-out-alt w3-margin-right"></i> Logout</a>
      <div class="w3-dropdown-hover">
				<a href="" class="task-mngr w3-bar-item w3-larger w3-hover-text-blue"><i class="fas fa-bell w3-margin-right"></i> Tasks Due
				<?php
				$sql_tasks = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND (NOW() BETWEEN DATE_SUB(DATE(deadline), INTERVAL 7 DAY) AND DATE(deadline));";
				$res = mysqli_query($con, $sql_tasks);
				$num_tasks = mysqli_num_rows($res);



				$sql_tasks2 = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND (NOW() >= DATE_ADD(DATE(deadline), INTERVAL 1 DAY))";
				$res2 = mysqli_query($con, $sql_tasks2);
				$num_tasks2 = mysqli_num_rows($res2);

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
								$names = $row['name'];
								$task_id = $row['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id'>" . $names . "</a>";
								echo "</td>";
								echo "</tr>";
							}
							while($row2 = mysqli_fetch_assoc($res2)){
								$names2 = $row2['name'];
								$task_id2 = $row2['task_id'];

								echo "<tr>";
								echo "<td>";
								echo "<a href='update-task.php?task_id=$task_id2'>" . $names2 . "</a>";
								echo "</td>";
								echo "</tr>";
							}

					 }else{
						echo "<div></div>";
					 }

  } } ?>

					</table>
			</div>
		</div>
	</div>
</div>
	<div class="">
  	<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  	<div class="w3-container">
		</div>
	</div>
