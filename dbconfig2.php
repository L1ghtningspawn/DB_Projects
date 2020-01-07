<?php
if(!defined("IN_CODE")) {
    die("not an entry point");
}
$server = "imc.kean.edu";
$login = "blondebr";
$password = "1027490";
$dbname = "CPS5740";
$dbname2 = "2019F_blondebr";

$con = mysqli_connect($server, $login, $password, $dbname); 
$con2 = mysqli_connect($server, $login, $password, $dbname2); 
//connection error if failed
if (!$con){
	die("FAILED" . mysqli_connect_error());
}

if (!$con2){
	die("FAILED" . mysqli_connect_error());
}
?>