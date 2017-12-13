<?php require_once("connect.php"); ?>
<?php
//user.php

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

include("header.php");
include("function.php");


?>
<span id="alert_action"></span>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
						<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Check-In Lists</h3>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
						<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#bookingModal" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-calendar"></span> Add Check-In</button>
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
                                <th>Room</th>
								<th>Check In</th>
								<th>Check Out</th>
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
<div id="bookingModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i>Check-In</h4>
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
                        <input type="number" name="phoneno" placeholder="09462556003" class="form-control" required />
                    </div>
                    <div align="center" class="form-group">
                        <hr />
                            <h4>Check-In Information</h4>
                        <hr />
                    </div>
					<?php
					$output = fetch_room_details($connect);
						// echo $output;
                    	echo '<div class="form-group">';
                        echo '<label>Select Room &nbsp;&nbsp;&nbsp;&nbsp;</label>';
						echo '<select name="room_type">';
						
						foreach($output as $rows){
						echo '<option value="'.$rows["room_no"].'">'.$rows["room_no"].' -- '.$rows["type"].'</option>';
							// echo '<option value="Junior Suite">Junior Suite</option>';
                            // echo '<option value="Standard Room">Standard Room</option>';
							// echo '<option value="Superior Room">Superior Room</option>';
						}
                        echo '</select>';
                    	echo '</div>';
						
						$currentdate = date("Y-m-d");
					?>
                    <div class="form-group">
                        <!-- <label>Check-In</label>
                        <input type="date" name="cin" class="form-control" required /> -->
                        <label>Check-Out</label>
                        <input type="date" name="cout" class="form-control" min="<?php echo $currentdate;?>" required />
                    </div>
                </div>
				<div class="modal-footer">
					<input type="hidden" name="book_id" id="book_id" />
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
			$('.modal-title').html("<i class='fa fa-plus'></i>Check-In");
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
			"pageLength": 10
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
		
		
		$(document).on('click', '.info', function(){
			var book_id = $(this).attr("book_id");
			var btn_action = "info";
			if(confirm("Confirm Check-In?"))
			{
				$.ajax({
					url:"booking_action.php",
					method:"POST",
					data:{book_id:book_id,btn_action:btn_action},
					success:function(data)
					{
						location.reload(true);
						$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						
						userdataTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		});

		$(document).on('click', '.delete', function(){
			var book_id = $(this).attr("book_id");
			var btn_action = "delete";
			if(confirm("Cancel Check-In?"))
			{
				$.ajax({
					url:"booking_action.php",
					method:"POST",
					data:{book_id:book_id,btn_action:btn_action},
					success:function(data)
					{
						$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						userdataTable.ajax.reload();
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
