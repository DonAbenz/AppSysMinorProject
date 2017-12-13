<?php require_once("connect.php"); ?>
<?php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

if(isset($_POST['user_name']))
{
    if($_POST["user_new_password"] != '' && $_POST["user_new_password"] == $_POST["user_re_enter_password"])
    {
        $query = "
        UPDATE user_details SET 
        user_name = '".$_POST["user_name"]."', 
        user_email = '".$_POST["user_email"]."', 
        user_password = '".password_hash($_POST["user_new_password"], PASSWORD_DEFAULT)."' 
        WHERE user_id = '".$_SESSION["user_id"]."'
        ";

        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        
    }
    if(isset($result))
    {
        echo '<div class="alert alert-success">Profile Edited</div>';
    }
}

?>