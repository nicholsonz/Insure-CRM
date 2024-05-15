<?php
    include('dbconfig.php');

// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // Set some global variables 
$acct_id = $_SESSION["id"];


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: index.php");
  exit;
 }

function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link rel="stylesheet" href="./css/style.css">
		<link rel="stylesheet" href="./css/w3.css">
		<link rel="stylesheet" href="./fontawesome/css/all.css">
		<script src="./js/jquery-3.7.1.min.js"></script>		
        <script src="./js/chart.min.js"></script>
        <script src="./js/alertify.min.js"></script>
	</head>
EOT;
}

?>
<!-- Modal content -->
<div id="myModal" class="w3-modal">
  <div class="w3-modal-content">
	<div class="w3-container">
		<span class="w3-button w3-display-topright close">&times;</span>
		<p>Some text in the Modal..</p>
      <p>Some text in the Modal..</p>			  
	</div>
  </div>
</div>
<?php 
	
	$sql_tasks = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND (deadline = CURDATE() OR deadline < CURDATE())";
	$res = mysqli_query($con, $sql_tasks);
	$num_tasks = mysqli_num_rows($res);

	while($row = mysqli_fetch_assoc($res)){
		$names = $row['name'];
		$task_id = $row['task_id'];

	echo "<a href='update-task.php?task_id=$task_id'><?= $names;?></a>";
	}
?>
<body>
    <nav class="navtop">
    	<div>
    		<h1>Simple CRM</h1>
			<a href="home.php"><i class="fas fa-home"></i>Home</a>
			<a href="taskmngr.php"><i class="fas fa-hourglass"></i>Tasks</a>
			<a href="clients.php"><i class="fas fa-address-book"></i>Clients</a>
            <a href="leads.php"><i class="fas fa-address-book"></i>Leads</a>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			<button id="listTasks" class="w3-button w3-custom-blue w3-round"><i class="fas fa-bell"></i><span> Tasks Due</span> 
			<?php 
			if($num_tasks < 1){
				echo "<span></span>";
			}else{
				echo "<span class='badge'>". number_format($num_tasks) ."</span></button>";
			}
			?>
		</div>
    </nav>
	
