<?php
if((count($_COOKIE['Clogin']) > 0)){
    
    
    $server = "imc.kean.edu";
    $login = "blondebr";
    $password = "1027490";
    $dbname = "2019F_blondebr";

    $con = mysqli_connect($server, $login, $password, $dbname);
    if (!$con){
        die("Connection Error" . mysqli_connect_error());
    }

    $query = "select first_name, last_name, address, city, zipcode from CUSTOMER;";
    $result = mysqli_query($con , $query);
    
    $first_name;
    $last_name;
    $address;
    $city;
    $zipcode;
    if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $address= $row['address'];
                $city= $row['city'];
                $zipcode= $row['zipcode'];
            }
        }
    }
    
    echo "Welcome <b>" . $first_name . " " . $last_name
    . "</b><br>Address: " . $address . "<br>City: ". $city . "<br>Zipcode: ". $zipcode;

    print "<br>Your IP: " . $_SERVER['REMOTE_ADDR'];
	$ip_subnet=explode(".",$_SERVER['REMOTE_ADDR']);
	if ($ip_subnet[0] == "10" || ($ip_subnet[0] == "131" and $ip_subnet[1]=="125"))
		echo "<br>You are from Kean University";
	else{
		echo "<br>You are NOT from Kean University<br>";
	}
    print<<<_HTML_
	<br><a href = "update_profile.php"> Update Profile</a>
    <br><a href = "c_logout.php"> Customer logout </a>
    <br><a href ="index.html"> Project Home Page </a>
_HTML_;

    
}
else{
    echo"Cookies are expired! <br>Please login again!";
}

?>
