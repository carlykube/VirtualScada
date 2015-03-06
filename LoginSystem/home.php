<?php
require_once 'classes/login.php';
$login = new Login();

$login->confirm_member();
?>

<!doctype html>
<html>
	<head>
		<title>Home</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<link rel='stylesheet' type='text/css' href='css/foundation.css' />
		<link rel='stylesheet' type='text/css' href='css/style.css' />
	</head>
	<body>
		<h1>Welcome, user</h1>
		<form action="index.php" method="post">
			<input type='hidden' name='logout' />
			<input type='submit' value='Sign Out' class='button tiny' />
		</form>
	</body>
</html>