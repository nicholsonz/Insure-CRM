<?php
// Include config file
include('dbconfig.php');

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$email_err = "Email is not valid!";
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    $username_err = "Username is not valid!";
}
if(empty(trim($_POST["password"]))){
	$password_err = "Please enter a password.";     
} elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,32}$/',trim($_POST["password"]))) {
	$password_err = "Password must be between 8 - 32 characters and include one upper-case letter, numbers, and at least one special character ! @ # $ %";
} else{
	$password = trim($_POST["password"]);
}

// Validate confirm password
if(empty(trim($_POST["confirm_password"]))){
	$confirm_password_err = "Please confirm password.";     
} else{
	$confirm_password = trim($_POST["confirm_password"]);
	if(empty($password_err) && ($password != $confirm_password)){
		$confirm_password_err = "Password did not match.";
	}
}
// Check input errors before inserting in database
if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){

	// We need to check if the account with that username exists.
	if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the account exists in the database.
		if ($stmt->num_rows > 0) {
			// Username already exists
			$username_err = "This username is already taken.";
		} else {
			// Username doesnt exists, insert new account
	if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
		// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$uniqid = uniqid();
		$stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
		$stmt->execute();
		$from    = 'example@gmail.com';
		$subject = 'Account Activation Required';
		$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	// Update the activation variable below
		$activate_link = 'http://example.net/clients/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
		$message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
		mail($_POST['email'], $subject, $message, $headers);	
		echo '<script>alert("Account created succesfully! Please check your email for activation link.")</script>';	
		header('Refresh:3; url=./index.php');
	} else {
		// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
		echo 'Could not prepare statement!';
	}
		}
		$stmt->close();
	} else {
		// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
		echo 'Could not prepare statement!';
	}
}
$con->close();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Register</title>
		<link rel="stylesheet" href="./fontawesome/css/all.css">
        <link href="./css/style.css" rel="stylesheet" type="text/css">
        <script src="./js/alertify.min.js"></script>
	</head>
	<body class="regcolor">
		<div class="register">
			<h1>Register</h1>
			<?php 
            if(!empty($password_err)){
                echo '<div class="alert">' . $password_err . '</div>';
            } elseif(!empty($username_err)){
                echo '<div class="alert">' . $username_err . '</div>';
            } elseif(!empty($confirm_password_err)){
                echo '<div class="alert">' . $confirm_password_err . '</div>';
            } elseif(!empty($email_err)){
                echo '<div class="alert">' . $email_err . '</div>';
            } else{
                echo '<div></div>';
            }
            ?>
			<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<label for="confirm_password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" required>
				<input type="submit" value="Submit">
				<p>Already have an account? <a href="index.php">Login here</a>.</p>
			</form>
		</div>
	</body>
</html>