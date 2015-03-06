//validates a username by checking if it is in the database
function validateUsername(username) {
	validateUsernmaeAJAX(validateUsernameCallback, username);
}

//Callback function due to AJAX Asyncronousness
function validateUsernameCallback(result) {
	if(!result) {
		$("#username").addClass('error');
	}
}

//performs ajax request to login.php to check if a username is available
function validateUsernmaeAJAX(callback, username) {
  $.ajax({
		type: "post",
		url: 'classes/login.php',
		data: {'userCheck': username},
		success: function(data)
		{
			callback(data);
		},
		error: function(xhr, textStatus, errorThrown) {
			return false;
		}
	});
}