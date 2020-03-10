<?php
include_once("php_includes/check_login_status.php");
// Initialize any variables that the page might echo
$u = "";
$sex = "Male";
$userlevel = "";
$profile_pic = "";
$profile_pic_btn = "";
$avatar_form = "";
$country = "";
$joindate = "";
$lastsession = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["u"])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("index.php");
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
	$profile_pic_btn =  '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
						    Change Profile pic
						  </button>';

	$avatar_form  = '<form id="avatar_form" enctype="multipart/form-data" method="post" action="php_parsers/photo_system.php">';
	$avatar_form .=   '<h4>Change your avatar</h4>';
	$avatar_form .=   '<input type="file" name="avatar" required>';
	$avatar_form .=   '<p><input type="submit" value="Upload" class="btn btn-primary"></p>';
	$avatar_form .= '</form>';
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
	$profile_id = $row["id"];
	$gender = $row["gender"];
	$country = $row["country"];
	$phone = $row["phone"];
	$userlevel = $row["userlevel"];
	$avatar = $row["avatar"];
	$signup = $row["signup"];
	$lastlogin = $row["lastlogin"];
	$joindate = strftime("%b %d, %Y", strtotime($signup));
	$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
}
if($gender == "f"){
	$sex = "Female";
}
$profile_pic = 'src="user/'.$u.'/'.$avatar.'" alt="'.$u.'"';
if($avatar == NULL){
	$profile_pic = 'src="images/avatardefault.jpg" alt="'.$u.'"';
}
?><?php
$isFriend = false;
$ownerBlockViewer = false;
$viewerBlockOwner = false;
if($u != $log_username && $user_ok == true){
	$friend_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$u' AND accepted='1' OR user1='$u' AND user2='$log_username' AND accepted='1' LIMIT 1";
	if(mysqli_num_rows(mysqli_query($db_conx, $friend_check)) > 0){
        $isFriend = true;
    }
	$block_check1 = "SELECT id FROM blockedusers WHERE blocker='$u' AND blockee='$log_username' LIMIT 1";
	if(mysqli_num_rows(mysqli_query($db_conx, $block_check1)) > 0){
        $ownerBlockViewer = true;
    }
	$block_check2 = "SELECT id FROM blockedusers WHERE blocker='$log_username' AND blockee='$u' LIMIT 1";
	if(mysqli_num_rows(mysqli_query($db_conx, $block_check2)) > 0){
        $viewerBlockOwner = true;
    }
}
?><?php 
$friend_button = '<button class="btn btn-light" disabled>Request As Friend</button>';
$block_button = '<button class="btn btn-light" disabled>Block User</button>';
// LOGIC FOR FRIEND BUTTON
if($isFriend == true){
	$friend_button = '<button class="btn-danger" onclick="friendToggle(\'unfriend\',\''.$u.'\',\'friendBtn\')">Unfriend</button>';
} else if($user_ok == true && $u != $log_username && $ownerBlockViewer == false){
	$friend_button = '<button class=" btn btn-success" onclick="friendToggle(\'friend\',\''.$u.'\',\'friendBtn\')">Request As Friend</button>';
}
// LOGIC FOR BLOCK BUTTON
if($viewerBlockOwner == true){
	$block_button = '<button class="btn-warning" onclick="blockToggle(\'unblock\',\''.$u.'\',\'blockBtn\')">Unblock User</button>';
} else if($user_ok == true && $u != $log_username){
	$block_button = '<button class= "btn btn-danger"onclick="blockToggle(\'block\',\''.$u.'\',\'blockBtn\')">Block User</button>';
}
?><?php
$friendsHTML = '';
$friends_view_all_link = '';
$sql = "SELECT COUNT(id) FROM friends WHERE user1='$u' AND accepted='1' OR user2='$u' AND accepted='1'";
$query = mysqli_query($db_conx, $sql);
$query_count = mysqli_fetch_row($query);
$friend_count = $query_count[0];
if($friend_count < 1){
	$friendsHTML = $u." has no friends yet";
} else {
	$max = 18;
	$all_friends = array();
	$sql = "SELECT user1 FROM friends WHERE user2='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_conx, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user1"]);
	}
	$sql = "SELECT user2 FROM friends WHERE user1='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_conx, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user2"]);
	}
	$friendArrayCount = count($all_friends);
	if($friendArrayCount > $max){
		array_splice($all_friends, $max);
	}
	if($friend_count > $max){
		$friends_view_all_link = '<a href="view_friends.php?u='.$u.'">view all</a>';
	}
	$orLogic = '';
	foreach($all_friends as $key => $user){
			$orLogic .= "username='$user' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$sql = "SELECT username, avatar FROM users WHERE $orLogic";
	$query = mysqli_query($db_conx, $sql);
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$friend_username = $row["username"];
		$friend_avatar = $row["avatar"];
		if($friend_avatar != ""){
			$friend_pic = 'user/'.$friend_username.'/'.$friend_avatar.'';
		} else {
			$friend_pic = 'images/avatardefault.jpg';
		}
		$friendsHTML .= '<a href="user.php?u='.$friend_username.'"><img class="friendpics" src="'.$friend_pic.'" alt="'.$friend_username.'" title="'.$friend_username.'"></a>';
	}
}
?><?php 
$coverpic = "";
$sql = "SELECT filename FROM photos WHERE user='$u' ORDER BY RAND() LIMIT 1";
$query = mysqli_query($db_conx, $sql);
if(mysqli_num_rows($query) > 0){
	$row = mysqli_fetch_row($query);
	$filename = $row[0];
	$coverpic = 'src="user/'.$u.'/'.$filename.'" alt="pic"';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $u; ?></title>
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
		<link  rel="stylesheet" href="css/bootstrap.min.css" >
		<!-- <link rel="stylesheet" type="text/css" href="css/materialize.css"> -->

		
		<!-- <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript> -->
		<link rel="stylesheet" href="css/style.css">
	</head>
	
	<body class="index is-preload">
		<div id="main" class="container" >
		<?php include_once("template_pageTop2.php"); ?>
		<!-- The page content starts here -->
			<div class="row" id="row1"> 
				<div  class=" col-sm-4 container-fluid text-center">
					<h2><?php echo $u; ?></h2>
					<img  <?php echo $profile_pic; ?> class=" img-thumbnail img-fluid">
					<p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>

					<div class="container mt-3">
						 <!--  <h2>Modal Example</h2> -->
						  <!-- Button to Open the Modal -->
						    <?php echo $profile_pic_btn; ?>
					

						  <!-- The Modal -->
						  <div class="modal fade" id="myModal">
						    <div class="modal-dialog">
						      <div class="modal-content">
						      
						        <!-- Modal Header -->
						        <div class="modal-header">
						         <!--  <h4 class="modal-title">Modal Heading</h4> -->
						         <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
						        </div>
						        
						        <!-- Modal body -->
						        <div class="modal-body">
						          <?php echo $avatar_form; ?>
						        </div>
						        
						        <!-- Modal footer -->
						        <div class="modal-footer">
						        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						        </div>
						        
						      </div>
						    </div>
						  </div> 
						  <!-- modal end -->
						  
						</div>
				</div>
				<div class="col-sm-8">
					
				 
					<div id="photo_showcase" >
						<label><?php echo $u."'s";?> Gallery </label><br>
						<img class="img-fluid ml-auto" id="coverpic" onclick="window.location = 'photos.php?u=<?php echo $u; ?>';" title="view <?php echo $u; ?>&#39;s photo galleries"  <?php echo $coverpic; ?> >
					</div>
				</div>
			</div>
			<div class="row" id="row2">
				<div>
					<h4>About <?php echo $u;?> </h4> <hr>
					  <p>Gender: <?php echo $sex; ?></p>
					  <p>Country: <?php echo $country; ?></p>
					  <p>Phone: <?php echo $phone; ?></p>
					  <p>User Level: <?php echo $userlevel; ?></p>
					  <p>Join Date: <?php echo $joindate; ?></p>
					  <p>Last Session: <?php echo $lastsession; ?></p>
					  <hr />
					  <p>Friend Button: <span id="friendBtn"><?php echo $friend_button; ?></span> 
					  <br>
					  <?php echo $u." has ".$friend_count." friends"; ?> 
					  <br>
					  <?php echo $friends_view_all_link; ?></p>
					  <p>Block Button:<span id="blockBtn"><?php echo $block_button; ?></span></p>
					  <hr />
		        </div>
			</div>
			<div class=" row wrapper style3" id="row3">
				<h4><?php echo $u."'s";?> friends</h4>
				<div class="col-sm-12">
					<hr>
				<p><?php echo $friendsHTML; ?></p>
				<hr>
				</div>
			</div>
			<div class="row" id="row4">
				<div class="col-sm-12">
					<?php include_once("template_status.php"); ?>
					<a href="logout.php"><button id="logoutbtn">Log Out</button></a>
				</div>
			</div>
		<?php include_once("template_pageBottom.php"); ?>
	</body>
			<script src="assets/js/jquery.min.js"></script>
			<script src="js/materialize.js"></script>
			<script src="js/bootstrap.min.js"></script>
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
			<script type="text/javascript">
				
				function friendToggle(type,user,elem){
					var conf = confirm("Press OK to confirm the '"+type+"' action for user <?php echo $u; ?>.");
					if(conf != true){
						return false;
					}
					_(elem).innerHTML = 'please wait ...';
					var ajax = ajaxObj("POST", "php_parsers/friend_system.php");
					ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
					if(ajax.responseText == "friend_request_sent"){
						_(elem).innerHTML = 'OK Friend Request Sent';
					} else if(ajax.responseText == "unfriend_ok"){
						_(elem).innerHTML = '<button onclick="friendToggle(\'friend\',\'<?php echo $u; ?>\',\'friendBtn\')">Request As Friend</button>';
					} else {
						alert(ajax.responseText);
						_(elem).innerHTML = 'Try again later';
					}
				}
				}
				ajax.send("type="+type+"&user="+user);
				}
				function blockToggle(type,blockee,elem){
					var conf = confirm("Press OK to confirm the '"+type+"' action on user <?php echo $u; ?>.");
					if(conf != true){
						return false;
					}
					var elem = document.getElementById(elem);
					elem.innerHTML = 'please wait ...';
					var ajax = ajaxObj("POST", "php_parsers/block_system.php");
					ajax.onreadystatechange = function() {
						if(ajaxReturn(ajax) == true) {
							if(ajax.responseText == "blocked_ok"){
								elem.innerHTML = '<button onclick="blockToggle(\'unblock\',\'<?php echo $u; ?>\',\'blockBtn\')">Unblock User</button>';
							} else if(ajax.responseText == "unblocked_ok"){
								elem.innerHTML = '<button onclick="blockToggle(\'block\',\'<?php echo $u; ?>\',\'blockBtn\')">Block User</button>';
							} else {
								alert(ajax.responseText);
								elem.innerHTML = 'Try again later';
							}
						}
					}
					ajax.send("type="+type+"&blockee="+blockee);
				}
			</script>
</html>
