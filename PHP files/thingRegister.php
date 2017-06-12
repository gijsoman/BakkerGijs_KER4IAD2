<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: login.php");
}

$msg = "";
if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
{
	//first we add the thing to the database
	$ThingName = strip_tags($_POST['Thingname']);
	$ThingPass = strip_tags($_POST['Thingpassword']);

	$Hashed_ThingPass = hash('sha256', $ThingPass);

	$query = "INSERT INTO things(thing_naam, thing_password, registered_by) VALUES('$ThingName', '$Hashed_ThingPass', '" .$_SESSION['userSession'] ."');";
	//if the query is added succesfully
 	if($DBcon->query($query))
 	{
 		$msg = "Successfully registerd! <br />";
 	}
 	else
 	{
 		$msg = "Error while registering. <br />";
 	}
}

?>

<!-- registration form -->
<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE>Register your thing!</TITLE>
</HEAD>

<BODY>

	<form method="post" id="register-form">
	<h2> Register Thing </h2>
		<?php
		if(isset($msg))
		{
			echo $msg;
		}
		?>
		<input type="text" placeholder="Thingname" name="Thingname" required><br />
		<input type="password" placeholder="Thingpassword" name="Thingpassword" required><br />
		<hr />

		<button type="submit" name="btn-signup">
		Register Thing
		</button><br />

	</form>
<a href="home.php">Back to home</a>

</BODY>

</HTML>