<?php

	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
			$error = error_reporting(E_ALL);
			echo $error;
		}
	}

	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
		    $output .= htmlentities($error);
		    $output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	

	function find_all_admins() {
		global $connection;

		$query  = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "ORDER BY admin_id ASC";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}
	

	function find_admin_by_id($admin_id) {
		global $connection;

		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);

		$query  = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "WHERE admin_id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_admin_by_username($username) {
		global $connection;

		$safe_username = mysqli_real_escape_string($connection, $username);

		$query  = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function navigation() {
        echo '<a href="suiteStatus.php">Suite Status</a> </br></br> ';
        echo '<a href="guests.php">Guests</a> </br></br> ';
        echo '<a href="rooms.php">Rooms</a> </br></br> ';
		echo '<a href="nextCheckouts.php">Next Checkouts</a> </br></br> ';
		if(isset($_SESSION['username']) && $_SESSION['role'] == 'Receptionist'){
			echo '<a href="#">Administration</a> </br></br> ';
		}else{
			echo '<a href="manage_admins.php">Administration</a> </br></br> ';
		}            
	}

	function password_encrypt($password) {
		$hash_format = "$2y$10$";	// Tells PHP to use Blowfish with a "cost" of 10
		$salt_length = 22;			// Blowfish salts should be 22-characters or more
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	function generate_salt($length) {
		// Not 100% unique, not 100% random, but good enough for a salt
		// MD5 returns 32 characters
		$unique_random_string = md5(uniqid(mt_rand(), true));

		// Valid characters for a salt are [a-zA-Z0-9./]
		$base64_string = base64_encode($unique_random_string);

		// But not '+' which is valid in base64 encoding
		$modified_base64_string = str_replace('+', '.', $base64_string);

		// Truncate string to the correct length
		$salt = substr($modified_base64_string, 0, $length);

		return $salt;
	}

	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
		$hash = crypt($password, $existing_hash);
		if ($hash == $existing_hash) {
			return true;
		} else {
			return false;
		}
	}

	/* Scheduled for PHP v5.5

	password_hash()
	password_hash($password, PASSWORD_DEFAULT);

	or
	password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

	password_verify()
	password_verify($password, $existing_hash);
	*/

	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if($admin) {
			// Found Admin, now check password
			if (password_check($password, $admin["hashed_password"])) {
				// password matches
				return $admin;
			} else {
				// password doea not match
				return false;
			}
		} else {
			return false;
		}
	}

	function logged_in() {
		return isset($_SESSION['admin_id']);
	}

	function confirm_logged_in() {
		if(!logged_in()) {
			redirect_to("login.php");
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////

	function occupied_rooms(){
		
	}
?>
