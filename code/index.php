<?php session_start(); ?>
<html>
<head>
<meta charset="utf-8">
<title>Mr Tobacco II</title>

</head>

<body bgcolor="#FFFFFF">
<div align="center">

	<?php
	
		if (isset($_SESSION['currently_logged_in_status'])) {
			?> <meta http-equiv="refresh" content="0;url=addProduct.php"> <?php
		} else {
			
		
	?>


	<br><br><br><br><br>
	<table width="400px" height="300">
		<tr>
			<td><div align="center">Administration Login</div></td>
		</tr>
		
		<tr>
			<td>
				<div align="center">
				<form  action="" method="POST" enctype="multipart/form-data">
            		<input type="hidden" name="action" value="submit">	
            		Username
            		<br>
            		<input name="username" type="text" value="" size="20" style="width: 200px;" maxlength="50"/><br><br>

            		Password
            		<br>
            		<input name="password" type="password" value="" size="20" style="width: 200px;" maxlength="50"/><br><br>
							
            		<input type="submit" value="Submit"/>
            	</form>
            	</div>
            </td>
    	</tr>
    </table>
    
    <?php
    	
    	} // End if



		//******
		// The following code checks the user's input
		//******
		
			
    	// Include database connection file
    	include("../includes/sql.php");
    
    
    

    	// If the user has attempted to login
		$action = $_REQUEST['action'];
		
		if ($action != "") {
	  	
	  		
	  		// Store user inputted information in variables
	  		$username   = $_REQUEST['username'];
			$password   = $_REQUEST['password'];
			
	   
	   
	   		// If either the username or password field is empty, throw an error
			if ( ($username == "") || ($password=="") ) {
		 	 	echo '<p>You must be enter both a username and password.</p>';
			} else {
			
			
		  		// If the user entered both a username and password, connect to the database and see if is a valid user
		  		$query = "SELECT  * FROM users " or die ("can't connect");
				$result = mysqli_query($cxn,$query);

				while ($row = mysqli_fetch_assoc($result)) {
					
					$db_username  =  $row['username'];
					$db_password  =  $row['password'];
					
					
					if ( ($username == $db_username) && ($password == $db_password) ) {
						
						$login_result = "true_admin";
				
					}
					
				}
									
				
	
				// Create a session if the login was a success
				// Also, determine if the user is an admin or not.
				if ($login_result == "true_admin") {
				
					 $_SESSION['currently_logged_in_status'] = "true_admin";
					 
					?> <meta http-equiv="refresh" content="0;url=addProduct.php"> <?php

					 
				} else if ($login_result == "true_regular") {
				
					 $_SESSION['currently_logged_in_status'] = "true_regular";
					 
					?> <meta http-equiv="refresh" content="0;url=addProduct.php"> <?php
					 
				} else {
				
					echo "Invalid username or password.";
					
				}
			   	

			}
			
			
		}


	  
	?>

    

</div>   
</body>

</html>