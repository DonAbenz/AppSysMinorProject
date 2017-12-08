<?php require_once("connect.php"); ?>
<?php

//user_fetch.php

$query = '';

$output = array();

$query .= "
SELECT * FROM room WHERE";

if(isset($_POST["search"]["value"]))
{	
	$query .= '(type LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR bedding LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR place LIKE "%'.$_POST["search"]["value"].'%") ';
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
	$status = '';
	if($row["place"] == 'vacant')
	{
		$status = '<span class="label label-success">Vacant</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Occupied</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['id'];
	$sub_array[] = $row['type'];
	$sub_array[] = $row['bedding'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit"></span> Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["place"].'"><span class="glyphicon glyphicon-remove"></span> Delete</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"    => intval($_POST["draw"]),
	"recordsTotal"   =>  $filtered_rows,
	"data"       =>  $data
);
echo json_encode($output);

// function get_total_all_records($connect)
// {
// 	$statement = $connect->prepare("SELECT * FROM user_details WHERE user_type='user'");
// 	$statement->execute();
// 	return $statement->rowCount();
// }

?>
