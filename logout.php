<?php
session_start();

if (!isset($_SESSION['userSession'])) {
 header("Location: login.php");
} else if (empty($_SESSION['userSession'])) {
 header("Location: home.php");
}

if (isset($_GET['logout'])) {
 session_destroy();
 unset($_SESSION['userSession']);
 header("Location: login.php");
}
?>