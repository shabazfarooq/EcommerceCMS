<?php
	require('header.php');
	
	$error         = FALSE;
	$success       = FALSE;
	
	$errorString   = "";
	
	
	
	
	
	// Check to see if the user has attempted to submit/POST
	if( isset($_REQUEST['submit']) ) {	
		
		
		// Check for an error in the image, if an image has been uploaded
		if ( isset($_FILES['fileup']) && strlen($_FILES['fileup']['name']) > 1)	{
		
			$uploadpath = '../slideshow/';      						                         // directory to store the uploaded files
			$allowtype  = array('bmp', 'gif', 'jpg', 'jpe', 'png', 'JPG', 'JPEG', 'jpeg');    // allowed extensions
			
			
			$filename            = basename($_FILES['fileup']['name']);
			$sepext              = explode('.', strtolower($_FILES['fileup']['name']));
			$type                = end($sepext);      								// gets extension
			
			
			// Checks if the file has allowed type, size, width and height (for images)
			if (!in_array($type, $allowtype)) {
				$errorString .= "ERROR: The file <b>'". $_FILES['fileup']['name']. "'</b> is not an allowed extension type.<br><br>";
				$error       = TRUE;
			} else {
				

				$fullUploadPath           = $uploadpath . "/". $filename;
    
				if(!move_uploaded_file($_FILES['fileup']['tmp_name'], $fullUploadPath)) {
					$errorString .= "ERROR: Image upload unsuccessful<br><br>";
					$error        = TRUE;
				} else {

					// Add product to database
				    $sql   = "INSERT INTO slideshow (filename) VALUES ('$filename')";
		          
		            if (!mysqli_query($cxn,$sql)) {
		              die('SQL Error: ' . mysqli_error($con));
		            } else {
			            $success = TRUE;
		            }

				}
				
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
						echo "<b style=\"color:green\">Successfully added image '" . $filename . "' to slideshow</b>";
					} else {
						echo "<b style=\"color:red\">" . $errorString . "</b>";
					}
				
				?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" width="280px"><p><b>Add a new image to the slideshow:</b></p><p style="font-size:11px;">850 x 500 is the frame size</p></td>
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



	<br><br><br>







	<table width="790px" cellspacing="0px" cellpadding="10px" style="margin-left:10px;">
	
		<tr>
			<td valign="top" width="280px"><p><b>Delete an image from the slideshow:</b></p></td>
		</tr>

	</table>
	
	
	<?php
	
	
	
		// IF YOU GET A DELETE REQUEST
		$delete_id     = $_GET["del_id"];


		// If a delete request has been called
		if ($delete_id != '') {
			
			// Delete product from database
		    $sql   = "DELETE FROM slideshow where id='$delete_id'";
	      
	        if (!mysqli_query($cxn,$sql)) {
	          die('SQL Error: ' . mysqli_error($cxn));
	        }
	        
		}
		
		
		
		
		// If you get a request to show/hide an image
		$display_id  = $_GET["display_id"];
		$set         = $_GET["set"];


		// If a delete request has been called
		if ($display_id != ''  &&  $set != '') {
			
			
			// Delete product from database
		    $sql = "UPDATE slideshow SET display='$set' WHERE id='$display_id'";

	      
	      
	        if (!mysqli_query($cxn,$sql)) {
	          die('SQL Error: ' . mysqli_error($cxn));
	        }
	        
	        
	        	        
		}






		// Display images from slideshow
		$query = "SELECT * FROM slideshow ORDER BY id DESC" or die ("can't connect");
		$result = mysqli_query($cxn,$query);
		
		
		while($row = mysqli_fetch_assoc($result)){
			$id          = $row['id'];
			$filename    = $row['filename'];
			$display     = $row['display'];
			
			
			?>
			
			
			<div id="product_on_category_page">
				<img src="../slideshow/<?php echo $filename; ?>" width="175px" height="175px" <?php if ($display == 0) echo 'style="opacity:0.2;"'; ?>>
				<br>
				<br>

				
				<div id="view_button" style="background-color:#EEE;">
				  <a href="?display_id=<?php echo $id; ?>&set=<?php if ($display==1) {echo '0'; } else {echo '1'; } ?>" style="font-size:12px;">
				  
				  <?php
				  
				  // SHOWN
				  if ($display == 1) {
					  echo '<b>HIDE IMAGE</b>';
				  } else {
				  // HIDDEN
				      echo '<b>SHOW IMAGE</b>';
				  }
				  
				  ?>
				  
				  </a>
				</div>
				
				
				<br>
				
				
				<div id="view_button" style="background-color:rgb(202,0,63);">
				  <a onclick="deleteConfirm(<?php echo $id; ?>)" style="font-size:12px;"><b>DELETE IMAGE</b></a>  
				</div>
				
			</div>
			
			
			<?php
			
		}

	
	?>
	
	
	<script>
	
	function deleteConfirm(del_id) {
	    
	    if (confirm("Delete this image from the slideshow?") == true) {
	        window.location.href = "?del_id=" + del_id;
	    }
	    
	}
	
	</script>


<?php
	
	include('footer.php');
	
?>