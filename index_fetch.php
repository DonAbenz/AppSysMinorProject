<?php require_once("connect.php"); ?>
<?php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

$query = '';

$output = array();
$query .= "
SELECT * FROM roombook INNER JOIN room ON room.room_no = roombook.room_no
WHERE stat = 'Confirmed' AND pay_stat = 'Pending' AND";

if(isset($_POST["search"]["value"]))
{	
	$query .= '(id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR Email LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR FName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR cin LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR pay_stat LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR cout LIKE "%'.$_POST["search"]["value"].'%" )';
	
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY id DESC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	// <th>Customer Name</th>
	// <th>Email</th>
	// <th>Phone</th>
	// <th>Room</th>
	// <th>Check out Date</th>
	$sub_array = array();
    $sub_array[] = $row['FName'].'&nbsp;&nbsp;'.$row['LName'];
	$sub_array[] = $row['Email'];
	$sub_array[] = $row['Phone'];
	$sub_array[] = $row['room_no'].' -- '.$row['type'];
	$sub_array[] = $row['cin'];
    $sub_array[] = $row['cout'];
	$data[] = $sub_array;
}

$output = array(
	"draw"    => intval($_POST["draw"]),
	"recordsTotal"   =>  $filtered_rows,
	"recordsFiltered"  =>  get_total_all_records($connect),
	"data"       =>  $data
);
echo json_encode($output);

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM user_details WHERE user_type='user'");
	$statement->execute();
	return $statement->rowCount();
}

?>