<?php require_once("connect.php"); ?>
<?php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

$query = '';

$output = array();

$query .= "
SELECT * FROM roombook INNER JOIN room ON roombook.room_no = room.room_no
WHERE roombook.stat = 'Not Confirm' AND
";

if(isset($_POST["search"]["value"]))
{
	$query .= '(FName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR LName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR Email LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR id LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR cin LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR cout LIKE "%'.$_POST["search"]["value"].'%" ';
    // $query .= 'OR room.type LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR stat LIKE "%'.$_POST["search"]["value"].'%") ';
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
	// <th>Booking ID</th>
	// <th>Name</th>
	// <th>Email</th>
	// <th>Room</th>
	// <th>Check In</th>
	// <th>Check Out</th>
	// <th>Payment Status</th>
	// <th></th>
	$sub_array = array();
	$sub_array[] = $row['FName'];
	$sub_array[] = $row['Email'];
    $sub_array[] = $row['room_no'].', '.$row['type'];
    $sub_array[] = $row['cin'];
	$sub_array[] = $row['cout'];
	$sub_array[] = '<button type="button" name="info" book_id="'.$row["id"].'" class="btn btn-info btn-xs info" data-status="'.'"><span class="glyphicon glyphicon-thumbs-up"></span> Confirm Check-In</button>';
	$sub_array[] = '<button type="button" name="delete" book_id="'.$row["id"].'" class="btn btn-delete btn-xs delete" data-status="'.'"><span class="glyphicon glyphicon-trash"></span> Cancel Check-In</button>';
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
