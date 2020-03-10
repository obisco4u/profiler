<?php
include_once("php_includes/check_login_status.php");
// Initialize any variables that the page might echo
$u = "";
$sex = "Male";
$userlevel = "";
$country = "";
$joindate = "";
$lastsession = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["u"])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: http://www.yoursite.com");
    exit();	
}
// Select the member from the users table
$sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
	echo "That user does not exist or is not yet activated, press back";
    exit();	
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($u == $log_username && $user_ok == true){
	$isOwner = "yes";
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
	$profile_id = $row["id"];
	$gender = $row["gender"];
	$country = $row["country"];
	$userlevel = $row["userlevel"];
	$signup = $row["signup"];
	$lastlogin = $row["lastlogin"];
	$joindate = strftime("%b %d, %Y", strtotime($signup));
	$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
	if($gender == "f"){
		$sex = "Female";
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $u; ?></title>
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="style/style.css">
		
	</head>
	
	<body>
	<?php include_once("template_pageTop2.php"); ?>
		<div id="pageMiddle" class="wrapper style2 container special-alt">
			  <h3><?php echo $u; ?></h3>
			  <p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>
			  <p>Gender: <?php echo $sex; ?></p>
			  <p>Country: <?php echo $country; ?></p>
			  <p>User Level: <?php echo $userlevel; ?></p>
			  <p>Join Date: <?php echo $joindate; ?></p>
			  <p>Last Session: <?php echo $lastsession; ?></p>
				
		</div>
	
		<a href="logout.php"><button id="logoutbtn">Log Out</button></a>
	
	
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

