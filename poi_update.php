<?php
    include('connectdb.php');
    include('session.php');

		$name = $_POST['name'];
		$address = $_POST['address'];
		$types = $_POST['types'];
		$coords = $_POST['coords'];
		$rating = $_POST['rating'];
		$rating_n = $_POST['rating_n'];
		$populartimes = $_POST['populartimes'];
		$current_pop = $_POST['current_pop'];
		$id = $_POST['id'];
		
		$query = mysqli_query($con, "update poi set name='$name' , address='$address' , types='$types', coords='$coords' , rating='$rating', rating_n='$rating_n' , populartimes='$populartimes' , current_popularity='$current_pop' where id='$id'");
		
?>
