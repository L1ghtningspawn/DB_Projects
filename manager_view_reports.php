<?php
define("IN_CODE", 1);
include 'dbconfig2.php';

if (count($_COOKIE['Elogin']) > 0){
    $query= "select role from EMPLOYEE2 where login ='" . mysqli_real_escape_string($con,strtolower($_COOKIE['Elogin'])) . "';";
    $result = mysqli_query($con , $query);
    $role;
    if($result){
		if(mysqli_num_rows($result)>0){			
            while($row = mysqli_fetch_array($result)){
                $role=$row['role'];
            }
        }
    }

    if($role == 'M'){
        $period;
        $table;
        if($_POST['sale_type']=="all_sales"){
            //product name, current quanity, quanity sold, unit cost, price was sold, customer name, net profit of the order, order date
            
            echo "<TABLE border=1>\n";
            echo "<TR><TD><b>#<TD><b>Product Name<TD><b>Vendor name<TD><b>Unit Cost<TD><b>Current Quanity<TD>
            <b>Sold Quanity<TD><b>Sold Unit Price<TD><b>Sub Total<TD><b>Profit<TD><b>Customer Name<TD><b>Order Date\n";

            $query = "select o.id, p.name as pname, v.name as vname, p.cost as pcost, p.quanity as pquanity, po.quanity as poquanity, 
            p.sell_price as psell_price, p.sell_price*po.quanity as sub_total,
            ((p.sell_price*po.quanity)-(p.cost*po.quanity)) as profit, 
            concat(c.first_name, c.last_name) as name, o.date as odate
            from Orders o, Product p, Product_Order po, CPS5740.VENDOR v,
            CUSTOMER c
            where
            o.id =po.order_id and
            po.product_id=p.id and
            p.vendor_id=v.vendor_id and
            o.customer_id=c.customer_id ";
            
            if($_POST['period']=="past week"){
                $query=$query 
                . "and o.date>date_sub(date(now()), interval 1 week)";
            }
            elseif($_POST['period']=="current month"){
                $query=$query 
                . "and month(o.date)=month(now())";
            }
            elseif($_POST['period']=="past month"){
                $query=$query 
                . "and o.date>date_sub(date(now()), interval 1 month)";
            }
            elseif($_POST['period']=="year"){
                $query=$query 
                . "and year(o.date)=year(now())";
            }
            elseif($_POST['period']=="past year"){
                $query=$query 
                . "and o.date>date_sub(date(now()), interval 1 year)";
            }
            $query=$query . ";";
            //echo "<br>".$query;
            $result = mysqli_query($con2 , $query);
            if($result){
                if(mysqli_num_rows($result)>0){			
                    while($row = mysqli_fetch_array($result)){
                        echo "<TR><TD>" . $row['id'] . "<TD>". $row['pname'] . "<TD>". $row['vname'] . "<TD>" . 
                        $row['pcost'] . "<TD>" . $row['pquanity'] . "<TD>". $row['poquanity'] ."<TD>" .
                        $row['psell_price'] ."<TD>". $row['sub_total']."<TD>". $row['profit']."<TD>".$row['name']."<TD>" . 
                        $row['odate'] . "\n"; //maybe didnt end table correctly?
                    }
                }
            }
            
        }
        elseif($_POST['sale_type']=="products"){
            $subtotal=0;
            $totalp = 0;
            echo "<TABLE border=1>\n";
            echo "<TR><TD><b>#<TD><b>Product Name<TD><b>Vendor name<TD><b>Average unit Cost<TD><b>Current Quanity<TD>
            <b>Sold Quanity<TD><b>Sold Unit Price<TD><b>Sub Total<TD><b>Profit\n";
            $query="select p.id as pid, p.name as pname, v.name as vname, p.cost as pcost, p.quanity as pquanity, sum(po.quanity) as sold_quanity, 
            p.sell_price as psell_price, p.sell_price*sum(po.quanity) as sub_total, 
            ((p.sell_price*sum(po.quanity))-(p.cost*sum(po.quanity))) as profit
            from Product p, Product_Order po, CPS5740.VENDOR v
            where
            p.id=po.product_id and
            p.vendor_id=v.vendor_id ";
            
            if($_POST['period']=="past week"){
                $query=$query 
                . "and o.date>date_sub(date(now()), interval 1 week)";
            }
            elseif($_POST['period']=="current month"){
                $query=$query 
                . "and month(o.date)=month(now())";
            }
            elseif($_POST['period']=="past month"){
                $query=$query 
                . "and o.date>date_sub(date(now()), interval 1 month)";
            }
            elseif($_POST['period']=="year"){
                $query=$query 
                . "and year(o.date)=year(now())";
            }
            elseif($_POST['period']=="past year"){
                $query=$query 
                . "and o.date>date_sub(date(now()), interval 1 year)";
            }
            $query=$query . " group by p.id;";

            $result = mysqli_query($con2 , $query);
            if($result){
                if(mysqli_num_rows($result)>0){			
                    while($row = mysqli_fetch_array($result)){
                        echo "<TR><TD>" . $row['pid'] . "<TD>". $row['pname'] . "<TD>". $row['vname'] . "<TD>" . 
                        $row['pcost'] . "<TD>" . $row['pquanity'] . "<TD>". $row['sold_quanity'] ."<TD>" .
                        $row['psell_price'] ."<TD>". $row['sub_total']."<TD>". $row['profit'] ."\n";

                        $subtotal=$subtotal+$row['sub_total'];
                        $totalp=$totalp+$row['profit'];
                    
                    }
                }
            }
            echo "<TR><TD>Total<TD><TD><TD><TD><TD><TD><TD>".$subtotal."<TD>" . $totalp;
        }
        else{ //vendors bonus

        }
        
    }
    else{
        echo "You aren't a manager.";
    }
}
else{
    echo "You must login first to view this page!";
    echo '<br><a href="employee_login_p2.php"> Employee Login Page </a>';
}
?>