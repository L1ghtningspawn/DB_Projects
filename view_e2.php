
<?php
//Connection details should be in seperate php file
define("IN_CODE", 1);
include("dbconfig.php");
$table = "EMPLOYEE2";
//create connection
$con = mysqli_connect($server, $login, $password, $dbname); 

//test connection
if (!$con){
    die("FAILED" . mysqli_connect_error());
}

$query = "select employee_id, login, password, name, role from " . $table .";";

//opens connection to mysql and then selects table
$result = mysqli_query($con , $query);
if($result){
    if(mysqli_num_rows($result)>0){
        echo "<html>\n The following employees are in the database. </html>";
        echo "<TABLE border=1>\n";
        echo "<TR><TD>ID<TD>Login<TD>Password<TD>Name<TD>Role\n";
        while($row = mysqli_fetch_array($result)){
            $id = $row['employee_id'];
            $login_id= $row['login'];
            $pwd =$row['password'];
            $name = $row['name'];
            $role = $row['role'];
            echo "<TR><TD>$id<TD>$login_id<TD>$pwd<TD>$name<TD>$role\n";
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
?>