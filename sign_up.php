<?php
if($_POST['user']!=null &&($_POST['pwd1']==$_POST['pwd2'])){
	
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
	
	//check available ID && check if username free
	$query = "select customer_id, login_id from " . $table . ";";
	

	$insert = "insert into " . $table . "(login_id, password, first_name, last_name, tel, address, city, zipcode, state) values(" . "'" . $_POST['user'] . "'" 
	. ", " . "'" . $_POST['pwd2'] . "'" 
	. ", " . "'" . $_POST['fname'] . "'"
	. ", " . "'" . $_POST['lname'] . "'"
	. ", " . "'" . $_POST['tel'] . "'"
	. ", " . "'" . $_POST['address'] . "'"
	. ", " . "'" . $_POST['city'] . "'"
	. ", " . "'" . $_POST['zip'] . "'"
	. ", " . "'" . $_POST['state'] . "'" . ");";

//checking if ID isnt taken
	$result = mysqli_query($con , $query);
	$idfree = true;
	if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
				$id = strtolower($row['login_id']);
				if($id==strtolower($_POST['user']))
					$idfree= false;
			}
		}
		else{
		echo "database error????";
		}
	}
	if($idfree==false){
		echo "that Login ID already exists: ";
	}
	else{
		mysqli_query($con , $insert);
		echo "Account successfully created!!!!!";
	}
}
elseif($_POST['pwd1']!=$_POST['pwd2']){
	echo "Password mismatch";
}
else{
	print<<<_HTML_
	<form method="POST" action="$_SERVER[PHP_SELF]">
	Login ID: <input type="text" name="user" required="required">
	<br>Password: <input type="password" name="pwd1" required="required">
	<br>Retype Password: <input type="password" name="pwd2" required="required">
	<br> First Name:<input type="text" name="fname" required="required">
	<br> Last Name:<input type="text" name="lname" required="required">
	<br> Telphone #: <input type="text" name="tel" required="required">
	<br> Address: <input type="text" name="address" required="required">
	<br> City: <input type="text" name="city" required="required">
	<br> Zipcode: <input type="text" name="zip" required="required">
	<br> State: <select name="state" required="required">
	<option value></option>
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
	<input type="submit" value="Sign up">
	</form>
_HTML_;
}

?>