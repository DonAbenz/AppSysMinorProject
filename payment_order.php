<?php

//view_order.php

if(isset($_GET["pdf"]) && isset($_GET['id']))
{
	require_once 'pdf.php';
	include('connect.php');
	include('function.php');
	if(!isset($_SESSION['type']))
	{
		header('location:login.php');
	}
	$output = '';
	$statement = $connect->prepare("
		SELECT * FROM roombook 
		WHERE id = :id
		LIMIT 1
	");
	$statement->execute(
		array(
			':id'       =>  $_GET["id"]
		)
	);
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output .= '
		
		
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
			</tr>
			<tr>
				<td colspan="2">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="65%">
							<b>RECEIVER:</b><br />
							First Name : '.$row["FName"].'<br />	
							Last Name : '.$row["LName"].'<br />
						</td>
						<td width="35%">
							Reverse Charge<br />
							Invoice No. : '.$row["id"].'<br />
							Invoice Date : '.$row["cout"].'<br />
						</td>
					</tr>
				</table>
				<br />
			<table width="100%" border="1" cellpadding="5" cellspacing="0">
				<thead>
					<tr>
						<th>Customer Name</th>
						<th>Type of Room</th>
						<th>Bed Type</th>
						<th>No. of Room</th>
						<th>Check in Date</th>
						<th>Check out Date</th>
						<th>Meal</th>
						<th>No. of Days</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.$row['FName'].'&nbsp;&nbsp;'.$row['LName'].'</td>
						<td>'.$row['TRoom'].'</td>
						<td>'.$row['Bed'].'</td>
						<td>'.$row['NRoom'].'</td>
						<td>'.$row['cin'].'</td>
						<td>'.$row['cout'].'</td>
						<td>'.$row['Meal'].'</td>
						<td>'.$row['nodays'].'</td>
					</tr>
				</tbody>
			</table>
		
		';
		
		
		
		
		$output .= '
						
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<p align="right">----------------------------------------<br />Receiver Signature</p>
						<br>
					</td>
				</tr>
				</table>
			</table>
		';
	}
	$pdf = new Pdf();
	$file_name = 'Order-'.$row["id"].'.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
}

?>