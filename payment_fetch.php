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
WHERE stat = 'Confirmed' AND";

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

	$sub_array = array();
	$sub_array[] = $row['FName'].'&nbsp;&nbsp;'.$row['LName'];
    $sub_array[] = $row['room_no'].' -- '.$row['type'];
    $sub_array[] = $row['cin'];
    $sub_array[] = $row['cout'];
    $sub_array[] = $row['nodays'];
	$sub_array[] = $row['pay_stat'];
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-delete btn-xs delete" data-status="'.'"><span class="glyphicon glyphicon-credit-card"></span> Confirm Payment</button>';
	$sub_array[] = '<a href="payment_order.php?pdf=1&id='.$row["id"].'" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-print"></span> View PDF</a>';
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