<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php

if(isset($_SESSION['username'])){
	header('Location: suiteStatus.php');
}

$username = "";
if (isset($_POST['submit'])) {
	// Process the form

	// Validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);

	if(empty($errors)) {
		// Attempt Login

		$username = $_POST["username"];
		$password = $_POST["password"];

		$found_admin = attempt_login($username, $password);

	if ($found_admin) {
		// Success
		// Mark user as logged in
		$_SESSION["admin_id"] = $found_admin["admin_id"];
		$_SESSION["username"] = $found_admin["username"];
		$_SESSION["role"] = $found_admin["role"];
		redirect_to("suiteStatus.php");
	} else {
		// Failure
		$_SESSION["message"] = "Username/password not found.";
	}
}
} else {
	// This is probably a GET request

} //end: if (isset($_POST['submit']))
?>

<?php $layout_context = "admin"; ?>

<!-- <link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" /> -->
<style rel="stylesheet" type="text/css">
/*	Site colours:
	#1A446C - blue grey
	#689DC1 - light blue
	#D4E6F4 - very light blue
	#EEE4B9 - light tan
	#8D0D19 - burgundy
*/

html { height: 100%; width: 100%; }
body {
	width: 100%; height: 100%;
	margin: 0; padding: 0; border: 0;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px; line-height: 15px;
	background: #EEE4B9;
}

/* Page Content */
#page {
	margin-left: 30%;
	float: left; height: 100%;
	padding: 10em; vertical-align: top;
}
#page h2 { color: #8D0D19; margin-top: 1em; }
#page h3 { color: #8D0D19; }
.view-content {
	margin: 1em; padding: 1em; border: 1px solid #999;
}

div.message {
	border: 2px solid #8D0D19;
	color: #8D0D19; font-weight: bold;
	margin: 1em 0 ; padding: 1em;
}

/* errors */
.error {
	color: #8D0D19; border: 2px solid #8D0D19;
	margin: 1em 0; padding: 1em;
}
.error ul { padding-left: 2em; }

</style>

<div id="main">
	
	<div id="page">
		<?php echo message(); ?>
		<?php echo form_errors($errors); ?>

		<h2>Login</h2>
		<form action="login.php" method="post">
			<p>Username:
				<input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
			</p>
			<p>Password:
			<input type="password" name="password" value="" />
			</p>
			<input type="submit" name="submit" value="Submit" />
		</form>
	</div> <!--ends page-->
</div> <!--ends main-->
