<?php require_once("connect.php"); ?>
<?php
//user_action.php

if(isset($_POST['btn_action'])){

    if($_POST['btn_action'] == 'Add')
    {
        $query = "
        INSERT INTO room (room_no, room_type_id, status) 
        VALUES (:room_no, :room_type_id, :status)
        "; 
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':room_no'  => $_POST["room_no"],
                ':room_type_id'  => $_POST["room_type_id"],
                ':status'  => $_POST["status"]
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
        SELECT * FROM room WHERE room_id = :room_id
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':room_id' => $_POST["room_id"]
            )
        );
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            $output['room_no'] = $row['room_no'];
        }
        echo json_encode($output);
    }

    if($_POST['btn_action'] == 'Edit'){
        if($_POST['user_password'] != '')
        {
            $query = "
            UPDATE user_details SET 
            user_name = '".$_POST["user_name"]."', 
            user_email = '".$_POST["user_email"]."',
            user_password = '".password_hash($_POST["user_password"], PASSWORD_DEFAULT)."' 
            WHERE user_id = '".$_POST["user_id"]."'
            ";
        }
        else
        {
            $query = "
            UPDATE user_details SET 
            user_name = '".$_POST["user_name"]."', 
            user_email = '".$_POST["user_email"]."'
            WHERE user_id = '".$_POST["user_id"]."'
            ";
        }
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        if(isset($result))
        {
            echo 'User Details Edited';
        }
    }

    if($_POST['btn_action'] == 'delete'){
        $query = "
        DELETE FROM room
        WHERE room_id = :room_id
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':room_id'  => $_POST["room_id"]
            )
        ); 
        echo 'Room deleted';   
    }
}

?>