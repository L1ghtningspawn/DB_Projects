<?php
//<<<_HTML_ long strings or doc here _HTML_ can be anything.
//useful for html with a lot of quotes in it

//MOVE LOGIN TO OTHER FILE
define("IN_CODE", 1);
include 'dbconfig.php';

if (($_POST['user'] && $_POST['pwd']) || (count($_COOKIE['Elogin']) > 0)) {
	print "Your IP: " . $_SERVER['REMOTE_ADDR'];
	$ip_subnet=explode(".",$_SERVER['REMOTE_ADDR']);
	if ($ip_subnet[0] == "10" || ($ip_subnet[0] == "131" and $ip_subnet[1]=="125"))
		echo "<br>You are from Kean University";
	else{
		echo "<br>You are NOT from Kean University";
	}  
	$query = "select login, password, name, role from EMPLOYEE;";
	$result = mysqli_query($con , $query);
	$welcome = "<br> <br> There is no such employee";
	$isLoginMatch = False;
	$login_success = false;
	$user_role;
	if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
				$user_login = $row['login'];
				$pwd = $row['password'];
				$rl_name = $row['name'];
				$role = $row['role'];
				//$_post compare with database. 
				if(strtolower((($user_login) == strtolower($_POST['user']) && $pwd == $_POST['pwd']) || ($_COOKIE['Elogin'] == strtolower($user_login))))  { // success
					$login_success = True;
					$cookie = "eve.kean.blondebr";
					setcookie('Elogin', strtolower($user_login), time()+(60*2));
					$user_role=$role;
					if($role == 'M')
						$welcome = "<br>Welcome " . "manager: " . $rl_name;
					else
						$welcome = "<br>Welcome " . "employee: " . $rl_name;
				}
				elseif(strtolower($user_login) == strtolower($_POST['user'])) //username but no password
					$isLoginMatch = True;
			}
		}
	}
	if ($isLoginMatch == True){
		print "<br> Employee <b>" . $_POST['user'] . "</b> exists, but password is incorrect.";
		}
	elseif(($isLoginMatch==false && $login_success == false)){
		print "<br> Login ID <b>" . $_POST['user'] . "</b> does not exist in database.";
	}
	else{
		print $welcome;
		if($user_role == 'M'){
			print <<<_HTML_
			<br><a href="view_customers.php">View all customers</a>
			<br><a href="logout.php"> Manager logout </a>
_HTML_;
		}
		else{
			print <<<_HTML_
			<br><a href="view_customers.php">View all customers</a>
			<br><a href="logout.php"> Employee logout </a>
_HTML_;
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