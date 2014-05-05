<?php
require_once "config.php"; // establish database settings and connection
session_start();

$valid=NULL; // will be a bool for valid login credentials
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Log in</title>
	<link rel="stylesheet" href="css/foundation.css">
	<script src="js/vendor/modernizr.js"></script>
</head>
<body>
<?php if (!empty($_POST)) {
	if ($user_query=$db_connection->query('select username, password, email, fname from users where username="' . $_POST['username'] . '"')) {
		$user=$user_query->fetch_assoc();
		if (hash('sha512', $_POST['password'])==$user['password']) {
			$valid=true;
			$_SESSION['user']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['dname']=$user['fname'];
		}
		else {
			$valid=false;
		}
	}
	else {
		$valid=false;
	}
} ?>
<?php require_once "navbar.php"; ?>
<?php if (isset($valid) && !$valid) { ?>
<div data-alert class="alert-box alert">
	Invalid username and/or password.
	<a href="#" class="close">&times;</a>
</div>
<?php } ?>
<div class="row">
	<div class="large-12 columns">
		<h1>Log in</h1><hr>
<?php if (isset($_SESSION['user'])) {
	if (empty($_POST)) { ?>
		<p>You are already logged in.</p>
<?php }
	else { ?>
		<p>You have successfully logged in.</p>
<?php } ?>
		<p>Return to the <a href="index.php">Main Page</a>.</p>
<?php } ?>
	</div>
	<?php if (empty($_SESSION)) { ?><div class="medium-6 large-5 columns end">
		<form action="login.php" method="post"><div class="panel">
			<label>Username
				<input type="text" name="username" placeholder="Enter your username">
			</label>
			<label>Password
				<input type="password" name="password" placeholder="Enter your password">
			</label>
			<button type="submit" class="button success expand">Log in</button>
		</div></form>
		
		<p class="text-center">Don't have an account?<br><a class="button small" data-reveal-id="createAccount" data-reveal-ajax="true" href="createaccount.php">Join the Housing Board</a></p>
	</div><?php } ?>
</div>

<div id="createAccount" class="reveal-modal" data-reveal>
	<!--WILL BE OVERWRITTEN VIA AJAX-->
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
