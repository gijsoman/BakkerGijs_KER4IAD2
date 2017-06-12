<?php
//This page can only be reached if a user is logged in. first we start a session and include our connection.
//When we are connected we will get an overview of our data. We will make a graph of the weights of the last week.
session_start();
include_once 'connect.php';

//if there is no user session set we head back to the login page. You have nothing to do here.
if (!isset($_SESSION['userSession'])) {
 header("Location: login.php");
}

//first we select the user from the current session so we can display his data on this page.
$query = $DBcon->query("SELECT * FROM users WHERE user_id=".$_SESSION['userSession']);
//We also select the data from the last seven days so we can display all the data from these days
$dataLastWeek = $DBcon->query("SELECT * FROM data WHERE data_datetime > CURRENT_DATE - INTERVAL 7 DAY AND data_thing_id = 12");
$userRow=$query->fetch_array();

//We create 2 arrays from the date as well as the weight so we can fill our graph with this data.
$date = array();
$weight = array();

//this is where we fill the arrays
while($row =  mysqli_fetch_assoc($dataLastWeek)) 
{
    $date[] = $row['data_datetime'];
    $weight[] = $row['data_reading'];
}


//here we create the variables that can be used in the javascript graph. We first insert all the items which are obtained from the arrays we just made.
echo '	<script type="text/javascript">
			var items = [';

for ($i=0; $i <  count($date); $i++) { 
	echo "{x: '" . $date[$i] . "', y: " . $weight[$i] . "},";
} 

echo '];';
echo "var options = { start:'" .$date[0]. "' , end: '" .end($date) . "'}; </script>"; 

?>


<!DOCTYPE html>
<HTML>
<HEAD>
	<script src="components/vis/vis.js"></script>
  	<link href="components/vis/vis.css" rel="stylesheet" type="text/css" />
	<title>Welcome - <?php echo $userRow['username']; ?></title>
</HEAD>

<BODY>

		<H1>Home</H1><hr />
		<a href="logout.php?logout">Logout</a><br />
    <a href="thingRegister.php">Register a thing!</a>
		<hr />

    <h3>Your things</h3>
    <hr />
      <?php
        //Here we display all the things the user owns
        $thingsquery = $DBcon->query("SELECT thing_naam from things where registered_by=".$_SESSION['userSession']);
        while($thingRow = $thingsquery->fetch_assoc())
        {
          echo $thingRow["thing_naam"];
          echo "<br />";
        }  
      ?>
    <hr />

		<div id="visualization"></div>
<!-- This is where we create the graph for the data from our users thing. currently this will be always the same thing becuase i didn't have time to implement this options yet.-->
<script type="text/javascript">
  var container = document.getElementById('visualization');
  var dataset = new vis.DataSet(items);
  var graph2d = new vis.Graph2d(container, dataset, options);
</script>
		
</BODY>

</HTML>