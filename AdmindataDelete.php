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
		<title>Admin: Remove all data</title>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
		<header class="ourHead">
				<h3>Hi there, <?php echo $row['username']; ?></h3>
		</header>
		
		<?php
		 
			$check = mysqli_query($con,"select name from poi"); 
			$result = mysqli_fetch_array($check);
			if($result==""){
				echo "<script type='text/javascript'>alert('No results, sorry.');</script>";
				
			}
			
			else {
				mysqli_query($con,"delete from poi");
				echo "<script type='text/javascript'>alert('Deletion Process Done!');</script>";
			}
		?>
	<a href="adminMain.php"><button id="lilac_button">Back to admin page</button></a>
	<a href="logout.php"><button id="lilac_button">Logout</button></a>
	</body>
</html>