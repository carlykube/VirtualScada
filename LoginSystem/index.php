<?php
session_start();
require_once 'classes\login.php';
$login = new Login();

if(isset($_POST)) {
	if(isset($_POST['logout'])) {
		$login->logout();
	}

	//Did the user click create
	if (isset($_POST['create'])) {
		header('location: createAccount.php');
	}
	// Did the user enter a username and password
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$response = $login->validate_user($_POST['username'], $_POST['password']);
  }
}
?>

<!doctype html>
<html>
	<head>
		<title>Welcome</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/js/vendor/modernizr.js"></script>
		<script src="js/foundation.min.js"></script>
		<script src="js/foundation/foundation.alert.js"></script>

		<link rel='stylesheet' type='text/css' href='css/foundation.css' />
		<link rel='stylesheet' type='text/css' href='css/style.css' />
	</head>
	<body>
		<div class="input">
			<div class='container'>
				<img src='http://www.traveltechnologyupdate.com/picts/Logos/Sabre_lg_350x.jpg' alt='logo'>
				<ul>
					<li>Plan A Trip</li>
					<li>Browse Activities</li>
					<li>Pre-planned Trips</li>
					<li>About Us</li>
				</ul>
			</div>
		</div>

		<div class='prompt'>
			<div class='input'>
				<div class='containter'>
					<form method='post' action='' onchange="return validateForm();"/>
						<?php 
							if(isset($response)) {
							  echo "<div data-alert class='alert-box alert radius'>";
							  echo $response;
							  echo "<a href='#' class='close'>&times;</a></div>";
							}
						?>
						<input type='text' name='username' placeholder='Username' />
						<input type='password' name='password' placeholder='Password' />
						<input type='submit' name='login' value='Sign In' class='button' />
						<input type='submit' name='create' value='Create Account' class='button'/>
					</form>
					<a href='forgotPassword.php'>Forgot Password?</a>
				</div>
			</div>
		</div>
		<script>$(document).foundation();</script>
	</body>
</html>

plan a trip
browse activites
preplanned trips
about us