<?php
//this is our update file as well as our registration form. 
session_start();
require_once 'connect.php';

//check if the usersession is already set if so send to home.
if(isset($_SESSION['userSession']))
{
	//header("Location: home.php");
}

$uname = "";
$email = "";

//if we come from the form we go do all of this
if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
{

	//strip the tags from the string against cross site scripting? i guess?
	$uname = strip_tags($_POST['username']);
 	$email = strip_tags($_POST['email']);

	//Get the hashed password from the database to update with this if the password isn't changed we can only do this if the usersession is set.
	if(isset($_SESSION['userSession']))
	{	
 		$hashed_Password_DB = $DBcon->query("SELECT password FROM users WHERE user_id=" . $_SESSION['userSession'] . ";");
 		$row=$hashed_Password_DB->fetch_array();
 	}
 	//if the password not is the standard value we can set our variables else we just send our hashed password back again.
 	if($_POST['password'] != "00000")
 	{
 		$upass = strip_tags($_POST['password']);
 		//hash the password 
 		$hashed_password = hash('sha256', $upass); 
 		$upass = $DBcon->real_escape_string($upass);
 	}
 	else
 	{
 		$hashed_password = $row['password'];
 		echo "Password is not changed.";
 	}

	
 	
 	//Escape the special characters in a string to use in an sql statement taking into account the current charset of the connection.
	$uname = $DBcon->real_escape_string($uname);
 	$email = $DBcon->real_escape_string($email);
 	
 	//we check if the email already exists. first look in the database if the email exists
	$check_email = $DBcon->query("SELECT email FROM users WHERE email='$email'");
 	$count=$check_email->num_rows;

 	//if we have a usersession we can update else we have to insert.
 	if(isset($_SESSION['userSession']))
 	{
 		$query = "UPDATE users SET username='$uname', email='$email', password='$hashed_password' WHERE user_id = " . $_SESSION['userSession'] . ";";
 		if($DBcon->query($query))
	 	{
	 		$msg = "Successfully updated!<br />";
	 	}
	 	else
	 	{
	 		$msg = "Error while registering.<br />";
	 	}
 	}
 	else
 	{
	 	//check if the email adress is already in use
	 	if($count == 0)
	 	{
	 		$query = "INSERT INTO users(username, email, password) VALUES('$uname', '$email', '$hashed_password');";

	 		//if the query is added succesfully
	 		if($DBcon->query($query))
	 		{
	 			$msg = "Successfully registerd! <br />";
?>
	 			<a href="home.php" style="float:right;">Go to your home page</a>
<?php
	 		}
	 		else
	 		{
	 			$msg = "Error while registering. <br />";
	 		}
	 	}
	 	else
	 	{
	 		$msg = "Email already in use. <br />";
	 	}
	 }
 	$DBcon->close();
}
else
{
	if(isset($_SESSION['userSession']))
	{

		$query = $DBcon->query("SELECT username, email FROM users WHERE user_id=" . $_SESSION['userSession'] . " LIMIT 1;");
		$row=$query->fetch_array();

		$uname = $row['username'];
		$email = $row['email'];
	}
}
?>

<!-- registration form -->
<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE>Register</TITLE>
</HEAD>

<BODY>

	<form method="post" id="register-form">

		
		<?php

		if(isset($_SESSION['userSession']))
		{
			echo "<H2>Update</H2><hr />";
		}
		else
		{
			echo "<H2>Sign up</H2><hr />";
		}

		if(isset($msg))
		{
			echo $msg;
		}
		?>

		<input type="text" placeholder="Username" name="username" value=<?php echo $uname; ?>><br />
		<input type="email" placeholder="Email adress" name="email" value=<?php echo $email; ?>><br />
		<input type="password" placeholder="Password" name="password" value="00000" /><br />
		<hr />

		<button type="submit" name="btn-signup">
		<?php
			if(isset($_SESSION['userSession']))
			{
				echo "Update";
			}
			else
			{
				echo "Create account";
			}
		?>
		</button>

	</form>

</BODY>

</HTML>