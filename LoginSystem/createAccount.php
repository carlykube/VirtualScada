<?php
session_start();
require_once 'classes\login.php';
$login = new Login();

if(isset($_POST) && isset($_POST['username']) && 
	 isset($_POST['password']) && isset($_POST['email'])) {
	
	//need to add serverside validation
	
	$login->add_user($_POST['username'], $_POST['password'], $_POST['email']);
	
	//stuff for email activation goes here, but until then:
	$login->validate_user($_POST['username'], $_POST['password']);
}
?>

<!doctype html>
<html>
	<head>
		<title>Create Account</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/vendor/modernizr.js"></script>
		<script src="js/foundation.min.js"></script>
		<script src="js/main.js"></script>
		<link rel='stylesheet' type='text/css' href='css/foundation.css' />
		<link rel='stylesheet' type='text/css' href='css/style.css' />
	</head>
	<body>
		<div class='prompt'>
			<h1>Create Account</h1>
			<div class='input'>
				<div class='containter'>
					<form data-abide action='' method='post'>
						<div class="email-field">
							<label>Email
								<input type='email' id='email' name='email' required />
							</label>
							<small class='error'>An valid email address is required.</small>
						</div>
						<div class="email-confirmation-field">
							<label>Confirm Email
								<input type='email' name='email2' data-equalto="email" required/>
							</label>
							<small class='error'>Email addresses did not match</small>
						</div>
						<div class='name-field' id='username'>
							<label>Username
								<input type='text' name='username' oninput='validateUsername(this.value)' required />
							</label>
							<small class="error">Username not available</small>
						</div>
						<div class="password-field">
							<label>Password
								<input type='password' name='password' id='password' pattern="password" required />
							</label>
							<small class='error'>Passwords must be at least 8 characters and contain at least one of each of the following: lowercase letter, uppercase letter, number, and special character.</small>
						</div>
						<div class="password-confirmation-field">
							<label>Confirm password
								<input type='password' name='password2' data-equalto="password" required/>
							</label>
							<small class='error'>Passwords did not match</small>
						</div>
						<input type='submit' value='Create Account' class='button'/>
					</form>
				</div>
			</div>
		</div>
		<script>
			$(document).foundation({
				abide: {
					patterns: {
						password: /(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*+=-]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/
					}
				}
			});
		</script>
	</body>
</html>