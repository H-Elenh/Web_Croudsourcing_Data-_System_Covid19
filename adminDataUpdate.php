<?php 

	include('connectdb.php');
	include('session.php');
	$result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
	$row=mysqli_fetch_array($result);
	 
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin: Update data</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"> 
		<link rel="stylesheet" href="style.css">
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
		<!--needed for Modal popup design according to bootstrap-->
	</head>
	
	<body>
		<header class="ourHead">
			<h1>Hi there, <?php echo $row['username']; ?></h1>
			<a href="adminDataEdit.php"><button id="lilac_button">Back</button></a>
			<a href="logout.php"><button id="lilac_button">Logout</button></a>
		</header>

		<section>
			<br>
	
			<table style="table-layout:fixed;" bgcolor="pink"  width="100%" cellspacing="0" cellpadding="0">
			
			
			<thead>
					<tr>
					<th colspan="9">Point of interest data</th>
					</tr>
					<tr>
						<th>name</th>
						<th>address</th>
						<th>types</th>
						<th>coordinates</th>
						<th>rating</th>
						<th>rating_n</th>
						<th>popular times</th>
						<th>current popularity</th>
						<th>Edit</th>
					</tr>
				</thead>
				
				<tbody>
					
					<?php
						$table = mysqli_query($con, "select * from poi");
						while($index = mysqli_fetch_array($table)){ ?>
						
						<tr id="<?php echo $index['id']; ?>">
							<td data-target="name" style="overflow:auto;"><?php echo $index['name']; ?></td>
							<td data-target="address"><?php echo $index['address']; ?></td>
							<td data-target="types" style="overflow:auto;"><?php echo $index['types']; ?></td>
							<td data-target="coords" style="overflow:auto;"><?php echo $index['coords']; ?></td>
							<td data-target="rating"><?php echo $index['rating']; ?></td>
							<td data-target="rating_n"><?php echo $index['rating_n']; ?></td>
							<td data-target="populartimes" style="overflow:auto;"><?php echo $index['populartimes']; ?></td>
							<td data-target="curr_popularity"><?php echo $index['current_popularity']; ?></td>
							<td><a href="#" data-role="update" data-id="<?php echo $index['id']; ?>">Edit</a></td>
						</tr>
					<?php } ?>					
				</tbody>
			</table>
		</section>
		
		
		<!-- Modal popup -->
		
		<div id="popupBox" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
						<h5 class="modal-title">Update Point of Interest</h5>
					</div>
					
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" id="name" class="form-control">
						</div>
						<div class="form-group">
							<label>Address</label>
							<input type="text" id="address" class="form-control">
						</div>
						<div class="form-group">
							<label>Types</label>
							<input type="text" id="types" class="form-control">
						</div>
						<div class="form-group">
							<label>Coords</label>
							<input type="text" id="coords" class="form-control">
						</div>
						<div class="form-group">
							<label>Rating</label>
							<input type="text" id="rating" class="form-control">
						</div>
						<div class="form-group">
							<label>Rating_n</label>
							<input type="text" id="rating_n" class="form-control">
						</div>
						<div class="form-group">
							<label>Popular times</label>
							<input type="text" id="populartimes" class="form-control">
						</div>
						<div class="form-group">
							<label>Current Popularity</label>
							<input type="text" id="current_pop" class="form-control">
						</div>
						<input type="hidden" id="poiId"> 
					</div>
					
					<div class="modal-footer">
						<a href="#" id="save" class="btn btn-primary pull-right">Update</a>
						<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>		
	</body>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
		<script src="modalUpdate.js"></script>

	</html>