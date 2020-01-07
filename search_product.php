<?php
define("IN_CODE", 1);
include 'dbconfig2.php';


//TO-DO SET TRANSACTION
if (count($_COOKIE['Clogin']) > 0){
    
    $query;
    $count;
    if($_POST['search']=="*"){ //search all products
        //after searching for specfic string and doing a transaction it returns to
        //all products print but wont print this???
        //echo "?????????????????????" . $_POST['search'];
        
        
        //transaction
        if($_POST['product_id']){
            for($i=0; $i< count( $_POST['product_id'] ); $i++) {
                if($_POST['quanity'][$i]>0){//if negative
                    $query="select quanity from Product where id=" . $_POST['product_id'][$i] . "; ";
                    $result = mysqli_query($con2, $query);
                    $row = mysqli_fetch_assoc($result);
                    if($row['quanity']<$_POST['quanity'][$i]){//if quanity remaining is less than quanity ordered
                        echo "Not enough stock left. ";
                    }
                    else{
                    $query="update Product set quanity= quanity-".$_POST['quanity'][$i]." where id=".$_POST['product_id'][$i]." ; ";
                    $result = mysqli_query($con2, $query);
                    
                    //insert order to ORDERS
                    $query = "insert into Orders(customer_id,date) values(" .$_COOKIE['Clogin']
                    . ", now());";
                    $result = mysqli_query($con2,$query);

                    //get the order id and insert to product_order
                    $query= "select last_insert_id() as nid;";
                    $result = mysqli_query($con2,$query);
                    $row = mysqli_fetch_assoc($result);
                    $nid = $row['nid'];
                    $query = "insert into Product_Order(order_id,product_id,quanity) values(". $nid
                    . "," . $_POST['product_id'][$i] . "," . $_POST['quanity'][$i] . ");";
                    $result = mysqli_query($con2,$query);
                    
                    echo "Wowwwie, we completed a transaction";
                    
                    }
                }
                else {
                    if($_POST['quanity']<0)
                        echo"NO NEGATIVE VALUES";
                }
                
                
            }
        }
        
        
        
        echo "<TABLE border=1>";
        echo "<TR><TD><b>Product Name</b><TD><b>Description</b><TD><b>Sell Price
        </b><TD><b>Available Quanity</b><TD><b>Order Quanity</b><TD><b>Vendor</b>\n";
        $query="select p.id, p.name,p.description,p.sell_price,p.quanity as q,
        v.name as vname
        from Product p, CPS5740.VENDOR v
        where p.vendor_id=v.vendor_id;";
        
        echo '<form method="POST" action="search_product.php">';
        echo "<input type='hidden' name='search' value='".$_POST['search'] ."'>";

        $result = mysqli_query($con2, $query);
        
        
        
        if($result){
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    
                    echo "<TR><TD bgcolor = 'yellow'><input type='hidden' name='product_id[]' value='". $row['id'] ."'>" . 
                    $row['name'] . "</TD>"  ."<TD>" .$row['description'] ."<TD>" . 
                    $row['sell_price'] . "<TD>" . $row['q']. "<TD>\n" . 
                    ' <input type="text" name="quanity[]"' .'value=0><TD>' .
                    $row['vname'];
                }
                echo "<name='count' value =" . $count . ">";
                
            }
            
        }
        else{
            echo "HELP ME";
        }
        echo "</TD></TR></table>";
        echo " <input type='submit' value='Place Order'></form>";
        
        
        }
    else{//search for term query
        //could optimize only using this search query
        
        
        
        //transaction
        if($_POST['product_id']){
            for($i=0; $i< count( $_POST['product_id'] ); $i++) {
                if($_POST['quanity'][$i]>0){//if negative
                    $query="select quanity from Product where id=" . $_POST['product_id'][$i] . "; ";
                    $result = mysqli_query($con2, $query);
                    $row = mysqli_fetch_assoc($result);
                    if($row['quanity']<$_POST['quanity'][$i]){//if quanity remaining is less than quanity ordered
                        echo "Not enough stock left. ";
                    }
                    else{
                    $query="update Product set quanity= quanity-".$_POST['quanity'][$i]." where id=".$_POST['product_id'][$i]." ; ";
                    $result = mysqli_query($con2, $query);
                    
                    //insert order to ORDERS
                    $query = "insert into Orders(customer_id,date) values(" .$_COOKIE['Clogin']
                    . ", now());";
                    $result = mysqli_query($con2,$query);

                    //get the order id and insert to product_order
                    $query= "select last_insert_id() as nid;";
                    $result = mysqli_query($con2,$query);
                    $row = mysqli_fetch_assoc($result);
                    $nid = $row['nid'];
                    $query = "insert into Product_Order(order_id,product_id,quanity) values(". $nid
                    . "," . $_POST['product_id'][$i] . "," . $_POST['quanity'][$i] . ");";
                    $result = mysqli_query($con2,$query);
                    
                    echo "Wowwwie, we completed a transaction";
                    
                    }
                }
                else {
                    if($_POST['quanity']<0)
                        echo"NO NEGATIVE VALUES";
                }
                
                
            }
        }
        
        
        
        echo "<TABLE border=1>";
        echo "<TR><TD><b>Product Name</b><TD><b>Description</b><TD><b>Sell Price
        </b><TD><b>Available Quanity</b><TD><b>Order Quanity</b><TD><b>Vendor</b>\n";
        $query="select p.id, p.name,p.description,p.sell_price,p.quanity,
        v.name as vname
        from Product p, CPS5740.VENDOR v
        where p.vendor_id=v.vendor_id and (p.name like '%" . strtolower($_POST['search']) ."%' or p.description like '%" . strtolower($_POST['search']) . "%');";
        
        echo '<form method="POST" action="search_product.php">';
        echo "<input type='hidden' name='search' value='".$_POST['search'] ."'>";

        $result = mysqli_query($con2, $query);
        
        
        
        if($result){
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    
                    echo "<TR><TD bgcolor = 'yellow'><input type='hidden' name='product_id[]' value='". $row['id'] ."'>" . 
                    $row['name'] . "</TD>"  ."<TD>" .$row['description'] ."<TD>" . 
                    $row['sell_price'] . "<TD>" . $row['quanity']. "<TD>\n" . 
                    ' <input type="text" name="quanity[]"' .'value=0><TD>' .
                    $row['vname'];
                }
                echo "<name='count' value =" . $count . ">";
                
            }
            
        }
        else{
            echo "HELP ME";
        }
        echo "</TD></TR></table>";
        echo " <input type='submit' value='Place Order'></form>";
    }
}
else{
    echo "You must login first to view this page!";
    echo '<br><a href="customer_login_p2.php"> Customer Login Page </a>';
}
?>