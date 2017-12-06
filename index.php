<?php require_once("connect.php"); ?>
<?php
if(!isset($_SESSION["type"])){
	header("Location:login.php");
}

include("header.php");

?>