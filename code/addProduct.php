<?php
	require('header.php');
	
	$error         = FALSE;
	$uploadedImage = FALSE;
	$success       = FALSE;
	
	$errorString   = "";
	
	
	// Check to see if the user has attempted to submit/POST
	if( isset($_REQUEST['submit']) ) {
	
		// Assign all post variables
		$category    = $_REQUEST['category'];
		$title       = $_REQUEST['title'];
		$price       = $_REQUEST['price'];
		$description = $_REQUEST['description'];
		$image       = $_REQUEST['image'];	
		
		
		// Check for an error in the image, if an image has been uploaded
		if ( isset($_FILES['fileup']) && strlen($_FILES['fileup']['name']) > 1)	{
		
			$uploadpath = '../products/';      						                         // directory to store the uploaded files
			$allowtype  = array('bmp', 'gif', 'jpg', 'jpe', 'png', 'JPG', 'JPEG', 'jpeg');    // allowed extensions
			
			$uploadedImage = TRUE;
			
			$filename            = basename($_FILES['fileup']['name']);
			$sepext              = explode('.', strtolower($_FILES['fileup']['name']));
			$type                = end($sepext);      								// gets extension
			
			// Checks if the file has allowed type, size, width and height (for images)
			if (!in_array($type, $allowtype)) {
				$errorString .= "ERROR: The file <b>'". $_FILES['fileup']['name']. "'</b> is not an allowed extension type.<br><br>";
				$error       = TRUE;
			}
			
		}
			
	
		// Check the ensure required fields have been filled
		if ( strlen($category) == 0 || strlen($title) == 0) {
			$errorString .= "ERROR: Category and Title MUST be filled<br><br>";
			
			$error = TRUE;
		} else {


			// If no errors, upload the image, else, output the errors
			if($imageError == '' && $uploadedImage) {
			
				$fullUploadPath           = $uploadpath . "/". $filename;
    
				if(!move_uploaded_file($_FILES['fileup']['tmp_name'], $fullUploadPath)) {
					$errorString .= "ERROR: Image upload unsuccessful<br><br>";
					$error = TRUE;
				}
				
			} else {
				$filename = 'NOIMAGE.png';
			}
			
			
			
			// Add product to database
		    $sql   = "INSERT INTO products (category_id, title, price, description, image) VALUES ('$category','$title','$price','$description','$filename')";
          
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
						echo "<b style=\"color:green\">Successfully added product " . $title . "</b>";
					} else {
						echo "<b style=\"color:red\">" . $errorString . "</b>";
					}
				
				?>
			</td>
		</tr>
		
		<tr>
			<td width="300px"><p>Category: <b style="color:red;">*</b></p></td>
			<td>
				
				<select name="category">
				<?php
				
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
						
						
									// retrieve SUB CATEGORIES
									$query2 = "SELECT * FROM categories WHERE type = $id " or die ("can't connect");
									$result2 = mysqli_query($cxn,$query2);
									
									while($row2 = mysqli_fetch_assoc($result2)) {
										$id2   = $row2['id'];
										$name2 = $row2['name'];
										
									
										
										if ($category == $id2) {
											echo '<option value="'.$id2.'" selected style="color:#555"><li>&emsp; - '.$name2.'</option>';
										} else {
											echo '<option value="'.$id2.'" style="color:#555"><li>&emsp; - '.$name2.'</option>';
										}
										
										
									}
						
						
					}
				?>
				</select>
				
				
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
			<td><p>Price:</p></td>
			<td>
			
				<?php
					if ($error) {
						echo '<input type="text" name="price" value="' . $price . '">';
					} else {
						echo '<input type="text" name="price">';
					}
				?>
				
			
			</td>
		</tr>
		<tr>
			<td valign="top"><p>Description:</p></td>
			<td>
				<div align="left">
				
					<?php
						if ($error) {
							echo '<textarea rows="13" name="description">' . $description . '</textarea></td>';
						} else {
							echo '<textarea rows="13" name="description"></textarea></td>';
						}
					?>
					
				</div>
		</tr>
		<tr>
			<td valign="top"><p>Image:</p></td>
			<td><input type="file" style="padding: 0px;" class="text" name="fileup" /></td>
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