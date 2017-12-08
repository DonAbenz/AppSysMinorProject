<?php require_once("connect.php"); ?>
<?php
//user_action.php

if(isset($_POST['btn_action'])){

    if($_POST['btn_action'] == 'Add')
    {
        $query = "
        INSERT INTO room (type, bedding, place) 
        VALUES (:room_type, :bedding, :place)
        "; 
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':room_type'  => $_POST["room_type"],
                ':bedding'  => $_POST["room_bedding"],
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
        SELECT * FROM room WHERE id = :id
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
            $output['room_bedding'] = $row['bedding'];
            $output['room_status'] = $row['place'];
        }
        echo json_encode($output);
    }

    if($_POST['btn_action'] == 'Edit'){

        $query = "
        UPDATE room SET 
        type = '".$_POST["room_type"]."', 
        bedding = '".$_POST["room_bedding"]."',
        place = '".$_POST["room_status"]."'
        WHERE id = '".$_POST["room_id"]."'";
       
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
        WHERE id = :id
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