<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connect.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php
$admin = find_admin_by_id($_GET["id"]);
if (!$admin) {
	// admin ID was missing or invalid or
	// admin couldn't be found in database
	redirect_to("manage_admins.php");
}

$id = $admin["admin_id"];
$query = "DELETE FROM admin WHERE admin_id = {$id} LIMIT 1";
$result = mysqli_query($connection, $query);

if ($result && mysqli_affected_rows($connection) == 1 ) {
	// Success
	$_SESSION["message"] = "User deleted.";
	redirect_to("manage_admins.php");
} else {
	// Failure
	$_SESSION["message"] = "User deletion failed.";
	redirect_to("manage_admins.php");
}
?>
