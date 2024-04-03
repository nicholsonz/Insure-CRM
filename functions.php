<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = '';
    $DATABASE_PASS = '';
    $DATABASE_NAME = '';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
// mysqli db creds
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'clients');
define('DB_PASSWORD', 'clients!@#456');
define('DB_NAME', 'clientdb');

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
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Ipe Financial & Insurance Services LLC</h1>
			<a href="home.php"><i class="fas fa-home"></i>Home</a>
			<a href="taskmngr.php"><i class="fas fa-hourglass"></i>Tasks</a>
			<a href="clients.php"><i class="fas fa-address-book"></i>Clients</a>
            <a href="leads.php"><i class="fas fa-address-book"></i>Leads</a>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        
    	</div>
    </nav>
EOT;
}
function template_footer() {
echo <<<EOT
<script src="./js/srtable.js"></script>
    </body>
</html>
EOT;
}
?>
