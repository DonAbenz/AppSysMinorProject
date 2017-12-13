<?php require_once("connect.php"); ?>
<?php
//user.php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

include("header.php");


?>
<span id="alert_action"></span>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
						<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Payment List</h3>
					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row"><div class="col-sm-12 table-responsive">
					<table id="payment_data" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Customer Name</th>
								<th>Room</th>
								<th>Check in Date</th>
								<th>Check out Date</th>
								<th>No. of Days</th>
								<th>Payment Status</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		$('#add_button').click(function(){
			$('#payment_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Room");
			$('#action').val("Add");
			$('#btn_action').val("Add");
		});

		var paymentdataTable = $('#payment_data').DataTable({ //.DataTable = jQuery plugin = https://datatables.net/
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax":{
				url:"payment_fetch.php",
				type:"POST"
			},
			"columnDefs":[
			{
				"target":[4,7],
				"orderable":false
			}
			],
			"pageLength": 10
		});

		$(document).on('submit', '#payment_form', function(event){
			event.preventDefault();
			$('#action').attr('disabled','disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"room_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#payment_form')[0].reset();
					$('#roomModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
					$('#action').attr('disabled', false);
					paymentdataTable.ajax.reload();
				}
			})
		});

		$(document).on('click', '.delete', function(){
			var id = $(this).attr("id");
			var btn_action = "delete";
			if(confirm("Are you sure you want to delete this room?"))
			{
				$.ajax({
					url:"payment_action.php",
					method:"POST",
					data:{id:id, btn_action:btn_action},
					success:function(data)
					{
						$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						paymentdataTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		});

	});
</script>

<!-- <?php
include('footer.php');
?> -->
