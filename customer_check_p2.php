<?php
define("IN_CODE", 1);
include 'dbconfig2.php';

if (count($_COOKIE['Clogin']) > 0){
    echo "Welcome customer: ";

    $query = "select login_id, concat(first_name,' ',last_name) as name from CUSTOMER where customer_id=" . $_COOKIE['Clogin'] . ";";
    $result = mysqli_query($con2 , $query);

    if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
                echo "<b>" . $row['name'] . "</b>";
            }
        }
    }
    echo "<br>1000 Morris Ave, Union, NJ 07083";
    echo "<br>Your IP: " . $_SERVER['REMOTE_ADDR'];
    $ip_subnet=explode(".",$_SERVER['REMOTE_ADDR']);
	if ($ip_subnet[0] == "10" || ($ip_subnet[0] == "131" and $ip_subnet[1]=="125"))
		echo "<br>You are from Kean University";
	else{
		echo "<br>You are NOT from Kean University";
	}  
    

    print<<<_HTML_
    <br><a href = "c_logout.php"> Customer logout </a>
    <br><a href = "update_profile_p2.php"> Update Profile</a>
    <br><a href = ""> View my order history</a>
    <br>
    <br>search product(* for all):
    <form method="POST" action="search_product.php">
    <input type="text" name="search">
    <input type='submit' value='Search'>
    </form>
    Ad code here...

    <br><a href ="index.html"> Project Home Page </a>
_HTML_;
}
else{
    echo "You must login first to view this page!";
    echo '<br><a href="customer_login_p2.php"> Customer Login Page </a>';
}


?>