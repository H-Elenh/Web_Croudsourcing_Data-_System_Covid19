<?php

	session_start();

	if (!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) {
		header("location: userMain.php");
		exit();
	}
	
	$session_id=$_SESSION['user_id'];
?>