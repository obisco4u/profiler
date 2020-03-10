<!DOCTYPE HTML>

<html>
	<head>
		<title>Sign up</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
		<link  rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="index is-preload">
		<?php include_once("template_pageTop2.php"); ?>
		<?php include_once("signup.php"); ?>
		<article id="main">

					<header class="special container">
						<span class="icon solid fa-edit"></span>
						<h2>Join Profiler</h2>
						<p>Fill the form below to Sign Up</p>
					</header>

					<!-- One -->
						<section class="wrapper style4 special container medium">

							<!-- Content -->
								<div class="content">
									<form name="signupform" id="signupform" onsubmit="return false;">
										<div class="row gtr-50">
											<div class="col-12 ">
												<input id="username" type="text" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16" placeholder="Username">
				    							<span id="unamestatus"></span>
											</div>
											<div class="col-12">
												<input id="email" type="text" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88" placeholder="Email">
											</div>
											
											<div class="col-12">
												<input id="pass1" type="password" onfocus="emptyElement('status')" maxlength="16" placeholder="Create Password">
											</div>
											<div class="col-12">
												<input id="pass2" type="password" onfocus="emptyElement('status')" maxlength="16" placeholder="Confirm Password">
											</div>
											<div class="col-12">
												<input id="phone" type="text" onfocus="emptyElement('status')" maxlength="88" placeholder="Phone">
											</div>
											
											<label class="signuplabel">Gender</label>
											<div class="col-12">

												<select id="gender" onfocus="emptyElement('status')">
											      <option value="">Select Gender</option>
											      <option value="m">Male</option>
											      <option value="f">Female</option>
											    </select>
											</div>
											
											<label class="signuplabel">Country</label>
											<div class="col-12">
												<select id="country" onfocus="emptyElement('status')">
				      							<?php include_once("template_country_list.php"); ?>
				    							</select>
											</div>
											<div class="col-12">
												<a href="#" onclick="return false" onmousedown="openTerms()">
				       								View the Terms Of Use
				     							 </a>
											</div>
											<div id="terms" style="display:none;">
										      <h3>Web Intersect Terms Of Use</h3>
										      <p>1. Play nice here.</p>
										      <p>2. Take a bath before you visit.</p>
										      <p>3. Brush your teeth before bed.</p>
										    </div>
											<div class="col-12">
												<button id="signupbtn" class="btn btn-primary" onclick="signup()">Create Account</button>
				    							<span id="status"></span>
											</div>
										</div>
									</form>
								</div>

						</section>

				</article>
		
		<?php include_once("template_pageBottom.php"); ?>
	</body>
			<script src="assets/js/jquery.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="js/main.js"></script>
			<script src="js/ajax.js"></script>
			<script src="js/signup.js"></script>
			<script src="js/autoscroll.js"></script>

</html>