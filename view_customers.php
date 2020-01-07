<?php
if((count($_COOKIE['Elogin']) > 0)){
    $server = "imc.kean.edu";
    $login = "blondebr";
    $password = "1027490";
    $dbname = "2019F_blondebr";
    $table = "CUSTOMER";
    //create connection
    $con = mysqli_connect($server, $login, $password, $dbname); 

    //test connection
    if (!$con){
        die("FAILED" . mysqli_connect_error());
    }
    $query = "select customer_id, login_id, password, last_name, first_name, tel, address, city, zipcode, state from " . $table .";";
//opens connection to mysql and then selects table
    $result = mysqli_query($con , $query);
    if($result){
        if(mysqli_num_rows($result)>0){
            echo "<html>\n The following employees are in the database. </html>";
            echo "<TABLE border=1>\n";
            echo "<TR><TD><b>ID<TD><b>Login<TD><b>Password<TD><b>Last Name<TD><b>First Name<TD><b>TEL<TD><b>Address<TD><b>City<TD><b>Zipcode<TD><b>State\n";
            while($row = mysqli_fetch_array($result)){
                $id = $row['customer_id'];
                $login_id= $row['login_id'];
                $pwd =$row['password'];
                $lname = $row['last_name'];
                $fname = $row['first_name'];
                $tel = $row['tel'];
                $rladdress = $row['address'];
                $city = $row['city'];
                $zip = $row['zipcode'];
                $state = $row['state'];
                echo "<TR><TD>$id<TD>$login_id<TD>$pwd<TD>$lname<TD>$fname<TD>$tel<TD>$rladdress<TD>$city<TD>$zip<TD>$state\n";
            }
        }
        else{
            echo "<br>No records in the database.\n";
            mysqli_free_result($result);
        }
    }
    else{
        echo "<br> Query error or database error. \n";
    }
    mysqli_close($con);
    } 
else {
    echo "You have to login as a employee or manager to see the customers";
}
?>