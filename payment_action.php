<?php require_once("connect.php"); ?>
<?php require_once("function.php"); ?>
<?php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}


if($_POST['btn_action'] == 'delete'){

    $query = "UPDATE roombook SET pay_stat = 'Paid' WHERE id = :id" ;
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
        ':id'  => $_POST["id"]
        )
    );
    $result = $statement->fetchAll();

}

$fetch_room_no = fetch_room_no($connect, $_POST["id"]);

foreach($fetch_room_no as $rows){

    $no_room = $rows["room_no"];
    $query = "UPDATE room SET place = 'vacant' WHERE room_no = :id " ;
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
        ':id'  => $no_room
        )
    );

}

echo 'Payment Success'; 

?>