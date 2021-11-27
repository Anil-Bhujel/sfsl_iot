<?php
$servername='localhost';
$username='username';
$password='password';
$dbname = "database-name";
$db=mysqli_connect($servername,$username,$password,"$dbname");
if(!$db){
   die('Could not Connect My Sql:' .mysql_error());
}
?>