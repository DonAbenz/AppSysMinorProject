<?php
if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

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

function fetch_room_details($connect)
{
	
	$query = "
	SELECT * FROM room
	WHERE place = 'vacant'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll(\PDO::FETCH_ASSOC);
	return $result;
}


function fetch_room_no($connect, $id)
{
	
	$query = "
	SELECT * FROM roombook
	WHERE id = $id ";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll(\PDO::FETCH_ASSOC);
	return $result;
	

}

function count_total_user($connect){
	$query = "
	SELECT * FROM user_details WHERE user_status='active' AND user_type = 'user'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();


}

function fetch_room($connect){
	$query = "
	SELECT * FROM room";
	$statement = $connect->prepare($query);
	$statement->execute();
	
	return $statement->rowCount();

}

function count_total_guest($connect){

	$query = "
	SELECT * FROM roombook WHERE stat='Confirmed' AND pay_stat = 'Pending'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();

}

function available_rooms($connect){
	$query = "
	SELECT * FROM room WHERE place='vacant'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}


?>