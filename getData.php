<?php
    include('connectdb.php');
    include('session.php');

    if(isset($_POST['input'])) { 
        
		$error_response = false; //no error response
        $result = false; //result responses

        $input = $_POST['input']; //from input form in userMain.php
        $time_now = $_POST['time_now'];
        $day = $_POST['day'];
        
		$timestamp = strtotime($time_now);//date to float --> solves problems with array indexing        
		$hours = floatval(date('H', $timestamp)); //capital H for 24-h format
		$query = "select * from poi where types LIKE '%$input%'"; 
        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);
        $dataArray = array();

        if($row >0) {
            
			$i = 0; //index-->we need this for array indexing
            foreach($result as $r) { //for all data from db-->process it 
				
				$poi_id = $r['id'];				
				$poi_name = $r['name'];

				$coords = $r['coords']; //coordinates from poi table
				$str_to_array = explode("," , $coords); 
				
				$populartimes = $r['populartimes'];
				$str_to_array_traff = explode("," , $populartimes);
				
				$popular_now = $r['current_popularity'];

				//i[0] for counter, i[1] for x lat) coords and i[2] for y (long) cords
                $dataArray[$i][0] = $i;
                $dataArray[$i][1] = $str_to_array[0];
                $dataArray[$i][2] = $str_to_array[1];
				
                /*i[3] for time now, i[4] and i[5] for the next 2 hours
				$hours+number is to return the result for the n-th day * 24hours, and the 2 following hours after that
                monday is the 1st day of the week in json files*/
				if($day == "Monday"){
                    $dataArray[$i][3] = $str_to_array_traff[$hours];
                    $dataArray[$i][4] = $str_to_array_traff[$hours+1];
                    $dataArray[$i][5] = $str_to_array_traff[$hours+2];
                }
				elseif($day == "Tuesday"){
                    $dataArray[$i][3] = $str_to_array_traff[$hours+24];
                    $dataArray[$i][4] = $str_to_array_traff[$hours+25];
                    $dataArray[$i][5] = $str_to_array_traff[$hours+26];
                }
				elseif($day == "Wednesday"){
                   $dataArray[$i][3] = $str_to_array_traff[$hours+48];
                    $dataArray[$i][4] = $str_to_array_traff[$hours+49];
                    $dataArray[$i][5] = $str_to_array_traff[$hours+50];
                }
				elseif($day == "Thursday"){
                     $dataArray[$i][3] = $str_to_array_traff[$hours+72];
                    $dataArray[$i][4] = $str_to_array_traff[$hours+73];
                    $dataArray[$i][5] = $str_to_array_traff[$hours+74];
                }
				elseif($day == "Friday"){
                   $dataArray[$i][3] = $str_to_array_traff[$hours+96];
                    $dataArray[$i][4] = $str_to_array_traff[$hours+97];
                    $dataArray[$i][5] = $str_to_array_traff[$hours+98];
                }
				elseif($day == "Saturday"){
                    $dataArray[$i][3] = $str_to_array_traff[$hours+120];
                    $dataArray[$i][4] = $str_to_array_traff[$hours+121];
                    $dataArray[$i][5] = $str_to_array_traff[$hours+122];
                }
				else{
					//$day=="sunday'
                    $dataArray[$i][3] = $str_to_array_traff[$hours+144];
                    $dataArray[$i][4] = $str_to_array_traff[$hours+145];
                    $dataArray[$i][5] = $str_to_array_traff[$hours+146];
                }
                $dataArray[$i][6] = $popular_now;
                $dataArray[$i][7] = $poi_name;
                $dataArray[$i][8] = $poi_id;
                
				$i++;
            }
        }

        echo json_encode(['result' => $dataArray, 'errors' => $error_response]); //return results for AJAX request
    }
?>