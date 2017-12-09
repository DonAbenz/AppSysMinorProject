<?php require_once("connect.php"); ?>
<?php
//user.php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

if($_SESSION["type"] != 'master')
{
	header("location:index.php");
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
						<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> New Bookings</h3>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
						<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#bookingModal" class="btn btn-success btn-xs">Add New Reservation</button>
					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row"><div class="col-sm-12 table-responsive">
					<table id="booking_data" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Bedding</th>
                                <th>Room Type</th>
								<th>Meal</th>
								<th>Check In</th>
								<th>Chech Out</th>
								<th>Status</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="bookingModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i>New Reservation</h4>
				</div>
				<div class="modal-body">
                    <div align="center" class="form-group">
                        <h4>Personal Information</h4>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="fname" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phoneno" class="form-control" required />
                    </div>
                    <div align="center" class="form-group">
                        <hr />
                            <h4>Reservation Information</h4>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label>Type of Room</label>
                        <select name="room_type">
                            <option value="Regular Room">Regular Room</option>
                            <option value="Deluxe Room">Deluxe Room</option>
                            <option value="Premium Room">Premium Room</option>
                        </select>
                        <label style="margin-left:20px">Type of Bedding</label>
                        <select name="room_bedding">
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                            <option value="Triple">Triple</option>
                            <option value="Quad">Quad</option>
                        </select>
                    </div>
                    <div class="form-group">    
                        <label>Number of Rooms</label>
                        <select name="number_of_room">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <label style="margin-left:20px">Meal Plan</label>
                        <select name="meal">
                            <option value="Room only">Room only</option>
                            <option value="Breakfast">Breakfast</option>
                            <option value="Half Board">Half Board</option>
                            <option value="Full Board">Full Board</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Check-In</label>
                        <input type="date" name="cin" class="form-control" required />
                        <label>Check-Out</label>
                        <input type="date" name="cout" class="form-control" required />
                    </div>
                </div>
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id" />
					<input type="hidden" name="btn_action" id="btn_action" />
					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>

	</div>
</div>
<script>
	$(document).ready(function(){

		$('#add_button').click(function(){
			$('#user_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i>Add Reservation");
			$('#action').val("Add");
			$('#btn_action').val("Add");
		});

		var userdataTable = $('#booking_data').DataTable({ //.DataTable = jQuery plugin = https://datatables.net/
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax":{
				url:"booking_fetch.php",
				type:"POST"
			},
			"columnDefs":[
			{
				"target":[4,5],
				"orderable":false
			}
			],
			"pageLength": 5
        });
        
        $(document).on('submit', '#user_form', function(event){
			event.preventDefault();
			$('#action').attr('disabled','disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"booking_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_form')[0].reset();
					$('#bookingModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
					$('#action').attr('disabled', false);
					userdataTable.ajax.reload();
				}
			})
		});
	});
</script>

<!-- <?php
include('footer.php');
?> -->
