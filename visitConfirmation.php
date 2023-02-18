<?php
		include('connectdb.php');
		include('session.php');
		$result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
		$row=mysqli_fetch_array($result);

		$results = false;

		$user_id = $row['user_id'];
		$poi_id = $_POST['poi_id'];
		$poi_name = $_POST['poi_name'];
		
		$positive_now = 0; //Default: Negative test
		$traffic_now = $_POST['traffic_now'];
		$date_now = $_POST['date_now'];
		$type = $_POST['input'];
		$day = $_POST['day'];
		$time_now = $_POST['time_now'];
		
		$timestamp = date('Y-m-d H:i:s', strtotime($date_now.' '.$time_now));


		//check if user is positive during visit
		$tests = mysqli_query($con, "select * from covid_log where user_id='$user_id'");
		
		foreach($tests as $test){
			$positive_test =  new DateTimeImmutable($test['test_date']); 
			$margin = $positive_test->modify('+14 days');
			if($margin->format('Y-m-d H:i:s') >= $timestamp){
				$positive_now = 1;
			}
		}

		$reg = "insert into visits_log(user_id, poi_id, poi_name, visit_timestamp, positive_check, type_in_search, day) values('$user_id' , '$poi_id' , '$poi_name' , '$timestamp' , '$positive_now' , '$type' , '$day')";
		mysqli_query($con, $reg);

		if($traffic_now != ""){
			$update = "update poi set current_popularity = '$traffic_now' where id = '$poi_id'";
			mysqli_query($con, $update);
		}

		echo json_encode(['results' => "OK"]); //Check for bugs
?>