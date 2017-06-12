<?php
	require_once 'connect.php';
	session_start();
		//check if the get variables are set. only then you can fill the local variables
		if(isset($_GET['thingName']) && isset($_GET['password']))
		{
			$thingName = $_GET['thingName'];
			$password = $_GET['password'];
		}	

		//check if the local variables are set only then you can echo. Otherwise give error message back.
		if(isset($thingName) && isset($password))
		{
			//excape the special characters on sql site.
			$thingName = $DBcon->real_escape_string($thingName);
			$password = $DBcon->real_escape_string($password);

			//Search the password according to the thingname
			$query = $DBcon->query("SELECT thing_naam, thing_password, thing_id FROM things WHERE thing_naam='$thingName' LIMIT 1;");
			$row=$query->fetch_array();

			$count = $query->num_rows;

			//hash the password so we can compare with the database
			$hashed_password = hash('sha256', $password);


			if($hashed_password == $row['thing_password'] && $count == 1)
			{
				$_SESSION['thingSession'] = $row['thing_id'];
				echo $_SESSION['thingSession'];
			}
			else
			{
				echo "0";
			}
			$DBcon->close();
		}	
		else 
		{
			echo "0";
		}

		
		
?>