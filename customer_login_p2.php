
<?php

if ($_POST['user'] && $_POST['pwd']|| (count($_COOKIE['Clogin']) > 0)){
    
    $server = "imc.kean.edu";
    $login = "blondebr";
    $password = "1027490";
    $dbname = "2019F_blondebr";
    if(count($_COOKIE['Clogin']) > 0){
        header('Location: http://eve.kean.edu/~blondebr/CPS5740/customer_check_p2.php');
    }
    
    $con = mysqli_connect($server, $login, $password, $dbname);
    //test connection
    if (!$con){
        die("Connection Error" . mysqli_connect_error());
    }
    $query = "select login_id, password, customer_id from CUSTOMER;";
    $result = mysqli_query($con , $query);
    
    
    if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
                if((strtolower($row['login_id'])==strtolower($_POST['user']) && $row['pwd']==$_POST['password'])){
                    setcookie('Clogin', $row['customer_id'], time()+(60*20));
                    header('Location: http://eve.kean.edu/~blondebr/CPS5740/customer_check_p2.php');
                    
                    
                }
            }
        }
    }
    
    else
        echo "Authentication Error.";
}
elseif($_POST['user']){
    echo"Please enter Login ID";
}
elseif($_POST['pwd']){
    echo"Please enter password";
}
else{
    print<<<_HTML_
    <h> <title> Customer Login! </title>
    <b>Customer Login!</b> </h> 
    <br>
    <br>
	<form method="POST" action="$_SERVER[PHP_SELF]">
	Your name: <input type="text" name="user">
	<br>Password: <input type="password" name="pwd">
	<input type="submit" value="Login">
	</form>
_HTML_;
}
?>