<?php
if(!defined("IN_CODE")) {
    die("not an entry point");
}
$server = "imc.kean.edu";
$login = "blondebr";
$password = "1027490";
$dbname = "CPS5740";
$table = "EMPLOYEE";

$con = mysqli_connect($server, $login, $password, $dbname); 
//connection error if failed
if (!$con){
	die("FAILED" . mysqli_connect_error());
}


?>