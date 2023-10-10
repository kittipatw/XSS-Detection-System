<?php
$mysqli = new mysqli('localhost','root','root','pos_system');
   if($mysqli->connect_errno){
      echo $mysqli->connect_errno.": ".$mysqli->connect_error;
   }
?>
