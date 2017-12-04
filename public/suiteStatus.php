<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connect.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

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
		<h1>SUITE HOTEL</h1>
	</div> <!--ends page-->
</div> <!--ends main-->
