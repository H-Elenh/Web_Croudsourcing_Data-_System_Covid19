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
			<title>Admin: Delete Point of Interest Data-Confirm</title>
			<link rel="stylesheet" href="style.css">
		</head>
		<body>
			<header class="ourHead">
					<h1>Attention, <?php echo $row['username']; ?>!</h1>
			</header>

			<section>
				<h2>All data will be lost, do you still wish to proceed? </h2>   
					<nav style="text-align:center">
						<button id="lilac_button"><a href="AdmindataDelete.php">Delete</a></button> 
						<button id="lilac_button"><a href="adminDataEdit.php">Cancel</a></button>
					</nav>
			</section>
		</body>
	</html>