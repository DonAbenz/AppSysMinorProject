<?php require_once("connect.php"); ?>
<?php
if(!isset($_SESSION["type"])){
	header("Location:login.php");
}

include("header.php");
include("function.php");

?>

<br />
	<div class="row" align="center">
	<?php
	?>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total User</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_user($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Number of Rooms</strong></div>
			<div class="panel-body" align="center">
				<h2><?php echo fetch_room($connect) ?></h2>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Guests</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_guest($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Available Rooms</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo available_rooms($connect); ?></h1>
			</div>
		</div>
	</div>
	</div>

	<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
						<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Guests</h3>
					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row"><div class="col-sm-12 table-responsive">
					<table id="index_data" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Customer Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Room</th>
								<th>Check In Date</th>
								<th>Check Out Date</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var userdataTable = $('#index_data').DataTable({ //.DataTable = jQuery plugin = https://datatables.net/
	"processing": true,
	"serverSide": true,
	"order": [],
	"ajax":{
		url:"index_fetch.php",
		type:"POST"
	},
	"columnDefs":[
	{
		"target":[4,5],
		"orderable":false
	}
	],
	"pageLength": 10
});
</script>