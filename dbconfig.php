<?php
// PDO db creds
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'clients';
    $DATABASE_PASS = 'clients!@#456';
    $DATABASE_NAME = 'clientdb';
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

$con = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>