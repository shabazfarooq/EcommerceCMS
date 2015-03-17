<?php

	require('header.php');
	

	$delete_id = $_GET['del_id'];
	$success   = FALSE;

	// If a delete request has been called
	if ($delete_id != '') {
		
		// Delete product from database
	    $sql   = "DELETE FROM categories where id='$delete_id'";
      
        if (!mysqli_query($cxn,$sql)) {
          die('SQL Error: ' . mysqli_error($cxn));
        }
        
        $success = TRUE;
        
	}

?>

	


	
	
	<form method="POST" action="editCategory.php" enctype="multipart/form-data">
	
	<table width="790px" cellspacing="0px" cellpadding="10px" style="margin-left:10px;">
	
		<tr style="padding:40px;">
			<td colspan="2">
				<?php
				
					if ($success == TRUE) {
						echo "<b style=\"color:green\">Successfully deleted category " . $title . "</b>";
					}
				
				?>
			</td>
		</tr>
		
		<tr>
			<td width="300px"><p>Select a category to modify:</p></td>
			<td>
				
				<select name="category" id="category" onchange="updateVariable()">
				<option>Select a category</option>
				<?php
				
					// List the categories stored in the database
					$query = "SELECT * FROM categories WHERE type = 0" or die ("can't connect");
					$result = mysqli_query($cxn,$query);
					
					while($row = mysqli_fetch_assoc($result)){
						$id   = $row['id'];
						$name = $row['name'];
						
						
						echo '<option value="'.$id.'">'.$name.'</option>';
						
						
							// retrieve SUB CATEGORIES
							$query2 = "SELECT * FROM categories WHERE type = $id " or die ("can't connect");
							$result2 = mysqli_query($cxn,$query2);
							
							while($row2 = mysqli_fetch_assoc($result2)) {
								$id2   = $row2['id'];
								$name2 = $row2['name'];
							
								echo '<option value="'.$id2.'" style="color:#555">&emsp; - '.$name2.'</option>';
	
							}
						
						
					}
				?>
				</select>
				
				
			</td>
		</tr>

		<tr>
			<td valign="top"> </td>
			<td valign="top">
				<div align="right" style="display:inline;">
					<input type="submit" value="Edit Category" name="edit" style="background-color: rgb(0,202,63); color:white;  width:100%;">
				</div>
			</td>
		</tr>
		
	</table>
	
	</form>
	



	<table width="790px" cellspacing="0px" cellpadding="10px" style="margin-left:10px;">
		
		<tr>
			<td width="280px"> </td>
			<td valign="top">
			  
		      <button onclick="deleteConfirm()" style="background-color: rgb(202,0,63); color:white; width:100%;">Delete Category</button>
			</td>
		</tr>
		
	</table>







	
	
	<script>
	
	var currentCategory = "";
	
	function deleteConfirm() {
	    
	    if (confirm("Are you sure you'd like to delete this category?") == true) {
	        window.location.href = "?del_id=" + currentCategory;
	    }
	    
	}
	
	function updateVariable() {
    	currentCategory = document.getElementById("category").value;
	}
	
	</script>	
	




<?php
	
	include('footer.php');
	
?>