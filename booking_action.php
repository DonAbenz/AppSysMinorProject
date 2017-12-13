<?php require_once("connect.php"); ?>
<?php require_once("function.php"); ?>
<?php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

if(isset($_POST['btn_action'])){

    if($_POST['btn_action'] == 'Add')
    {
        $new ="Not Confirm";
        $pending = "Pending";
        $query = "
        INSERT INTO roombook(FName, LName, Email, Phone, room_no, cin , cout , stat, pay_stat,nodays) 
        VALUES (:FName, :LName, :Email, :Phone, :room_no, :cin , :cout , :stat, :pay_stat,:nodays)";
        
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':FName' => $_POST["fname"], 
                ':LName' => $_POST["lname"], 
                ':Email' => $_POST["email"], 
                ':Phone' => $_POST["phoneno"],
                ':room_no' => $_POST["room_type"],
                ':cin' => date("Y-m-d"), 
                ':cout' => $_POST["cout"], 
                ':stat' => $new,
                ':pay_stat' => $pending,
                ':nodays' => diff(date("Y-m-d"),$_POST["cout"])
            )
        );
        $result = $statement->fetchAll();
        if(isset($result))
        {
            echo "Booking application has been made";
        }
    }

}


if($_POST['btn_action'] == 'info'){

    $query = "UPDATE roombook SET stat = 'Confirmed' WHERE id = :book_id" ;
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
        ':book_id'  => $_POST["book_id"]
        )
    );
    $result = $statement->fetchAll();

    $fetch_room_no = fetch_room_no($connect, $_POST["book_id"]);

    foreach($fetch_room_no as $rows){

        $no_room = $rows["room_no"];
        $query = "UPDATE room SET place = 'occupied' WHERE room_no = :book_id " ;
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
            ':book_id'  => $no_room
            )
        );
    }
    echo 'Check-In Confirmed'; 
}

if($_POST['btn_action'] == 'delete'){

    $query = "
    DELETE FROM roombook
    WHERE id = :book_id
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':book_id'  => $_POST['book_id']
        )
    ); 
        echo 'Check-In Canceled'; 
}
?>