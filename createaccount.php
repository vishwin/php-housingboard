<?php
require_once "config.php";
if (!empty($_POST)) { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create account</title>
	<link rel="stylesheet" href="css/foundation.css">
	<script src="js/vendor/modernizr.js"></script>
</head>
<body>
<?php include_once "navbar.php"; ?>
<div class="row">
	<div class="large-12 columns">
		<h1>Create account</h1><hr>
<?php if (!empty($_POST['username']) &&
		!empty($_POST['password']) &&
		$_POST['password']==$_POST['password2'] &&
		!empty($_POST['email']) &&
		!empty($_POST['fname']) &&
		!empty($_POST['lname']) &&
		!empty($_POST['standing']) &&
		$db_connection->query('insert into users values (
			"' . $_POST['username'] . '",
			"' . hash('sha512', $_POST['password2']) . '",
			"' . $_POST['email'] . '",
			"' . $_POST['fname'] . '",
			"' . $_POST['lname'] . '",
			' . $_POST['standing'] .
			')')) { // all fields required, success state ?>
		<p>Account successfully created.</p>
		<p>You can now <a href="login.php">log in</a>.</p>
<?php }
	else { ?>
		<p>Fields entered are incorrect, missing or matches an already-existing username.  All fields are required.</p>
		<p>It is also possible that a database error occurred.</p>
		<p>Go back and try again.</p>
<?php } ?>
	</div>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
<?php }
else { // in the modal ?>
<h2>Create account</h2>
<form action="createaccount.php" method="post">
	<label>Username
		<input type="text" name="username" placeholder="Pick a username">
	</label>
	<label>Password
		<input type="password" name="password" placeholder="Type a password">
	</label>
	<label>Confirm password
		<input type="password" name="password2" placeholder="Type the same password">
	</label>
	<label>Email
		<input type="email" name="email" placeholder="Type your email">
	</label>
	<label>First name
		<input type="text" name="fname">
	</label>
	<label>Last name
		<input type="text" name="lname">
	</label>
	<label>School standing
		<select name="standing">
			<option value="1">Freshman</option>
			<option value="2">Sophomore</option>
			<option value="3">Junior</option>
			<option value="4">Senior</option>
			<option value="5">Super-senior</option>
			<option value="6">Graduate student</option>
			<option value="7">Faculty, staff or other</option>
		</select>
	</label>
	<button type="submit" class="button success expand">Create your account</button>
</form>
<a class="close-reveal-modal">&#215;</a>
<?php } ?>
