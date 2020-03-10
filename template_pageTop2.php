<?php include_once("php_includes/check_login_status.php"); ?>
<?php
// It is important for any file that includes this file, to have
// check_login_status.php included at its very top.
$envelope = '';
$loginLink = '<li class="navbar-item" ><a class="nav-link" href="login.php">Log In</a></li> <li class="nav-item"> <a class="nav-link" href="sign_up.php">Sign Up</a></li>';
if($user_ok == true) {
	$sql = "SELECT notescheck FROM users WHERE username='$log_username' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$row = mysqli_fetch_row($query);
	$notescheck = $row[0];
	$sql = "SELECT id FROM notifications WHERE username='$log_username' AND date_time > '$notescheck' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
    if ($numrows == 0) {
		$envelope = '<a href="notifications.php" title="Your notifications and friend requests" class="nav-link"><span  class="icon solid fa fa-envelope-open" ></span></a>';
    } else {
		$envelope = '<a class="nav-link" href="notifications.php" title="You have new notifications"><span  class="icon solid fa fa-envelope-square" style="color:red;"></span> </a>';	
	}
	$loginLink = '<li class="navbar-item"><a href="user.php?u='.$log_username.'" class="nav-link">'.$log_username.'</a></li> <li class="nav-item"> <a class="nav-link" href="logout.php">Log Out</a></li>';
}
?>
<header>
	 <nav class="navbar navbar-light bg-light navbar-expand-lg fixed-top">
	    <a href="index.php" class="navbar-brand">Profiler</a>
	    <button class="navbar-toggler" data-toggle="collapse" data-target="#navmenu"><span class="navbar-toggler-icon"></span></button>
	    <div class="collapse navbar-collapse" id="navmenu">
	      <ul class="navbar-nav ml-auto">
	        <li class="navbar-item"><?php echo $envelope;?></li>
	        <?php echo $loginLink; ?>
	        <!-- <li class="navbar-item"><a href="" class="nav-link">Link1</a></li> -->
	      </ul>
	    </div>
	</nav>
</header>