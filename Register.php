<?php include('connectdb.php' )?>


<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Sign Up</title>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		
		<body>
		
			<header class="ourHead">
				<h1>Hi there!</h1>
			</header>
			
			<section>
				<form class="form_and_lists"  method="post">
					<h4>Register</h4>
					
					<label>Username:</label>
					<input id="usernameRegistered" type="text" name="username"/> 
				
					<label>Password:</label>
					<input id="passwordRegistered" type="password" name="password" 
					pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}"
					title="Must contain at least one number,one uppercase and lowercase letter, a symbol and at least 8 characters">
					
					<label>E-mail:</label>
					<input id="emailRegistered" type="email" name="email"/>
					
					<input type="submit" value="Register" name="register" /> <!--onclick="popup()"-->
					
					<p>Already have an account?
						<a href="login.php">Log in</a>
					</p>
				</form>
				
				<?php 
				       
					if (isset($_POST['register']))
					{
						   $uname = $_POST['username'];
						   $passwrd = $_POST['password'];
						   $email = $_POST['email'];
						  							
						   $query = "select * from users where username='$uname' OR email='$email'";
						   $result = mysqli_query($con, $query);
						   $flag = mysqli_num_rows($result);

						   if($flag > 0 ) { //check if username or email already exists
							   //echo 'Username already taken or mail already exists';
								
								echo'<script type="text/JavaScript"> 
											alert("Username already taken or mail already exists");
									</script>';
						   }

						   else {
							   $register = "insert into users(username, password, email) values('$uname' , '$passwrd' , '$email')";
								mysqli_query($con, $register);
								echo'<script type="text/JavaScript"> 
											alert("Registration Successful!You can now continue to Register Users or Login with your new account.");	
									</script>';
						   }
					}
				?>
			
			</section>
			
			
		</body>
	</html>
	