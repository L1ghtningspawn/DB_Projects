<html>
	<?php
		//Successful login should post:
		// state IP /n location /n "Welcome *employee type*: name 
		// /n *e_type* logout hyperlink
		$user_name = $_POST["user"];
		$password=trim($_POST["pwd"]);
	
		echo "Welcome user: " . $user_name. "<br>\n";
		echo "Your password: " . $password . "<br>\n";
	?>
</body>
</html>