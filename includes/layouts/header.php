<?php if(!isset($layout_context)) {$layout_context = "public";} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transisional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<title>Suite </title>
	<link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="header">
		<h1>Suite <?php echo '<span>you are logged in as <i>'.$_SESSION['username'].'</i></span>'; ?></h1>
		<a href="logout.php">logout</a>
	</div> <!--ends header-->
