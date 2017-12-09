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
						<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Room List</h3>
					</div>
                    <?php
                        if($_SESSION["type"] == 'master'){
                    ?>
					<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
						<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#roomModal" class="btn btn-success btn-xs">Add New Room</button>
                    </div>
                    <?php
                        }
                    ?>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row"><div class="col-sm-12 table-responsive">
					<table id="room_data" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Room Number</th>
								<th>Room Type</th>
								<th>Room Bedding</th>
								<th>Status</th>
                                <?php
                                    if($_SESSION["type"] == 'master'){
                                ?>
                                <th>Edit</th>
								<th></th>
                                <?php
                                    }
                                ?>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="roomModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="room_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add Room</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Room Type</label>
						<select name="room_type">
                            <option value="Regular Room">Regular Room</option>
                            <option value="Deluxe Room">Deluxe Room</option>
                            <option value="Premium Room">Premium Room</option>
                        </select>
					</div>
                    <div class="form-group">
						<label>Room Bedding</label>
						<select name="room_bedding">
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                            <option value="Triple">Triple</option>
                            <option value="Quad">Quad</option>
                        </select>
					</div>
					<div class="form-group">
						<label>Room Status</label>
						<select name="room_status">
                            <option value="vacant">Vacant</option>
                            <option value="occupied">Occupied</option>
                        </select>
					</div>

				</div>
				<div class="modal-footer">
					<input type="hidden" name="room_id" id="room_id" />
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
			$('#room_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Room");
			$('#action').val("Add");
			$('#btn_action').val("Add");
		});

		var userdataTable = $('#room_data').DataTable({ //.DataTable = jQuery plugin = https://datatables.net/
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax":{
				url:"room_fetch.php",
				type:"POST"
			},
			"columnDefs":[
			{
				"target":[4,7],
				"orderable":false
			}
			],
			"pageLength": 6
		});

		$(document).on('submit', '#room_form', function(event){
			event.preventDefault();
			$('#action').attr('disabled','disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"room_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#room_form')[0].reset();
					$('#roomModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
					$('#action').attr('disabled', false);
					userdataTable.ajax.reload();
				}
			})
		});

		$(document).on('click', '.update', function(){
			var room_id = $(this).attr("id");
			var btn_action = 'fetch_single';
			$.ajax({
				url:"room_action.php",
				method:"POST",
				data:{room_id:room_id, btn_action:btn_action},
				dataType:"json",
				success:function(data)
				{
					$('#roomModal').modal('show');
					$('#room_type').val(data.room_type);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Room");
					$('#room_id').val(room_id);
					$('#action').val('Edit');
					$('#btn_action').val('Edit');
				}
			})
		});

		$(document).on('click', '.delete', function(){
			var room_id = $(this).attr("id");
			var btn_action = "delete";
			if(confirm("Are you sure you want to delete this room?"))
			{
				$.ajax({
					url:"room_action.php",
					method:"POST",
					data:{room_id:room_id, btn_action:btn_action},
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
