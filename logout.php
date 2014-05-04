<?php
require_once "config.php"; // establish database settings and connection
session_start();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Log out</title>
	<link rel="stylesheet" href="css/foundation.css">
	<script src="js/vendor/modernizr.js"></script>
</head>
<body>
<?php
session_unset();
session_destroy();
setcookie(session_name(), "", time()-3600); // delete the cookie too
?>
<?php require_once "navbar.php"; ?>
<div class="row">
	<div class="large-12 columns">
		<h1>Log out</h1><hr>
		<p>You have successfully logged out.</p>
		<p>Return to the <a href="index.php">Main Page</a>.</p>
	</div>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
