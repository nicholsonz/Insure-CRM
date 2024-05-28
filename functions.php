<?php
    include('dbconfig.php');

// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // Set some global variables 
$acct_id = $_SESSION['id'];


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: index.php");
  exit;
 }

?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<?php function template_header($title) {echo "<title>" . $title . "</title>";}?>
			<link rel="stylesheet" href="./css/style.css">
			<link rel="stylesheet" href="./css/w3.css">
			<link rel="stylesheet" href="./fontawesome/css/all.css">
			<script src="./js/jquery-3.7.1.min.js"></script>		
			<script src="./js/chart.min.js"></script>
			<script src="./js/alertify.min.js"></script>
		</head>
<body>
    <nav class="navtop">
    	<div class="mobile">
    		<h1>Simple CRM</h1>
			<a href="home.php"><i class="fas fa-home"></i>Home</a>
			<a href="taskmngr.php"><i class="fas fa-hourglass"></i>Tasks</a>
			<a href="clients.php"><i class="fas fa-address-book"></i>Clients</a>
            <a href="leads.php"><i class="fas fa-address-book"></i>Leads</a>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a> 
			<div class="w3-dropdown-hover">
				<a href=""><i class="fas fa-bell"></i>  Tasks Due 
				<?php
				$sql_tasks = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND (NOW() BETWEEN DATE(deadline) AND DATE_ADD(DATE(deadline), INTERVAL 14 DAY))";
				$res = mysqli_query($con, $sql_tasks);
				$num_tasks = mysqli_num_rows($res);
				
				
					
				$sql_tasks2 = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND (NOW() > DATE_ADD(DATE(deadline), INTERVAL 10 DAY))";
				$res2 = mysqli_query($con, $sql_tasks2);
				$num_tasks2 = mysqli_num_rows($res2);
				 			
				if($num_tasks >= 1 && $num_tasks2 >= 1){
					echo "<span class='badgecur'>". number_format($num_tasks) ."</span></a>";
					echo "<span class='badgepas'>". number_format($num_tasks2) ."</span></a>";
				}elseif($num_tasks >= 1 && $num_tasks2 < 1){
					echo "<span class='badgecur'>". number_format($num_tasks) ."</span></a>";
				}elseif($num_tasks2 >= 1 && $num_tasks < 1){
					echo "<span class='badgepas'>". number_format($num_tasks2) ."</span></a>";
				}else{				
					echo "<span></span></a>";
				}
			
				if($num_tasks >= 1 || $num_tasks2 >= 1) { ?>
				<div class="w3-dropdown-content">
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
					 } ?>
					</table>
				</div>
			</div>
		</div>
    </nav>

	
