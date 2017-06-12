<?php
//This file is used to setup the database connection
//First we make variables for all the data we need to log in to the database
  $DBhost = "localhost";
  $DBuser = "gijs";
  $DBpass = "ofok3la9No";
  $DBname = "gijs";
  
  //Store the database connection in a variable
  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
  //We use this error when a connection couldn't be made
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }

?>