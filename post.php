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
<?php if (empty($_POST)) {
	if (isset($_GET['action']) && $_GET['action']=="add") { // add post interface ?>
	<div class="large-12 columns">
		<h1>Add post</h1><hr>
	</div>
	<div class="large-12 columns"><form action="post.php?action=add" method="post"><div class="panel">
		<input type="hidden" name="post_date" value=<?php echo '"' . date("Y-m-d") . '"'; ?>>
		<label>Name of complex (if applicable)
			<input type="text" name="complex">
		</label>
		<label>Street address
			<input type="text" name="addr" required>
		</label>
		<div class="row">
			<div class="medium-4 columns"><label>City
				<input type="text" name="city" required>
			</label></div>
			<div class="medium-4 columns"><label>State (two-letter abbreviation)
				<input type="text" name="state" required>
			</label></div>
			<div class="medium-4 columns"><label>Post/ZIP code
				<input type="text" name="postcode" required>
			</label></div>
		</div>
		<label>Type of deal
			<select name="type" required>
				<option name="Sublet">Sublet</option>
				<option name="Take-over">Take-over</option>
				<option name="Roommates needed">Roommates needed</option>
			</select>
		</label>
		<div class="row">
			<div class="medium-6 columns"><label>Start date
				<input type="date" name="start" placeholder="YYYY-MM-DD" required>
			</label></div>
			<div class="medium-6 columns"><label>End date
				<input type="date" name="end" placeholder="YYYY-MM-DD" required>
			</label></div>
		</div>
		<div class="row">
			<div class="medium-6 large-4 columns"><label>Bedrooms
				<input type="number" name="bedrooms" placeholder="0 = studio/efficiency, 1+ = number of rooms" required>
			</label></div>
			<div class="medium-6 large-4 columns"><label>Volume
				<div class="row collapse">
					<div class="small-11 columns"><input type="number" name="volume"></div>
					<div class="small-1 columns"><span class="postfix">ft²</span></div>
				</div>
			</label></div>
			<div class="medium-12 large-4 columns"><label>Price
				<div class="row collapse">
					<div class="small-1 columns"><span class="prefix">$</span></div>
					<div class="small-11 columns"><input type="text" name="price" required></div>
				</div>
			</label></div>
		</div>
		<label>Included in rent</label>
			<input type="checkbox" name="included[]" value="Heat" id="checkHeat"><label for="checkHeat">Heat</label>
			<input type="checkbox" name="included[]" value="Electric" id="checkElectric"><label for="checkElectric">Electric</label>
			<input type="checkbox" name="included[]" value="Water" id="checkWater"><label for="checkWater">Water</label>
			<input type="checkbox" name="included[]" value="Waste disposal" id="checkWaste"><label for="checkWaste">Waste disposal</label>
			<input type="checkbox" name="included[]" value="Transit pass" id="checkTransit"><label for="checkTransit">Transit pass</label>
			<input type="checkbox" name="included[]" value="Cable" id="checkCable"><label for="checkCable">Cable</label>
			<input type="checkbox" name="included[]" value="Internet" id="checkInternet"><label for="checkInternet">Internet</label>
			<input type="checkbox" name="included[]" value="Full furnishings" id="checkFurnish"><label for="checkFurnish">Full furnishings</label>
			<input type="checkbox" name="included[]" value="Parking" id="checkParking"><label for="checkParking">Parking</label>
			<input type="checkbox" name="included[]" value="Fitness centre" id="checkGym"><label for="checkGym">Fitness centre</label>
			<input type="checkbox" name="included[]" value="Pool" id="checkPool"><label for="checkPool">Pool</label>
		<label>Description
			<textarea name="description"></textarea>
		</label>
		<button type="submit" name="user" value=<?php echo '"' . $_SESSION['user'] . '"'; ?> class="button">Create post</button>
	</div></form></div>
<?php
	}
	else if (isset($_GET['id'])) {
		$post=$db_connection->query('select * from posts where post_id="' . $_GET['id'] . '"')->fetch_assoc();
		$displayname=$post['name'];
		if (empty($post['name'])) {
			$displayname=$post['addr'];
		}
		$start_o=new DateTime($post['start']);
		$end_o=new DateTime($post['end']); ?>
	<div class="large-12 columns">
		<h1><?php echo $displayname . " " . strtolower($post['type']) . " " . $start_o->format("F Y") . "&ndash;" . $end_o->format("F Y"); ?></h1><hr>
		<p><?php echo basename(__FILE__)=="post.php"; ?></p>
	</div>
<?php
	}
	else { // invalid ?>
	<div class="large-12 columns">
		<h1>Error</h1><hr>
		<p>This page doesn't do anything by itself.</p>
		<p>Go back and reconsider what you were doing.</p>
	</div>
<?php
	}
}
else { // executing add, modify or delete post
	switch ($_GET['action']) {
		case "add":
			$id_hash=hash('sha1', time() . $_POST['user']); // generate unique identifier
			$included=implode(",", $_POST['included']); // stringify
			$bedrooms=NULL; // prepare for converting number representation to words
			if ($_POST['bedrooms']<=0) { // studio or efficiency
				$bedrooms="Efficiency";
			}
			else if ($_POST['bedrooms']==1) {
				$bedrooms="1 bedroom";
			}
			else {
				$bedrooms=$_POST['bedrooms'] . " bedrooms";
			}
			
			$query='insert into posts set '; // prepare query, with individual fields concatenated in below
			$query.='post_id="' . $id_hash . '", ';
			$query.='post_date="' . $_POST['post_date'] . '", ';
			if (!empty($_POST['complex'])) {
				$query.='name="' . $_POST['complex'] . '", ';
			}
			$query.='addr="' . $_POST['addr'] . '", ';
			$query.='city="' . $_POST['city'] . '", ';
			$query.='state="' . $_POST['state'] . '", ';
			$query.='postcode=' . $_POST['postcode'] . ', ';
			$query.='type="' . $_POST['type'] . '", ';
			$query.='start="' . $_POST['start'] . '", ';
			$query.='end="' . $_POST['end'] . '", ';
			$query.='bedrooms="' . $bedrooms . '", ';
			if (!empty($_POST['volume'])) {
				$query.='volume=' . $_POST['volume'] . ', ';
			}
			$query.='price=' . $_POST['price'] . ', ';
			if (!empty($_POST['included'])) {
				$query.='included="' . $included . '", ';
			}
			if (!empty($_POST['description'])) {
				$query.='description="' . $_POST['description'] . '", ';
			}
			$query.='username="' . $_POST['user'] . '"';
			
			if (!empty($_POST['post_date']) &&
				!empty($_POST['addr']) &&
				!empty($_POST['city']) &&
				!empty($_POST['state']) &&
				!empty($_POST['postcode']) &&
				!empty($_POST['type']) &&
				!empty($_POST['start']) &&
				!empty($_POST['end']) &&
				!empty($_POST['bedrooms']) &&
				!empty($_POST['price']) &&
				!empty($_POST['user']) &&
				$db_connection->query($query)) { // with required fields, success state ?>
	<div class="large-12 columns">
		<h1>Add post</h1><hr>
		<p>Your post is now publicly available.</p>
		<p><a href="post.php?id=<?php echo $id_hash; ?>">View it</a>.</p>
	</div>
<?php
			}
			else { // failure state ?>
	<div class="large-12 columns">
		<h1>Add failed</h1><hr>
		<p>Your post could not be posted due to errors.</p>
		<p>There may have been missing required fields. A database problem is also possible.</p>
		<p>Go back and try again.</p>
	</div>
<?php
			}
			break;
	}
} ?>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
