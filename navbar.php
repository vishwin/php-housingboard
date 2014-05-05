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
			else { ?><li><a href="login.php">Log in / Create account</a></li><?php } ?>
		</ul>
		
		<?php if (isset($_SESSION['user'])) { ?><ul class="left">
			<li><a href="add.php">Post</a></li>
		</ul><?php } ?>
	</section>
</nav>
