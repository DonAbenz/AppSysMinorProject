<?php require_once("connect.php"); ?>
<?php

//user_fetch.php

$query = '';

$output = array();

$query .= "
SELECT * FROM roombook 
WHERE
";

if(isset($_POST["search"]["value"]))
{
	$query .= '(FName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR LName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR Email LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR cin LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR cout LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR TRoom LIKE "%'.$_POST["search"]["value"].'%" ';
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
	
	$sub_array = array();
	$sub_array[] = $row['FName'];
    $sub_array[] = $row['Email'];
    $sub_array[] = $row['Bed'];
    $sub_array[] = $row['TRoom'];
    $sub_array[] = $row['Meal'];
    $sub_array[] = $row['cin'];
    $sub_array[] = $row['cout'];
    $sub_array[] = $row['stat'];
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