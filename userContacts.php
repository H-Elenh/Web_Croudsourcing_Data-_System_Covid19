<?php 

	include('connectdb.php');
	include('session.php');


	$result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
	$row=mysqli_fetch_array($result);
	$id = $row['user_id'];
?>



<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>User: Possible Contacts</title>
			<link rel="stylesheet" href="style.css">
		</head>
		
		<body>
			<header class="ourHead">
					<h1>Hi there, <?php echo $row['username']; ?></h1>
			</header>
			
			<section id="lefter">
				<h3>Have you been in contact with a Covid-19 case?</h3>
				<p>Here you can see all the spots you visited during a seven day period where: </p>
				<p>
					A positive COVID-19 case was also there within a two-hour time period <strong>OR</strong>
					<br>a visitor tested positive within 7 days of visit</p>
				
				<br>
				<form action="#" method="post">
					<label><strong><i>Pick a Date:</i></strong></label>
					<input type="datetime-local" id="present" name="present">
					<input type="submit" name="submit" value="Go">
				</form>
				
				
				<?php
					if(isset($_POST['submit'])) {
						
						$today = $_POST['present'];
						$start = new DatetimeImmutable($today);
						$search_start = $start->modify('-7 days')->format('Y-m-d H:i:s'); //Starts 7 days ago
						$end= $start->format('Y-m-d H:i:s');//Until today
						//Get all locations user visited during the last 7 days
						$query1 = mysqli_query($con, "select * from visits_log where user_id='$id' AND visit_timestamp>='$search_start' AND visit_timestamp<='$end'");
						$flag = 0;
						
						foreach($query1 as $q1){
							$poiName = $q1['poi_name'];
							$location = $q1['poi_id'];
							//get all users, who came out positive, who visited the same locations within a 7 day period.
							$query2 = mysqli_query($con, "select * from visits_log where user_id!='$id' AND visit_timestamp>='$search_start' AND visit_timestamp<='$end' AND positive_check=true AND poi_id='$location'");
							$num = mysqli_num_rows($query2);
							
							if($num > 0 ){
								$flag =1;
								echo("<p><u>Someone who tested positive visited <strong>$q1[poi_name] at:</strong></u></p>");
								foreach($query2 as $q2){
									echo("<p>$q2[visit_timestamp]</p>");
								}
							}
						}
							if($flag==0){		
								echo'<script>alert("Lucky You! You have had no contact with a COVID-19 cases! :)")</script>';
							}	
					}	
				?>
				
			<br><a href="userEdit.php"><button id="lilac_button">Back</button></a>
			<br><a href="logout.php"><button id="lilac_button">Logout</button></a>
			  
			</section>
			
		</body>
	</html>