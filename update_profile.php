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
        if($_POST){
            $con2 = mysqli_connect($server, $login, $password, $dbname);
            //test connection
            echo "Profile Successfully Updated!!!!";
            $query1= "update CUSTOMER 
                set password = '" . $_POST['new_pass'] . "', 
                first_name = '" . $_POST['new_fname'] . "', 
                last_name = '" . $_POST['new_lname'] . "', 
                tel = " . $_POST['new_tel'] . ", 
                address = '" . $_POST['new_rladdress'] . "', 
                city = '" . $_POST['new_city'] . "', 
                zipcode = '" . $_POST['new_zip'] . "', 
                state = '" . $_POST['new_state'] . "' 
                where customer_id = " . $_COOKIE['Clogin'] . ";";
            $update= mysqli_query($con2 , $query1);
        }
        

        $query = "select customer_id, login_id, password, last_name, first_name, tel, address, city, zipcode, state from CUSTOMER where customer_id = " . $_COOKIE['Clogin'] . ";";
        echo "<TABLE border=1>\n";
        echo "<TR><TD><b>Customer ID<TD><b>Login ID<TD><b>Password<TD><b>Last Name<TD><b>First Name<TD><b>TEL<TD><b>Address<TD><b>City<TD><b>Zipcode<TD><b>State\n";
        $result = mysqli_query($con , $query);
        if($result){
            if(mysqli_num_rows($result)>0){
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
                    echo "<TR>";
                    echo "<form method='POST' action='$_SERVER[PHP_SELF]'>
                        <TD bgcolor = 'yellow'> $id</TD>
                        <TD bgcolor = 'yellow'>$login_id</TD>
                        <TD><input type = 'text' name='new_pass' value= '$pwd'</TD>
                        <TD><input type = 'text' name='new_lname' value= '$lname'</TD>
                        <TD><input type = 'text' name='new_fname' value= '$fname'</TD>
                        <TD><input type = 'text' name='new_tel' value= '$tel'</TD>
                        <TD><input type = 'text' name='new_rladdress' value= '$rladdress'</TD>
                        <TD><input type = 'text' name='new_city' value= '$city'</TD>
                        <TD><input type = 'text' name='new_zip' value= '$zip'</TD>
                        <TD><select name='new_state'>";
                        print<<<_HTML_
                        <option value = '$state'> $state</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                        </select>
                        
                        </TD>\n
_HTML_;
                }
            }
        }

        echo "</TABLE>";
        echo "<input type='submit' value='Update Profile'></form>";
        echo "<br><a href ='c_profile_view.php'> Customer Profile Page </a>";
        echo "<br><a href ='index.html'> Project Home Page </a>";

        
    }
    else{
        echo"Cookies are expired! <br>Please login again!";
        echo "<br><a href ='index.html'> Project Home Page </a>";
    }
?>
