<?php

// This currently only works due to a 'quick' and dirty fix
// I added the absolute path of the project to the php include_path in php.ini
// This means the code is no longer porteable
// The problem stems from validate username function
// Because the Login object for this step is created by login.php, which is
// stored in the subdirectory classes, the path below is not present. 
// The path below is present when the Login object is created by 
// createAccount.php and index.php because they are stored at the project root
require_once "/includes/constants.php";

class myMongoDB {
	private $db;
	private $conn;

	//Sets up connection to database using constant DB_NAME
	function __construct() {
		$this->conn = new MongoClient() or die ('Could not connect to database');
		$this->db = $this->conn->selectDB(DB_NAME);
	}

	//Verifies login credentials
	//returns true if a match is found,
	//returns false if no match
	function verify_username_and_password($user, $pwd) {
		$collection = $this->db->Users;

		
		$result = $collection->findOne(array('username' => $user,
																				 'password' => $pwd)); //need to add hashing
		
		if($result) {
			return true;
		}
		else {
			return false;
		}
	}

	// checks if a user is in the database
	// returns true if user is in database
	// returns false if user is not in database
	function check_for_user($user) {
		$collection = $this->db->Users;
		$result = $collection->findOne(array('username' => $user));

		if($result) {
			return true;
		}
		else {
			return false;
		}
	}

	// adds a username, password, and email to the Users table i.e. creates account
	function add_user($user, $password, $email) {
		$collection = $this->db->Users;

		$hashedPassword = password_hash($password);

		$result = $collection->insert(array('username'=>$user,
																				'password'=>$hashedPassword,
																				'email'=>$email));
	}
}

?>