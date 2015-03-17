<?php
	require('header.php');
	
	$error         = FALSE;
	$success       = FALSE;
	
	$errorString   = "";
	
	
	// Check to see if the user has attempted to submit/POST
	if( isset($_REQUEST['submit']) ) {
	
		// Assign all post variables
		$category    = $_REQUEST['category'];
		$title       = $_REQUEST['title'];
		
			
	
		// Check the ensure required fields have been filled
		if ( strlen($category) == 0 || strlen($title) == 0) {
			$errorString .= "ERROR: Title and Category MUST be filled<br><br>";
			
			$error = TRUE;
		} else {
				
			// Add category to database
		    $sql   = "INSERT INTO categories (type, name) VALUES ('$category','$title')";
          
            if (!mysqli_query($cxn,$sql)) {
              die('SQL Error: ' . mysqli_error($con));
            } else {
	            $success = TRUE;
            }
			
		}
		
		
	}
?>

	


	

	
	<form method="POST" action="" enctype="multipart/form-data">

	<table width="790px" cellspacing="0px" cellpadding="10px" style="margin-left:10px;">
	
		<tr style="padding:40px;">
			<td colspan="2">
				<?php
				
					if ($success == TRUE && $errorString == "") {
						echo "<b style=\"color:green\">Successfully added category " . $title . "</b>";
					} else {
						echo "<b style=\"color:red\">" . $errorString . "</b>";
					}
				
				?>
			</td>
		</tr>
		
		
		
		<tr>
			<td><p>Title: <b style="color:red;">*</b></p></td>
			<td>
			
				<?php
					if ($error) {
						echo '<input type="text" name="title" value="' . $title . '">';
					} else {
						echo '<input type="text" name="title">';
					}
				?>
				
			
			</td>
		</tr>
		
		
		<tr>
			<td width="300px"><p>New Category OR Sub Category: <b style="color:red;">*</b></p></td>
			<td>
				
				<select name="category">
				
				<?php
				
					
					// Keep the same item selected after post
					if ($category == $id) {
						echo '<option value="0" selected><li>- New Category -</option>';
					} else {
						echo '<option value="0"><li>- New Category -</option>';
					}
						
					
				
					// List the categories stored in the database
					$query = "SELECT * FROM categories WHERE type = 0" or die ("can't connect");
					$result = mysqli_query($cxn,$query);
					
					while($row = mysqli_fetch_assoc($result)){
						$id   = $row['id'];
						$name = $row['name'];
						
						
						// Keep the same item selected after post
						if ($category == $id) {
							echo '<option value="'.$id.'" selected><li>'.$name.'</option>';
						} else {
							echo '<option value="'.$id.'"><li>'.$name.'</option>';
						}
					}
					
				?>
				</select>
				
				
			</td>
		</tr>
		

		

		<tr>
			<td valign="top"> </td>
			<td valign="top">
				<div align="right">
					<input type="submit" value="Submit" name="submit" style="background-color: rgb(202,0,63); color:white;">
				</div>
			</td>
		</tr>
	</table>
	
	</form>



<?php
	
	include('footer.php');
	
?>