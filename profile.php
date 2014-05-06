<?php
require_once "config.php"; // establish database settings and connection
session_start();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
	<link rel="stylesheet" href="css/foundation.css">
	<script src="js/vendor/modernizr.js"></script>
</head>
<body>
<?php require_once "navbar.php"; ?>
<div class="row">
<?php
if (!isset($_SESSION['user'])) { ?>
	<div class="large-12 columns">
		<h1>Not logged in</h1><hr>
		<p>You must be logged in to view or edit a profile.</p>
	</div>
<?php
}
else {
	if (!empty($_POST['email']) &&
		!empty($_POST['fname']) &&
		!empty($_POST['lname']) &&
		!empty($_POST['standing']) &&
		$db_connection->query('update users set
			email="' . $_POST['email'] . '",
			fname="' . $_POST['fname'] . '",
			lname="' . $_POST['lname'] . '",
			standing=' . $_POST['standing'] .
			' where username="' . $_SESSION['user'] . '"')) {
		if (!empty($_POST['password']) &&
			!empty($_POST['password2']) &&
			$_POST['password']==$_POST['password2'] &&
			$db_connection->query('update users set password="' . hash('sha512', $_POST['password2']) . '"')) { ?>
	<div data-alert class="alert-box success">
		Password updated.
		<a href="#" class="close">&times;</a>
	</div>
<?php
		}
		else if (!empty($_POST['password']) || !empty($_POST['password2'])) { ?>
	<div data-alert class="alert-box alert">
		Password update failed. Check if they match.
		<a href="#" class="close">&times;</a>
	</div>
<?php
		} ?>
	<div data-alert class="alert-box success">
		Profile updated.
		<a href="#" class="close">&times;</a>
	</div>
<?php
	}
	else if (!empty($_POST)) { ?>
	<div data-alert class="alert-box alert">
		Profile update failed.
		<a href="#" class="close">&times;</a>
	</div>
<?php
	}
	
	$user=$db_connection->query('select * from users where username="' . $_SESSION['user'] . '"')->fetch_assoc(); // get the userdata
	$standing=$user['standing'];
		switch ($user['standing']) {
			case 1:
				$standing="Freshman";
				break;
			case 2:
				$standing="Sophomore";
				break;
			case 3:
				$standing="Junior";
				break;
			case 4:
				$standing="Senior";
				break;
			case 5:
				$standing="Super-senior";
				break;
			case 6:
				$standing="Graduate student";
				break;
			case 7:
				$standing="Faculty, staff or other affiliation";
				break;
		} ?>
	<div class="large-12 columns">
		<h1>Profile</h1><hr>
	</div>
	
	<div class="medium-7 columns">
		<h2>Modify information</h2>
		<div class="panel"><form action="profile.php" method="post">
			<label>Profile picture is managed through <a href="http://gravatar.com/">Gravatar</a></label>
			<label>Username
				<input type="text" name="username" placeholder="Pick a username" value="<?php echo $user['username']; ?>" disabled>
			</label>
			<label>Password
				<input type="password" name="password" placeholder="Type a password if you want to change it">
			</label>
			<label>Confirm password
				<input type="password" name="password2" placeholder="Type the same password">
			</label>
			<label>Email
				<input type="email" name="email" placeholder="Type your email" value="<?php echo $user['email']; ?>" required>
			</label>
			<label>First name
				<input type="text" name="fname" value="<?php echo $user['fname']; ?>" required>
			</label>
			<label>Last name
				<input type="text" name="lname" value="<?php echo $user['lname']; ?>" required>
			</label>
			<label>School standing
				<select name="standing" required>
					<option value="1">Freshman</option>
					<option value="2">Sophomore</option>
					<option value="3">Junior</option>
					<option value="4">Senior</option>
					<option value="5">Super-senior</option>
					<option value="6">Graduate student</option>
					<option value="7">Faculty, staff or other</option>
				</select>
			</label>
			<button type="submit" class="button success expand">Modify information</button>
		</form></div>
	</div>
	<div class="medium-5 columns">
		<h3 class="text-right">Preview</h3>
		<ul class="vcard right text-center">
			<li><img src=<?php echo '"http://www.gravatar.com/avatar/' . md5(strtolower(trim($user['email']))) . '?s=120"'; ?> alt="Gravatar"></li>
			<li class="fn"><?php echo $user['fname'] . "&nbsp;" . $user['lname']; ?></li>
			<li><?php echo $standing; ?></li>
			<li class="email"><a href="<?php echo "mailto:" . $user['email']; ?>">Contact email</a></li>
		</ul>
	</div>
<?php
} ?>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
