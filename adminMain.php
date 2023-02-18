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
			<title>Admin </title>
			<link rel="stylesheet" href="style.css">
		</head>
		
		<body>
		
			<header class="ourHead">
				<h1>Hi there, <?php echo $row['username']; ?></h1>
			</header>
			
			<session class="form_and_lists">
				<h3>Choose option:</h3>
				<nav>
						<a href="adminDataEdit.php">Edit Database</a> |
						<a href="adminStats.php">Show Statistics</a>

				</nav>
				<br> <a href="logout.php"><p style="text-align:center"><button id="lilac_button">Logout</button></a> 
			</session>	
		</body>
	</html>
	
	