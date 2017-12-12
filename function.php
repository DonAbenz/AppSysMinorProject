<?php
//function.php



function insert_guest_details($id, $connect)
{
	$query = "
	SELECT * FROM roombook 
	WHERE id = '".$id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	foreach($result as $row)
	{
		$sub_array = array();
		$sub_array[] = $row['FName'];
		$sub_array[] = $row['Email'];
		$sub_array[] = $row['Bed'];
		$sub_array[] = $row['TRoom'];
		$sub_array[] = $row['Meal'];
		$sub_array[] = $row['cin'];
		$sub_array[] = $row['cout'];
		$data[] = $sub_array;
		
	}
	return $output;
}

?>