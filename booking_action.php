<?php require_once("connect.php"); ?>
<?php require_once("function.php"); ?>
<?php
//user_action.php

function diff($date1, $date2) { 
    $current = $date1; 
    $datetime2 = date_create($date2); 
    $count = 0; 
    while(date_create($current) < $datetime2){ 
        $current = gmdate("Y-m-d", strtotime("+1 day", strtotime($current))); 
        $count++; 
    } 
    return $count; 
} 




if(isset($_POST['btn_action'])){

    if($_POST['btn_action'] == 'Add')
    {
        $new ="Not Confirm";
        $query = "
        INSERT INTO roombook(FName, LName, Email,Phone,  TRoom , 
        Bed , NRoom , Meal , cin , cout , stat ,nodays) 
        VALUES (:FName, :LName, :Email, :Phone, :TRoom , :Bed , 
        :NRoom , :Meal , :cin , :cout , :stat ,:nodays)";
        
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':FName' => $_POST["fname"], 
                ':LName' => $_POST["lname"], 
                ':Email' => $_POST["email"], 
                ':Phone' => $_POST["phoneno"], 
                ':TRoom' => $_POST["room_type"], 
                ':Bed' => $_POST["room_bedding"], 
                ':NRoom' => $_POST["number_of_room"], 
                ':Meal' => $_POST["meal"], 
                ':cin' => $_POST["cin"], 
                ':cout' => $_POST["cout"], 
                ':stat' => $new,
                ':nodays' => diff($_POST["cin"],$_POST["cout"])
            )
        );
        $result = $statement->fetchAll();
        if(isset($result))
        {
            echo "Booking application has been made";
        }
    }

}


if($_POST['btn_action'] == 'delete'){
	
		// $query = "UPDATE roombook SET stat = 'Confirmed' WHERE id = :book_id" ;
		
		// $statement = $connect->prepare($query);

		// $statement->execute(
		// 	array(
        //         ':book_id'  => $_POST["book_id"]
        //     )
		// );

		// $result = $statement->fetchAll();
        
        move_guest_info($_POST["book_id"], $connect);
	
    }
		
		
	
      
    
	
	
	
	

?>