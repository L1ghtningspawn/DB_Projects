<?php
define("IN_CODE", 1);
include 'dbconfig2.php';

if (count($_COOKIE['Elogin']) > 0){
    print "Your IP: " . $_SERVER['REMOTE_ADDR'];
	$ip_subnet=explode(".",$_SERVER['REMOTE_ADDR']);
	if ($ip_subnet[0] == "10" || ($ip_subnet[0] == "131" and $ip_subnet[1]=="125"))
		echo "<br>You are from Kean University";
	else{
		echo "<br>You are NOT from Kean University";
    }      
    $query = "select login, name, role from EMPLOYEE2 where login='" . mysqli_real_escape_string($con,strtolower($_COOKIE['Elogin'])) . "';";
    $result = mysqli_query($con , $query);
    
    $user_login;
    $rl_name;
    $role;
    
    if($result){
		if(mysqli_num_rows($result)>0){			
            while($row = mysqli_fetch_array($result))
            {
                $user_login = $row['login'];
				$rl_name = $row['name'];
				$role = $row['role'];
            
            }   
        }
    }
    else
        echo "db error";
    if($role == 'M'){
        echo "<b><br>Welcome " . "manager: " . $rl_name . "</b>";   
    }   
    else
        echo "<b><br>Welcome " . "employee: " . $rl_name . "</b>";
        
    echo "<br>";
    echo '<br><a href="employee_insert_product.php">Add Product</a>';
    echo '<br><a href="employee_view_vendors.php">View All Vendors</a>';
    echo '<br><a href="searchandupdate.php">Search & Update Product</a>';

    if($role == 'M'){
        print <<<_HTML_
        <form method='POST' action='manager_view_reports.php'>
        <br> View Reports - period:<select name='period'>"
        <option value="all">All</option>
        <option value="past week">past week</option>
        <option value="current month">current month</option>
        <option value="past month">past month</option>
        <option value="year">this year</option>
        <option value="past year">past year</option>
        </select>, by:

        <select name='sale_type'>
        <option value="all_sales">all sales</option>
        <option value="products">products</option>
        <option value="vendors">vendors</option>
        </select>
        <input type='submit' value='Submit'></form>

        <br><a href="logout.php"> Manager logout </a>
_HTML_;
    }
    else{
        print <<<_HTML_

        <br><a href="logout.php"> Employee logout </a>
_HTML_;
    }

}
    
else{
    echo "You must login first to view this page!";
    echo '<br><a href="employee_login_p2.php"> Employee Login Page </a>';
}
?>