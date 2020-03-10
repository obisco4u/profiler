<?php 
	include_once("php_includes/check_login_status.php");
	$userlist="";
	$sql_fetch = "SELECT username FROM users WHERE activated='1' ORDER BY RAND() LIMIT 12";
	$query = mysqli_query($db_conx, $sql_fetch);

	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
		$username = $row["username"];
		$userlist .='<a href="user.php?u='.$username.'" title="'.$username.'">'.$username.'</a> <br>';
	
	}
	$sql_fetch = "SELECT COUNT(id) FROM users WHERE activated='1' ";
	$query= mysqli_query($db_conx, $sql_fetch);
	$total_users= mysqli_fetch_array($query);
 ?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>Profiler</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="index is-preload">
		<?php include_once("template_pageTop.php"); ?>
		<?php include_once("banner.php"); ?>
		<div id="main">
			<div class="special container">
				<h3>Users</h3> 
				<br>
				<p><?php  echo $userlist;?></p> <hr>
				<br>
				<h3>Total Users</h3>
				<p><?php echo $total_users[0] ?></p>
			</div>
		</div>
		<?php include_once("template_pageBottom.php"); ?>
	</body>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="js/main.js"></script>
			<script src="js/ajax.js"></script>
			<script src="js/autoscroll.js"></script>

	</html>