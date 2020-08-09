<?php 

$serverName = "localhost";
$dBName = "gethelp";
$dBUsername = "root";
$dBPassword = "";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if(!$conn){
	die("Conection Failed: ".mysql_connect_error());
}