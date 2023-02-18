<?php 

	include('connectdb.php');
	include('session.php');


	$result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
	$row=mysqli_fetch_array($result);
	$i=$row['user_id'];
?>

<!DOCTYPE html>
	<html lang="en">
	
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>User:Edit Profile</title>
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<header class="ourHead">
				<h1>Want to edit your profile, <?php echo $row['username']; ?> ?</h1>
		</header>
	
		
		<section id="lefter">
			<h4>Change username and password:</h4>
			
			<form action="#" method="post">
			
				<div id="container">
					<label> New Username </label> 
					<input type="text" placeholder="Username" name="user">
					
					<label> New Password </label> 
					<input id="passwordRegistered" type="password" name="pass" placeholder="Password"
						pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}"
						title="Must contain at least one  number, one uppercase and lowercase letter, a symbol and at least 8 characters">
					<input type="submit" value="Ok" name="update">
				</div>
			</form>
			<br>
		
			
			<?php
				$id = $row['user_id'];

				if (isset($_POST['update'])) {
							
						$name = $_POST['user'];
						$pass = $_POST['pass'];
						
						//check if new username exists 
						$q = "select * from users where username='$name'";
						$res = mysqli_query($con, $q);
						$flag = mysqli_num_rows($res);
						
						if($flag > 0) { 
							echo 'Username already taken';
						}
						else {	
							$update = "update users set username='$name', password='$pass' where user_id='$id'";
							 mysqli_query($con, $update);
							 echo '<script>alert("Update Successful!")</script>';
							 header('location:userMain.php');
						 }
					}   
			?>
		
		
			<section>
				
				<h4>Check if you have come in contact with a COVID-19 case: <a href="userContacts.php"> <button id="lilac_button">Click Here</button></a> </h4>
				
				<h4>Submit your positive COVID-19 test:</h4>
				<form action="#" method="post">
					<div id="container">
						<label>Please insert test's date:</label> <input type="datetime-local" name="timestamp" placeholder="format is DD/MM/YYYY">
						<button type="submit" name="test_submit">Ok</button> 
					</div>	   
				</form>
				<br>
			</section>  
		   
			<?php
		
				if(isset($_POST['test_submit'])) { 
					
					$usr_id = $row['user_id'];
				   	$timestamp = $_POST['timestamp'];
					$query = "select * from covid_log where user_id='$usr_id'";


					$result_= mysqli_query($con, $query); 
					$flag1 = mysqli_num_rows($result_); 
				  
					$covid_test = new DatetimeImmutable($timestamp);	
					$covid_test_new = new DatetimeImmutable($timestamp); 
					$covid_first = $covid_test->modify('-7 days');
					$covid_last = $covid_test_new->modify('+14 days');
					
					if($flag1 > 0 ) {
						//If a test was submitted 7 days ago --> compare and correct format
						foreach($result_ as $r) { 
							$init =  new DateTimeImmutable($r['test_date']); 
							$datetime = $init->modify('+14 days');
							if($datetime->format('Y-m-d H:i:s') >= $timestamp) {
							
								echo '<script type ="text/JavaScript">';
								echo 'alert("A positive test has already been submitted during a 1 week period!")';  
								echo '</script>';  
								
								$flag2 = false; //prior test found, prevent insert
								break;
							}
						else{ 
							$first_reg = "insert into covid_log(user_id,  test_date) values('$usr_id' , '$timestamp')";
							mysqli_query($con, $first_reg);
							$visits = mysqli_query($con, "select * from visits_log where user_id='$usr_id'"); //timestamp check
							
							foreach($visits as $vis ){
								$vst = $vis ['visit_timestamp'];
								if($covid_first->format('Y-m-d H:i:s') <= $vst && $vst <= $covid_last->format('Y-m-d H:i:s')){
									$updt = "update visits_log set positive_check = true where visit_timestamp = '$vst'";
									mysqli_query($con, $updt);
								}//timestamp check
							}
							
							echo '<script type ="text/JavaScript">';
							echo 'alert("Submit process successful")';  
							echo '</script>';  
						} 
					}
				}
					else{ 
						$first_reg = "insert into covid_log(user_id,  test_date) values('$usr_id' , '$timestamp')";
						mysqli_query($con, $first_reg);
						$visits = mysqli_query($con, "select * from visits_log where user_id='$usr_id'"); //timestamp check
						
						foreach($visits as $vis ){
							$vst = $vis ['visit_timestamp'];
							if($covid_first->format('Y-m-d H:i:s') <= $vst && $vst <= $covid_last->format('Y-m-d H:i:s')){
								$updt = "update visits_log set positive_check = true where visit_timestamp = '$vst'";
								mysqli_query($con, $updt);
							}//timestamp check
						}
						
						echo '<script type ="text/JavaScript">';
						echo 'alert("Submit process successful")';  
						echo '</script>';  
					}          
				 }
			 ?>
			 <!-- Tables -->
			 
				<section>
					<table class="tbl">
					<tr>
							<th>Positive Tests Until Now</th>
						</tr>
						
						<?php
							$q = "select * from covid_log where user_id='$i'";
							$res = mysqli_query($con, $q);
							$flag = mysqli_num_rows($res);
							if($flag>0){
								$c = 1;
								foreach($res as $r) {
									echo"<tr><td>$c) Positive test: $r[test_date] </td></tr>";
									$c++;
								}
							}
							else{
								echo'<tr><td>No positive COVID-19 tests yet.</td></tr>';
							}
						?>
					</table>
				</section>
		
			<section>
				<table class="tbl">
					<tr>
						<th>Visits History</th>
					</tr>
					<?php
						$qu = "select * from visits_log where user_id='$i'";
						$resu = mysqli_query($con, $qu);
						$flagg = mysqli_num_rows($resu);
						if($flagg>0) {
							$count = 1;
							foreach($resu as $re){
								 echo"<tr><td>$count) $re[poi_name] at $re[visit_timestamp] </td></tr>"; 
								$count++;
							}
						}
						else{
							echo"<tr><td>No visits submitted.</td></tr>";
						}
					 ?>		 
				</table>
			</section>
		</section>
		
		<div id="lefter">
			<a href="userMain.php"><button id="lilac_button">Back to Map</button></a>
			<a href="logout.php"><button id="lilac_button">Logout</button></a>
		</div>
	
	</body>
</html>