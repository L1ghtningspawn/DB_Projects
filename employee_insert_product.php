<?php
define("IN_CODE", 1);
include 'dbconfig2.php';


if (count($_COOKIE['Elogin']) > 0){
    //Adding product
    
    if($_POST['name']){

        //get employee ID
        $query = "select employee_id from EMPLOYEE2 where login ='" . $_COOKIE['Elogin'] . "';";
        $id;
        $result = mysqli_query($con , $query);
        if($result){
            if(mysqli_num_rows($result)>0){			
                while($row = mysqli_fetch_array($result)){
                    $id=$row['employee_id'];
                }
            }
        }
        //create insert query
        $insert = "insert into Product (name, description, vendor_id, cost, sell_price, quanity, employee_id) values('" . 
        strtolower($_POST['name']). "', '" .
        strtolower($_POST['desc']). "'," .
            $_POST['Vendor']. "," .
            $_POST['cost']. "," .
            $_POST['sell']. "," .
            $_POST['qty']. "," .
            $id . ");";
        
        //check if product exists
        $query = "select name from Product where name ='" . strtolower($_POST['name']) . "';";
        $result = mysqli_query($con2 , $query);
        
        
        
        //insert product if doesnt exist
        if(mysqli_num_rows($result)>0)
            echo "This product name already exists. Please try again.";
        elseif($_POST['cost']<0 || $_POST['sell']<0 || $_POST['qty']<0 || $_POST['cost']>$_POST['sell']){
            echo "No negative values and cost must be less than sell price!";
        }
        else{
            mysqli_query($con2 , $insert);
            echo "Product added!";
        }


    }
    
    
    $query = "select name, vendor_id from VENDOR;";
    $result = mysqli_query($con , $query);
    print<<<_HTML_
	<form method="POST" action="$_SERVER[PHP_SELF]">
    Product Name: <input type="text" name="name" required="required">
	<br>Description: <input type="text" name="desc" required="required">
	<br>Cost: <input type="text" name="cost" required="required">
	<br>Sell Price: <input type="text" name="sell" required="required">
	<br> Quanity:<input type="text" name="qty" required="required">
    <br> Select Vendor:  <select name="Vendor" required="required">
    <option value></option>
_HTML_;

//Create vendor list from VENDOR table
    if($result){
        if(mysqli_num_rows($result)>0){			
            while($row = mysqli_fetch_array($result)){
                    echo '<option value="' . $row['vendor_id'] .'">' . $row['name'] . '</option>';
            }
        }
    }
	print<<<_HTML_
    </select>
    <br><input type="submit" value="Add Product!">
    </form>
_HTML_;
echo "<br><a href='logout.php'> Logout </a>";
}
else{
    echo "You must login first to view this page!";
    echo '<br><a href="employee_login_p2.php"> Employee Login Page </a>';
}

?>