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
		<input type="hidden" name="post_date" value="<?php echo date("Y-m-d"); ?>">
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
	else if (isset($_GET['action']) && $_GET['action']=="modify") { // modify post interface
		$post=$db_connection->query('select * from posts where post_id="' . $_GET['id'] . '"')->fetch_assoc();
		if ($post['username']!=$_SESSION['user']) { ?>
	<div class="large-12 columns">
		<h1>Modify denied</h1><hr>
		<p>You are not the poster.</p>
		<p>Return to <a href=".">Main Page</a>.</p>
	</div>
<?php
		}
		else {
			$bedrooms=$post['bedrooms'];
			if ($post['bedrooms']=="Efficiency") {
				$bedrooms=0;
			}
			else {
				$bedrooms=substr($post['bedrooms'], 0, 1);
			} ?>
	<div class="large-12 columns">
		<h1>Modify post</h1><hr>
	</div>
	<div class="large-12 columns"><form action="post.php?action=modify" method="post"><div class="panel">
		<input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">
		<label>Name of complex (if applicable)
			<input type="text" name="complex" value="<?php echo $post['name']; ?>">
		</label>
		<label>Street address
			<input type="text" name="addr" value="<?php echo $post['addr']; ?>" required>
		</label>
		<div class="row">
			<div class="medium-4 columns"><label>City
				<input type="text" name="city" value="<?php echo $post['city']; ?>" required>
			</label></div>
			<div class="medium-4 columns"><label>State (two-letter abbreviation)
				<input type="text" name="state" value="<?php echo $post['state']; ?>" required>
			</label></div>
			<div class="medium-4 columns"><label>Post/ZIP code
				<input type="text" name="postcode" value="<?php echo $post['postcode']; ?>" required>
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
				<input type="date" name="start" placeholder="YYYY-MM-DD" value="<?php echo $post['start']; ?>" required>
			</label></div>
			<div class="medium-6 columns"><label>End date
				<input type="date" name="end" placeholder="YYYY-MM-DD" value="<?php echo $post['end']; ?>" required>
			</label></div>
		</div>
		<div class="row">
			<div class="medium-6 large-4 columns"><label>Bedrooms
				<input type="number" name="bedrooms" placeholder="0 = studio/efficiency, 1+ = number of rooms" value="<?php echo $bedrooms; ?>" required>
			</label></div>
			<div class="medium-6 large-4 columns"><label>Volume
				<div class="row collapse">
					<div class="small-11 columns"><input type="number" name="volume" value="<?php echo $post['volume']; ?>"></div>
					<div class="small-1 columns"><span class="postfix">ft²</span></div>
				</div>
			</label></div>
			<div class="medium-12 large-4 columns"><label>Price
				<div class="row collapse">
					<div class="small-1 columns"><span class="prefix">$</span></div>
					<div class="small-11 columns"><input type="text" name="price" value="<?php echo $post['price']; ?>" required></div>
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
			<textarea name="description"><?php echo $post['description']; ?></textarea>
		</label>
		<button type="submit" class="button">Modify post</button>
		<button type="submit" formaction="post.php?action=delete" class="button alert">Delete post</button>
	</div></form></div>
<?php 
		}
	}
	else if (isset($_GET['id']) && !isset($_GET['action'])) {
		$post=$db_connection->query('select * from posts where post_id="' . $_GET['id'] . '"')->fetch_assoc();
		$displayname=$post['name'];
		if (empty($post['name'])) {
			$displayname=$post['addr'];
		}
		$posted_o=new DateTime($post['post_date']);
		$start_o=new DateTime($post['start']);
		$end_o=new DateTime($post['end']);
		
		$poster=$db_connection->query('select email, fname, lname, standing from users where username="' . $post['username'] . '"')->fetch_assoc();
		$standing=$poster['standing'];
		switch ($poster['standing']) {
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
		<h1><?php echo $displayname . " " . strtolower($post['type']) . " " . $start_o->format("F Y") . "&ndash;" . $end_o->format("F Y"); ?></h1><hr>
		<div class="row">
			<!--address-->
			<div class="medium-6 columns"><ul class="vcard">
<?php
		if (!empty($post['name'])) { ?>
				<li class="fn"><?php echo $post['name']; ?></li>
<?php
		} ?>
				<li class="street-address"><?php echo $post['addr']; ?></li>
				<li class="locality"><?php echo $post['city']; ?>, <span class="state"><?php echo $post['state']; ?></span> <span class="zip"><?php echo $post['postcode']; ?></span></li>
			</ul></div>
			
			<!--poster information-->
			<div class="medium-6 columns"><ul class="vcard right text-center">
				<li><img src=<?php echo '"http://www.gravatar.com/avatar/' . md5(strtolower(trim($poster['email']))) . '?s=120"'; ?> alt="Gravatar"></li>
				<li class="fn"><?php echo $poster['fname'] . "&nbsp;" . $poster['lname']; ?></li>
				<li><?php echo $standing; ?></li>
				<li class="email"><a href="<?php echo "mailto:" . $poster['email']; ?>">Contact email</a></li>
			</ul></div>
		</div>
		<p>Size: <?php echo $post['bedrooms']; if (!empty($post['volume'])) { echo ", " . $post['volume'] . "&nbsp;ft²"; } ?></p>
		<p>Price: <?php echo "$" . $post['price'] . "/month"; ?></p>
<?php
		if (!empty($post['included'])) {
			$included=explode(",", $post['included']);
			echo "<p>Included in rent:</p>\n<ul>\n";
			foreach ($included as $amenity) {
				echo "<li>" . $amenity . "</li>\n";
			}
			echo "</ul>\n";
		} ?>
		<p>Term goes from <?php echo $start_o->format('j F Y'); ?> to <?php echo $end_o->format('j F Y'); ?></p>
<?php
		if (!empty($post['description'])) {
			$description=explode("\n", htmlentities($post['description'])); // parse description as one HTML-sanitised paragraph per array element ?>
		<h3>Additional comments by poster</h3>
<?php
			foreach ($description as $paragraph) {
				echo "<p>" . $paragraph . "</p>\n";
			}
		} ?>
		<p><small><em>Posted on <?php echo $posted_o->format('j F Y'); ?></em></small></p>
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
		
		case "modify":
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
			
			$query='update posts set '; // prepare query, with individual fields concatenated in below
			if (!empty($_POST['complex'])) {
				$query.='name="' . $_POST['complex'] . '", ';
			}
			else {
				$query.='name=NULL, ';
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
			else {
				$query.='volume=NULL, ';
			}
			$query.='price=' . $_POST['price'] . ', ';
			if (!empty($_POST['included'])) {
				$query.='included="' . $included . '", ';
			}
			else {
				$query.='included=NULL, ';
			}
			if (!empty($_POST['description'])) {
				$query.='description="' . $_POST['description'] . '" ';
			}
			else {
				$query.='description=NULL ';
			}
			$query.='where post_id="' . $_POST['post_id'] . '"';
			
			if (!empty($_POST['addr']) &&
				!empty($_POST['city']) &&
				!empty($_POST['state']) &&
				!empty($_POST['postcode']) &&
				!empty($_POST['type']) &&
				!empty($_POST['start']) &&
				!empty($_POST['end']) &&
				!empty($_POST['bedrooms']) &&
				!empty($_POST['price']) &&
				$db_connection->query($query)) { // with required fields, success state ?>
	<div class="large-12 columns">
		<h1>Modify succeeded</h1><hr>
		<p>Your post has been successfully modified.</p>
		<p><a href="post.php?id=<?php echo $_POST['post_id']; ?>">View it</a>.</p>
	</div>
<?php
			}
			else { // failure state ?>
	<div class="large-12 columns">
		<h1>Modify failed</h1><hr>
		<p>Your post could not be modified due to errors.</p>
		<p>There may have been missing required fields. A database problem is also possible.</p>
		<p>You may not even be the poster!</p>
		<p>Go back and try again.</p>
	</div>
<?php
			}
			break;
		
		case "delete":
			if (!empty($db_connection->query('select * from posts where post_id="' . $_POST['post_id'] . '"')->fetch_assoc()) && $db_connection->query('delete from posts where post_id="' . $_POST['post_id'] . '"')) { ?>
	<div class="large-12 columns">
		<h1>Post deleted</h1><hr>
		<p>Your post has been successfully deleted.</p>
		<p>Return to <a href=".">Main Page</a></p>
	</div>
<?php
			}
			else { ?>
	<div class="large-12 columns">
		<h1>Delete failed</h1><hr>
		<p>Post could not be deleted.</p>
		<p>The post may no longer exist. A database problem is also possible.</p>
		<p>Go back and try again.</p>
	</div>
<?php
			}
			break;
		
		default: ?>
	<div class="large-12 columns">
		<h1>Error</h1><hr>
		<p>You inputted an invalid command.</p>
		<p>Go back and reconsider what you were doing.</p>
	</div>
<?php
	}
} ?>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
