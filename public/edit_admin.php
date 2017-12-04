<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php
	$admin = find_admin_by_id($_GET["id"]);

	if (!$admin) {
		// admin ID was missing or invalid or
		// admin couldn't be found in the database
		redirect_to("manage_admins.php");
	}
?>

<?php
if (isset($_POST['submit'])) {
	// Process the form

	// validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("username" => 30);
	validate_max_lengths($fields_with_max_lengths);

	if(empty($errors)) {

		// Perform update

		$id = $admin["admin_id"];
		$username = mysql_prep($_POST["username"]);
        $hashed_password = password_encrypt($_POST["password"]);
        $role = mysql_prep($_POST["role"]);

		$query  = "UPDATE admin SET ";
		$query .= "username = '{$username}', ";
        $query .= "hashed_password = '{$hashed_password}', ";
        $query .= "role = '{$role}' ";
		$query .= "WHERE admin_id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) == 1) {
		// Success
		$_SESSION["message"] = "Admin updated.";
		redirect_to("manage_admins.php");
	} else {
		// Failure
		$_SESSION["message"] = "Admin update failed.";
	}

}
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
    <div id="navigation">
    <br />
    <?php echo navigation() ?>
    <br />
    </div> <!--ends navigation-->

  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit Admin: <?php echo htmlentities($admin["username"]); ?></h2>
    <form action="edit_admin.php?id=<?php echo urlencode($admin["admin_id"]); ?>" method="post">
        <p>New Username:
        <input type="text" name="username" placeholder="<?php echo htmlentities($admin["username"]); ?>" />
        </p>
        <p>New Password:
        <input type="password" name="password" value="" />
        </p>
        <p>New Role:
        <input type="radio" name="role" value="Administrator" checked> Administrator
        <input type="radio" name="role" value="Receptionist"> Receptionist<br>
        </p>
      <input type="submit" name="submit" value="Edit Admin" />
    </form>
    <br />
    <a href="manage_admins.php">Cancel</a>
  </div>
</div>