<?php
//this file logs you out.
session_start();
//you have nothing to do here if you are not logged in.
if (!isset($_SESSION['userSession'])) {
 header("Location: login.php");
} else if (empty($_SESSION['userSession'])) {
 header("Location: home.php");
}
//destroy session and go to login page.
if (isset($_GET['logout'])) {
 session_destroy();
 unset($_SESSION['userSession']);
 header("Location: login.php");
}
?>