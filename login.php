<?php 
	session_start();
	include('connectdb.php');
?>


<!DOCTYPE html>

	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Login</title>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>

		<body>
			<header class="ourHead">
			<h1>Hi again!</h1>
			</header>
			<div>
				<form class="form_and_lists" method="post">
					<h3>Login</h3>
						<label>Username:</label>
						<input id="usernameRegistered" type="text" name="user"/> 
						<br><br>
						<label>Password:</label>
						<input id="passwordRegistered" type="password" name="pass"/>  
						<input type="submit" value="Go" name="login"/>
						<h4>First time here? <a href="Register.php">Register</a></h4>
				</form>


				<?php
					if (isset($_POST['login']))
						{
							$username = mysqli_real_escape_string($con, $_POST['user']);
							$password = mysqli_real_escape_string($con, $_POST['pass']); //to avoid unwanted characters
							
							$query = mysqli_query($con, "SELECT * FROM users WHERE  password='$password' and username='$username'");
					
							$row = mysqli_fetch_array($query);
							$num_rows 	= mysqli_num_rows($query);
						  
							
							if ($num_rows > 0) 
								{	
									if($row["admin_check"] != 1){	
										$_SESSION['user_id']=$row['user_id'];
											header('location:userMain.php');
										
										}else{
											
										$_SESSION['user_id']=$row['user_id'];
										header('location:adminMain.php');
									}
									
								}
							else
								{
									echo "<script type='text/javascript'>alert('Username and/or password incorrect.');</script>";
								}
						}
				?>
			</div>		
		</body>
	</html>