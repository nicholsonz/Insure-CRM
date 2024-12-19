<?php
include('./include/dbconfig.php');
// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
// Try and connect using the info above.
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
			$stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
			// Store the result so we can check if the account exists in the database.
			$stmt->store_result();
		if ($stmt->num_rows > 0) {
				$stmt->bind_result($id, $password);
				$stmt->fetch();
				// Account exists, now we verify the password.
				// Note: remember to use password_hash in your registration file to store the hashed passwords.
			if (password_verify($_POST['password'], $password)) {
					// to use unencrypted passwords replace the above line with the following
					// if ($_POST['password'] === $password) {
					// Verification success! User has logged-in!
					// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
					session_regenerate_id();
					$_SESSION['loggedin'] = random_bytes(32);
					$_SESSION['name'] = $_POST['username'];
					$_SESSION['id'] = $id;
					header('Location: home.php');
				} else {
					// Incorrect password
					$login_err = 'Incorrect username and/or password!';
				}
		} else {
			// Incorrect username
			$login_err = 'Incorrect username and/or password!';
		}

		$stmt->close();
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login - Insure CRM</title>
		<link rel="stylesheet" href="../fontawesome/css/all.css">
		<link href="./css/style.css" rel="stylesheet" type="text/css">
		<link rel="icon" href="./favicon.ico">
	</head>
	<body class="logincolor">
		<div class="login">
			<h1>Insure CRM</h1>
			  <?php
	      if(!empty($login_err)){
	        echo '<div class="alert">' . $login_err .'</div>';
	      } else{
	          echo '<div></div>';
	      }
	      ?>
			<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
			<div class="signup">
			<p>Don't have an account? <a href="register-new.php">Sign Up</a>.</p>
			</div>
		</div>
	</body>
</html>
