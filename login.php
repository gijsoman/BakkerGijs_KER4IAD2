<?php
session_start();
require_once 'connect.php';

//check if the usersession is already sit if so send to home.
if(!empty($_SESSION['userSession']))
{
	header("Location: home.php");
	exit;
}

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
{
	//strip the tags from the string against cross site scripting? i guess?
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);

	//Escape the special characters in a string to use in an sql statement taking into account the current charset of the connection.
	$email = $DBcon->real_escape_string($email);
	$password = $DBcon->real_escape_string($password);

	$query = $DBcon->query("SELECT user_id, email, password FROM users WHERE email='$email' LIMIT 1;");
	$row=$query->fetch_array();

	$count = $query->num_rows;

	$hashed_password = hash('sha256', $password);

	if($hashed_password == $row['password'] && $count == 1)
	{
		$_SESSION['userSession'] = $row['user_id'];
		header("Location: home.php");
	}
	else
	{
		$msg = "Invalid Username or Password! <br />";
	}
	$DBcon->close();
}
?>

<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE>Login</TITLE>
</HEAD>

<BODY>

	<form method="post" id="login-form">

		<H2>Login</H2><hr />
		<?php
		if(isset($msg))
		{
			echo $msg;
		}
		?>
		<input type="email" placeholder="Email adress" name="email" required /><br />
		<input type="password" placeholder="Password" name="password" required /><br />
		<hr />
		<a href="register.php" style="float:right;">Sign UP Here</a>
		<button type="submit" name="btn-login" id="btn-login">Login</button>

	</form>

</BODY>

</HTML>