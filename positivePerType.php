<?php
    include('connectdb.php');
    include('session.php');
	
    $query = mysqli_query($con, "SELECT `type_in_search`, COUNT(`type_in_search`) as `search_type` FROM `visits_log` WHERE `positive_check`=1 GROUP BY `type_in_search`");
    $result = array();
   
   foreach($query as $quer){
        $result[] = $quer;
    }

    echo json_encode($result);

?>