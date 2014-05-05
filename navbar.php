<nav class="top-bar" data-topbar>
	<ul class="title-area">
		<li class="name"><h1><a href="index.php">Housing Board</a></h1></li>
		<li class="toggle-topbar menu-icon"><a href="#"></a></li>
	</ul>
	
	<section class="top-bar-section">
		<ul class="right">
			<?php if (isset($_SESSION['user'])) { ?><li class="has-dropdown">
				<a><img src=<?php echo '"http://www.gravatar.com/avatar/' . md5(strtolower(trim($_SESSION['email']))) . '?s=25"'; ?> alt="Gravatar">&nbsp;<?php echo $_SESSION['dname']; ?></a>
				<ul class="dropdown">
					<li><a href="profile.php">Profile</a></li>
					<li><a href="logout.php">Log out</a></li>
				</ul>
			</li><?php }
			else { ?><li<?php if (basename($_SERVER['REQUEST_URI'])=="login.php") { ?> class="active"<?php } ?>><a href="login.php">Log in / Create account</a></li><?php } ?>
		</ul>
		
		<?php if (isset($_SESSION['user'])) { ?><ul class="left">
			<li<?php if (basename($_SERVER['REQUEST_URI'])=="post.php?action=add") { ?> class="active"<?php } ?>><a href="post.php?action=add">New post</a></li>
			<?php if (isset($_GET['id']) && basename($_SERVER['SCRIPT_NAME'])=="post.php" && $db_connection->query('select username from posts where post_id="' . $_GET['id'] . '"')->fetch_assoc()['username']==$_SESSION['user']) { ?><li<?php if (isset($_GET['action']) && $_GET['action']=="modify") { ?> class="active"<?php } ?>><a href="post.php?action=modify&id=<?php echo $_GET['id']; ?>">Edit</a></li><?php } // show edit in navbar if post belongs to logged-in user ?>
		</ul><?php } ?>
	</section>
</nav>
