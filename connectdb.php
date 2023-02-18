<?php
	//make conenction
	$con = mysqli_connect("localhost","root","","ourdb",3306); 
	$con->set_charset("utf8");


	// Check connection
	if (mysqli_connect_errno())
 	{
  		echo "Connection Error: " . mysqli_connect_error();
  	}
?>