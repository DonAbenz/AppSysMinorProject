<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connect.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form

	// Validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("username" => 30);
	validate_max_lengths($fields_with_max_lengths);

	if(empty($errors)) {
		// Perform create

		$username = mysql_prep($_POST["username"]);
        $hashed_password = password_encrypt($_POST["password"]);
        $role = mysql_prep($_POST["role"]);

		$query  = "INSERT INTO admin (";
		$query .= " username, hashed_password, role";
		$query .= ") VALUES (";
		$query .= " '{$username}', '{$hashed_password}', '{$role}'";
		$query .= ")";
		$result = mysqli_query($connection, $query);

	if ($result) {
		// Success
		$_SESSION["message"] = "Admin created.";
		redirect_to("manage_admins.php");
	} else {
		// Failure
		$_SESSION["message"] = "Admin creation failed.";
	}
}
} else {
	// This is probably a GET request

} //end: if (isset($_POST['submit']))
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

		<h2>Create Admin</h2>
		<form action="new_admin.php" method="post">
			<p>Username:
				<input type="text" name="username" value="" />
			</p>
			<p>Password:
			<input type="password" name="password" value="" />
			</p>
            <p>Role:
            <input type="radio" name="role" value="Administrator" checked> Administrator
			<input type="radio" name="role" value="Receptionist"> Receptionist<br>
            </p>
			<input type="submit" name="submit" value="Create Admin" />
		</form>
		<br />
		<a href="manage_admins.php">Cancel</a>
	</div> <!--ends page-->
</div> <!--ends main-->