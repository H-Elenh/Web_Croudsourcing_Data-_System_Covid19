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
		<title>Admin: Edit Data</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
		<header class="ourHead">
				<h1>Hi there, <?php echo $row['username']; ?></h1>
		</header>
		
		
	<section class="form_and_lists">	
		<section>
			<h2 style="color:purple;">Add Points of Interest to Database</h2>
			<h4>Choose a JSON file: </h4>
			<form action="#" method="post" enctype="multipart/form-data">
			<input type="file" name="jSON_file" id="jSON_file">
			<input type="submit" value="Add" name="submit" id="submit">
			</form>
			
			<?php
				if(isset($_FILES['jSON_file'])) { //if a file is uploaded in the corresponding field
					
					$filename = $_FILES["jSON_file"]["name"]; //first we check the file extention
					$extention = pathinfo($filename, PATHINFO_EXTENSION);
					
					switch($extention){ 
						case "json":
							
							//for json extention
							if(isset($_POST['submit'])){ //When we click Add
							
								if(move_uploaded_file($_FILES['jSON_file']['tmp_name'],'localFile.json')) { //locally store JSON file, in order to handle it
									
									//with every upload, delete previous data, when we don't use this function, new data is added to the data base but we get an error message
									mysqli_query($con,"delete from poi");
									
									$json_data = file_get_contents('localFile.json'); //get file
									//json_decode returns an array of objects
									$data = json_decode($json_data); //data is stored as a string. We need PHP compatible data. 
									$i = 0; //bulk insert iterator,checks each json object
									
									foreach($data as $row){
										$i++; 
										$id = $row->id; //id is an object of row, same happens below
										$name = $row->name;
										$address = $row->address;
										$types= array();
										$types = array_merge($types, $row->types);
										$newtypes = implode(",",$types);//convert array to string based on seperator
										$coords = array($row->coordinates->lat , $row->coordinates->lng );
										$newcoords = implode(",",$coords);
										if(property_exists($row, "rating")) { 
											$rating = $row->rating;
										}
										if(property_exists($row, "rating_n")) { //without these if statement we get an error
											$rating_n = $row->rating_n;
										}
										$populartimes = array();
										
										foreach($row->populartimes as $pop_row){
											$populartimes = array_merge($populartimes, $pop_row->data);
										} //Array with 24hoursX7days = 168 cells
										
										$newpopular = implode(",",$populartimes);
										$popular_now = 0;
										
										if(property_exists($row, "current_popularity")) { 
											//if there are records that already have current_popularity:
											$popular_now = $row->current_popularity;//default popular_now=0
										}

										//without this if statement, only the last row is inserted
										if($i < 2){
											$sql = "insert into poi(id, name, address, types, coords, rating, rating_n, populartimes, current_popularity) values('$id' , '$name' , '$address' , '$newtypes' , '$newcoords', '$rating' , '$rating_n' , '$newpopular' , '$popular_now');";
										}
										else{
										$sql .= "insert into poi(id, name, address, types, coords, rating, rating_n, populartimes, current_popularity) values('$id' , '$name' , '$address' , '$newtypes' , '$newcoords', '$rating' , '$rating_n' , '$newpopular' , '$popular_now');";
										}
										
									}
								if ($con->multi_query($sql) === TRUE) { //bulk inserting
									echo'<script>alert("Upload Successful!")</script>';;
								  }
								  else {
									echo "Error: " . $sql . "<br>" . $con->error;
								  }
								
								break;
							}

							}
						default: //if file not .json
							echo '<script>alert("Please try again with a JSON file.")</script>';;
					}
				}//end on click
			?>
		</section>
		<br>
		
		<section>
			<h3><a href="adminDataUpdate.php">Update Already existing Points of interest</a></h3><br>
			<h3><a href="adminConfirmationRemove.php">Remove all Points of Interest from Database</a></h3><br>
		
		</section>
		
			<a href="adminMain.php"><p style="text-align:center"><button id="lilac_button">Back</button></a> 		
			<a href="logout.php"><p style="text-align:center"><button id="lilac_button">Logout</button></a> 
	</section>
		
		
	</body>
	</html>