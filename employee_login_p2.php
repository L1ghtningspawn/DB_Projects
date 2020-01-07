<?php

//db info
define("IN_CODE", 1);
include 'dbconfig2.php';

if (($_POST['user'] && $_POST['pwd']) || (count($_COOKIE['Elogin']) > 0)) {
	if(count($_COOKIE['Elogin']) > 0)
		header('Location: http://eve.kean.edu/~blondebr/CPS5740/Employee_view.php');
	
	print "Your IP: " . $_SERVER['REMOTE_ADDR'];
	$ip_subnet=explode(".",$_SERVER['REMOTE_ADDR']);
	if ($ip_subnet[0] == "10" || ($ip_subnet[0] == "131" and $ip_subnet[1]=="125"))
		echo "<br>You are from Kean University";
	else{
		echo "<br>You are NOT from Kean University";
	}  
	
	
	$login_id=mysqli_real_escape_string($con,strtolower($_POST["user"]));
	$password=mysqli_real_escape_string($con,strtolower($_POST["pwd"]));

	$check_query ="select login from EMPLOYEE2 where login='" . $login_id . "';";
	$result = mysqli_query($con , $check_query);
	
	$isLoginMatch=false;
	if($result){
		if(mysqli_num_rows($result)>0){
			$isLoginMatch = True;
		}
	}


	$query = "select login, name, role from EMPLOYEE2 where login='" . $login_id . "'and password=SHA2('" . $password . "',256);";
	$result = mysqli_query($con , $query);
	$welcome = "";
	$user_role="";
	if($result){
		if(mysqli_num_rows($result)>0){			
			
			while($row = mysqli_fetch_array($result)){
				
				$user_login = $row['login'];
				$rl_name = $row['name'];
				$role = $row['role'];
				
				setcookie('Elogin', strtolower($login_id), time()+(60*20));
				header('Location: http://eve.kean.edu/~blondebr/CPS5740/Employee_view.php');
				$user_role=$role;
			} 
		}
		else{
			if($isLoginMatch == true)
				print "<br> Employee <b>" . $_POST['user'] . "</b> exists, but password is incorrect.";
			else
				print "<br> Login ID <b>" . $_POST['user'] . "</b> does not exist in database.";
						
			}
			
		
		}
	}
	
	

elseif ($_POST['pwd']){
	print "Your IP: " . $_SERVER['REMOTE_ADDR'];
	$ip_subnet=explode(".",$_SERVER['REMOTE_ADDR']);
	if ($ip_subnet[0] == "10" || ($ip_subnet[0] == "131" and $ip_subnet[1]=="125"))
		echo "<br>You are from Kean University";
	else{
		echo "<br>You are NOT from Kean University";
	}
	echo "<br>Please enter login.";
}
elseif($_POST['user']){
	print "Your IP: " . $_SERVER['REMOTE_ADDR'];
	$ip_subnet=explode(".",$_SERVER['REMOTE_ADDR']);
	if ($ip_subnet[0] == "10" || ($ip_subnet[0] == "131" and $ip_subnet[1]=="125"))
		echo "<br>You are from Kean University";
	else{
		echo "<br>You are NOT from Kean University";
	}
	echo "<br>Please enter Password";	
}
else {
	echo "<b>Employee Login! </b>";
	print<<<_HTML_
	<form method="POST" action="$_SERVER[PHP_SELF]">
	Your name: <input type="text" name="user">
	<br>Password: <input type="password" name="pwd">
	<input type="submit" value="Login">
	</form>
_HTML_;
}
?>