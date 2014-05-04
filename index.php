<?php
require_once "config.php"; // establish database settings and connection
session_start();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Housing Board</title>
	<link rel="stylesheet" href="css/foundation.css">
	<script src="js/vendor/modernizr.js"></script>
</head>
<body>
<?php require_once "navbar.php"; ?>
<div class="row">
	<div class="large-12 columns">
		<h1>Available housing</h1><hr>
	</div>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
