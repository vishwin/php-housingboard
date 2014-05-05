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
		
<?php
if ($date_query=$db_connection->query('select post_date from posts')) {
	while ($date_u=$date_query->fetch_assoc()) {
		$date=new DateTime($date_u['post_date']);
		printf("\t\t<h3>%s</h3>\n", $date->format('j F Y'));
		
		if ($post_query=$db_connection->query('select post_id, name, city, state, type, start, end, bedrooms, price from posts')) { ?>
		<ul>
<?php
			while ($post=$post_query->fetch_assoc()) { ?>
<?php
				$start_o=new DateTime($post['start']);
				$end_o=new DateTime($post['end']); ?>
			<li><?php echo '<a href="post.php?id=' . $post['post_id'] . '">' . $post['name'] . " " . $post['type'] . " " . $start_o->format('F Y') . "&ndash;" . $end_o->format('F Y') . "</a>"; ?>&nbsp;&ndash;&nbsp;<span class="secondary label">$<?php echo $post['price']; ?></span>/<?php echo $post['bedrooms']; ?>&nbsp;&ndash;&nbsp;<small>(<?php echo $post['city'] . ", " . $post['state']; ?>)</small></li>
<?php
			} ?>
		</ul>
<?php
		}
	}
}
?>
	</div>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
