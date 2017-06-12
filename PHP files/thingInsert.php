<?php
	require_once 'connect.php';
	if (isset($_GET['sessionID'])) 
	{
		$sid = htmlspecialchars($_GET['sessionID']);
		$weight = htmlspecialchars($_GET['weight']);
		session_id($sid);
	}	
	session_start();

 	if (isset($_SESSION['thingSession']) && $_SESSION['thingSession']!=0) 
 	{
 		//INSEEEEEERT
 		$query = "INSERT INTO data(data_thing_id, data_reading, data_datetime) VALUES('$sid', '$weight', NOW());";

 		if($DBcon->query($query))
  		{
  			echo "Successfully inserted";
  		}
  		else
  		{
  			echo "Pull the plug something is wrong";
  		}
 	} 
	else 
	{
		header('Location: thingLogin.php');
 	}	
?>