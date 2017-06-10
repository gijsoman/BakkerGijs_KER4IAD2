<?php
session_start();
include_once 'connect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: login.php");
}

$query = $DBcon->query("SELECT * FROM users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();

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
        //Here we are going to put all the things the user owns. first we need a query to select all the things from the database.
        $thingsquery = $DBcon->query("SELECT thing_naam from things where registered_by=".$_SESSION['userSession']);
        while($thingRow = $thingsquery->fetch_assoc())
        {
          echo $thingRow["thing_naam"];
          echo "<br />";
        }  
      ?>
    <hr />

		<div id="visualization"></div>
<script type="text/javascript">
    var container = document.getElementById('visualization');
  var items = [
  // HIER KUNNEN GEWOON VARIABELEN VAN PHP IN heb nog geen data maar dat kan dus hier.
    {x: '2016-06-11', y: 100},
    {x: '2017-06-12', y: 25},
    {x: '2014-06-13', y: 30},
    {x: '2015-06-14', y: 10},
    {x: '2014-06-15', y: 15},
    {x: '2014-06-16', y: 1000}
  ];

  var dataset = new vis.DataSet(items);
  var options = {
    start: '2014-06-10',
    end: '2014-06-18'
  };
  var graph2d = new vis.Graph2d(container, dataset, options);
</script>
		
</BODY>

</HTML>