<?php

	require('header.php');



	// Check to see if the user has attempted to submit/POST
	if( isset($_REQUEST['submit']) ) {
	
		$title = $_REQUEST["title"];
		$id    = $_REQUEST["id"];
	
		// Check the ensure required fields have been filled
		if ( strlen($title) != 0) {
			$sql = "UPDATE categories SET name='$title' WHERE id='$id'";

            if (!mysqli_query($cxn,$sql)) {
              die('SQL Error: ' . mysqli_error($cxn));
            } else {
	            ?> <meta http-equiv="refresh" content="0;url=viewCategories.php"> <?php
            }

        }
		
	}
	
	
	
	
?>

	

	
	<form method="POST" action="" enctype="multipart/form-data">

	<table width="790px" cellspacing="0px" cellpadding="10px" style="margin-left:10px;">
		<tr>
			<td><p>New Title: <b style="color:red;">*</b></p></td>
			<td>
			<div align="right">
				<?php
				
					$category    = $_REQUEST['category'];
				
					// List the categories stored in the database
					$query = "SELECT * FROM categories WHERE id = $category" or die ("can't connect");
					$result = mysqli_query($cxn,$query);
					
					while($row = mysqli_fetch_assoc($result)){
						$id   = $row['id'];
						$name = $row['name'];
						
						echo '<input type="text" name="title" value="' . $name . '">';
						echo '<input type="hidden" name="id" value="' . $id . '">';
						
					}
					
				?>
				</div>
			</td>
		</tr>
		
		<tr>
			<td valign="top"> </td>
			<td valign="top">
				<div align="right">
					<input type="submit" value="Update" name="submit" style="background-color: rgb(202,0,63); color:white;">
				</div>
			</td>
		</tr>
	</table>
	
	</form>
	
	
	



<?php
	
	include('footer.php');
	
?>