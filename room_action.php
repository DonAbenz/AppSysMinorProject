<?php require_once("connect.php"); ?>
<?php
if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

if(isset($_POST['btn_action'])){

    if($_POST['btn_action'] == 'Add')
    {
        $query = "
        INSERT INTO room (room_no, type, place, price) 
        VALUES (:room_no, :room_type, :place, :price)
        "; 
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':room_type'  => $_POST["room_type"],
                ':room_no'  => $_POST["room_no"],
                ':price'  => $_POST["room_price"],
                ':place'  => $_POST["room_status"]
            )
        );
        $result = $statement->fetchAll();
        if(isset($result))
        {
            echo 'New Room Added';
        }
    }
    if($_POST['btn_action'] == 'fetch_single'){
        $query = "
        SELECT * FROM room WHERE room_id = :id
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':id' => $_POST["room_id"]
            )
        );
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            $output['room_type'] = $row['type'];
            $output['room_price'] = $row['price'];
            $output['room_status'] = $row['place'];
        }
        echo json_encode($output);
    }

    if($_POST['btn_action'] == 'Edit'){

        $query = "
        UPDATE room SET 
        type = '".$_POST["room_type"]."', 
        place = '".$_POST["room_status"]."',
        price = '".$_POST["room_price"]."' 
        WHERE room_id = '".$_POST["room_id"]."'";
       
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        if(isset($result))
        {
            echo 'Room Details Edited';
        }
    }

    if($_POST['btn_action'] == 'delete'){
        $query = "
        DELETE FROM room
        WHERE room_id = :id
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':id'  => $_POST['room_id']
            )
        ); 
        echo 'Room deleted';   
    }
}

?>