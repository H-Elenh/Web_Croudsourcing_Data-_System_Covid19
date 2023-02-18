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
		<title>User: Homepage</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
	</head>
	
	<body>
		<header class="ourHead">
				<h1>Hi there, <?php echo $row['username']; ?></h1>
				<a href="userEdit.php"> <button id="lilac_button">My Profile</button></a> <br>
				<a href="logout.php"> <button id="lilac_button">Logout</button></a>
		</header> 
    

			 
			 <h4>Search for a Point of Interest:</h4> 
			 
			<div id="container">
			
				<input type="text" name="day" id="day" placeholder="Day of Interest">
			  	<input type="date" name="temp_date" id="temp_date" placeholder="format is DD/MM/YYYY">				
				<input type="time" name="temp_time" id="temp_time">				
				<input type="text" id="poi" name="poi" placeholder="business category">
			
				<button type="submit" name="poiSearch" id="poiSearch">GO</button>
			
			</div>		
		
			<section>
				<div id="map"></div>
			</section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
	<script type="text/javascript" src="mapProcess.js"></script>

	</body>
	</html>