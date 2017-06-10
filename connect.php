<?php

  $DBhost = "localhost";
  $DBuser = "gijs";
  $DBpass = "ofok3la9No";
  $DBname = "gijs";
  
  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }

?>