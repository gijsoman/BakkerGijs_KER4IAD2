<?php
//In this file we get the average weights of the last week from the database.
	//first we include our connection
	require_once 'connect.php';

	//Here we check if the device that uses this page has an sessioinID
	if (isset($_GET['sessionID'])) 
	{
		$sid = htmlspecialchars($_GET['sessionID']);
		$arduinoWeight = htmlspecialchars($_GET['arduinoWeight']);
		session_id($sid);
	}
	else
	{
		echo "you did not set the sessionID";
	}	
	//start the session
	session_start();

	//if a session is set and the session variable isn't zero we may actualy get our data and calculate the average. This average is returned so my arduino can read it.
 	if (isset($_SESSION['thingSession']) && $_SESSION['thingSession']!=0) 
 	{
 		$dataLastWeek = $DBcon->query("SELECT * FROM data WHERE data_datetime > CURRENT_DATE - INTERVAL 7 DAY AND data_thing_id = 12");

		$weight = array();

		while($row =  mysqli_fetch_assoc($dataLastWeek)) 
		{
		    $weight[] = $row['data_reading'];
		}

		$average = array_sum($weight) / count($weight);

		echo $average;
 	}
 	else
 	{
 		echo "you did not set the arduinoWeight";
 	}
?>