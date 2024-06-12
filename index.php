<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login - Simple-CRM</title>
		<link rel="stylesheet" href="../fontawesome/css/all.css">
		<link href="./css/style.css" rel="stylesheet" type="text/css">
		<link rel="icon" href="./favicon.ico">
	</head>
	<body class="logincolor">
		<div class="login">
			<h1>Simple-CRM</h1>
			<form action="./action/authenticate.php" method="post">
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
