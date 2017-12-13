<?php


if(isset($_GET["pdf"]) && isset($_GET['id']))
{
	require_once 'pdf.php';
	include('connect.php');
	include('function.php');
	if(!isset($_SESSION['type']))
	{
		header('location:login.php');
	}
	$tax = 0.05;


	$output = '';
	$statement = $connect->prepare("
		SELECT * FROM roombook INNER JOIN room ON room.room_no = roombook.room_no
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
		$disp_tax = "5%";
		$room_price = $row['price'];
		$days = $row['nodays'];
		$total_price = $room_price * $days;
		$price_tax = $total_price * $tax;
		$total_price = $total_price + $price_tax;
		

		$output .= '
		
		<h1 align="center">Fleur Suites</h1>
		
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
			</tr>
			<tr>
				<td colspan="2">
				<table width="100%" cellpadding="5">
					<tr>
						<td>
							<b>RECEIVER:</b><br />
							First Name : '.$row["FName"].'<br />	
							Last Name : '.$row["LName"].'<br />
						</td>
						<td>
							Reverse Charge<br />
							Invoice No. : '.$row["id"].'<br />
							Invoice Date : '.$row["cout"].'<br />
						</td>
						<td>
						<b>ISSUED BY</b><br />
						Name : '.$_SESSION["user_name"].'<br />	
						</td>
					</tr>
				</table>
				<br />
			<table width="100%" border="1" cellpadding="5" cellspacing="0">
				<thead>
					<tr>
						<th>Customer ID</th>
						<th>Check in Date</th>
						<th>Check out Date</th>
						<th>Room Type</th>
						<th>Room Price</th>
						<th>No. of Days</th>
						<th>Sales Tax</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.$row['id'].'</td>
						<td>'.$row['cin'].'</td>
						<td>'.$row['cout'].'</td>
						<td>'.$row['type'].'</td>
						<td>Php'.$row['price'].'</td>
						<td>'.$row['nodays'].'</td>
						<td>'.$disp_tax.'</td>

					</tr>
				</tbody>
			</table>
			<br>
			<hr>
			<table width="100%">
				<thead>
				<tr>
					<th>Total Price</th>
					<td align="right">Php'.$total_price.'</td>
				</tr>
				<tr>
				<th>Sales Tax</th>
				<td align="right">Php'.$price_tax.'</td>
				</tr>
				</thead>
			</table>
		<hr>
			<table width="100%">
			<thead>
			<tr>
				<th>Grand Total</th>
				<td align="right">Php'.$total_price.'</td>
			</tr>
			<tr>
			<th></th>
			<td></td>
		</tr>
			</thead>
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