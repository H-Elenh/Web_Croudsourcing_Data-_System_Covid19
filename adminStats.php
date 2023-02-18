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
			<title>Admin: Statistics</title>
			<link rel="stylesheet"  href="style.css">
		</head>
		
		<body>
			
			<header class="ourHead">
					<h1>Hi there, <?php echo $row['username']; ?></h1>
			</header>
			
			<section>
				<h2>Statistics:</h2>
				<div>
					<table class="tbl">
					
						<tr>
							<th>Visits Registered</th>
							<th>Positive cases Registered</th>
							<th>Visits by Positive cases</th>
						</tr>
						
						<tr>
							
							<?php 
								$vis_hist = mysqli_query($con, "select * from visits_log"); //gets all the visits registered
								$total_visits = mysqli_num_rows($vis_hist);
								echo("<td>$total_visits</td>");
							?>
						
							
							<?php
							   
								$covid_hist = mysqli_query($con, "select * from covid_log");  //get all registered tests
								$total_tests = mysqli_num_rows($covid_hist);         
								echo("<td>$total_tests</td>");
							 ?></td>
							
							
							<?php
								$covid_visits = mysqli_query($con, "select * from visits_log where positive_check=true");
								$covid_visit_count = mysqli_num_rows($covid_visits);
								echo("<td>$covid_visit_count</td>");
							?>
							
						</tr>
					</table>
				</div>
				
				<h2>Total visits - by Point of Interest type:</h2>
				<canvas id="total_per_type" width="100%" height="30"></canvas>
				
				<h2>Total visits from positive cases - by Point of Interest type:</h2>
				<canvas id="positive_per_type" width="100%" height="30"></canvas>
				
				
			</section>

			
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"></script>
			<script type="text/javascript" src="adminStatistics.js"></script>
			<br>
			<button id="lilac_button"><a href="adminMain.php">Back</a></button>
			<a href="logout.php"><button id="lilac_button">Logout</button></a>
		</body>
	</html>