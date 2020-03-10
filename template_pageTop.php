<?php include_once("php_includes/check_login_status.php"); ?>
<?php
// It is important for any file that includes this file, to have
// check_login_status.php included at its very top.
$envelope = '';
$loginLink = '<li><a href="login.php">Log In</a> &nbsp;</li> <li>| &nbsp; <a href="sign_up.php">Sign Up</a></li>';
if($user_ok == true) {
	$sql = "SELECT notescheck FROM users WHERE username='$log_username' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$row = mysqli_fetch_row($query);
	$notescheck = $row[0];
	$sql = "SELECT id FROM notifications WHERE username='$log_username' AND date_time > '$notescheck' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
    if ($numrows == 0) {
		$envelope = '<a href="notifications.php" title="Your notifications and friend requests"><span  class="icon solid fa fa-envelope-open" ></span></a>';
    } else {
		$envelope = '<a href="notifications.php" title="You have new notifications"><span  class="icon solid fa fa-envelope-square" style="color:red;"></span> </a>';
		}
    $loginLink = '<li><a href="user.php?u='.$log_username.'">'.$log_username.'</a></li> &nbsp; <li>| &nbsp; <a href="logout.php">Log Out</a></li>';
}
?>
<!-- Header -->
	<header id="header" class="alt">
		<h1 id="logo"><a href="index.php">Profiler</a></h1>
		<nav id="nav">
			<ul>
				<li class="current"><?php echo $envelope; ?> &nbsp; &nbsp;</li>
				<?php echo $loginLink; ?>
				<li class="submenu">
					<a href="#">Layouts</a>
					<ul>
						<li><a href="left-sidebar.html">Left Sidebar</a></li>
						<li><a href="right-sidebar.html">Right Sidebar</a></li>
						<li><a href="no-sidebar.html">No Sidebar</a></li>
						<li><a href="contact.html">Contact</a></li>
						<li class="submenu">
							<a href="#">Submenu</a>
							<ul>
								<li><a href="#">Dolore Sed</a></li>
								<li><a href="#">Consequat</a></li>
								<li><a href="#">Lorem Magna</a></li>
								<li><a href="#">Sed Magna</a></li>
								<li><a href="#">Ipsum Nisl</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<!-- <li><a href="login.php" class="button primary">Login</a></li> -->
			</ul>
		</nav>
	</header>