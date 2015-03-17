<?php

	require('header.php');
	
	
	// Get category to view from page name
	$page_category = $_GET["id"];
	$delete_id     = $_GET["del_id"];





	// If a delete request has been called
	if ($delete_id != '') {
		
		// Delete product from database
	    $sql   = "DELETE FROM products where id='$delete_id'";
      
        if (!mysqli_query($cxn,$sql)) {
          die('SQL Error: ' . mysqli_error($cxn));
        }
        
	}
	


	echo '<ul class="cssMenu">';

	// List the categories stored in the database
	$query = "SELECT * FROM categories WHERE type = 0" or die ("can't connect");
	$result = mysqli_query($cxn,$query);
	
	echo '<div id="categoriesList">';
	
	while($row = mysqli_fetch_assoc($result)){
		$id   = $row['id'];
		$name = $row['name'];
		
		
			?>
	
		
			<li>
			
				<?php
					if ($page_category == $id) {
						echo '<a class="navLink" style="color:#0000CC;" href="?id='.$id.'">'.$name.'</a>';
					} else {
						echo '<a class="navLink" href="?id='.$id.'">'.$name.'</a>';
					}
				?>
				
				         
				
				<ul>
				
				<?php
					
					// List the categories stored in the database
					$query2 = "SELECT * FROM categories WHERE type = $id " or die ("can't connect");
					$result2 = mysqli_query($cxn,$query2);
					
					while($row2 = mysqli_fetch_assoc($result2)) {
						$id2   = $row2['id'];
						$name2 = $row2['name'];
						
						if ($page_category == $id2) {
							echo '<li><a href="?id=' . $id2 . '" style="color:#0000CC;" >' . $name2 . '</a></li><br>';
						} else {
							echo '<li><a href="?id=' . $id2 . '">' . $name2 . '</a></li><br>';
						}
						
					}
					
				?>
	
				</ul>
				
			</li>
		
	
		
		<?
	}
	

	echo '</div>';
	echo '</ul>';



	// List the products for a given category
	if (isset($page_category)) {
		
		// List the products from the selected category
		$query = "SELECT * FROM products WHERE category_id = $page_category" or die ("can't connect");
		$result = mysqli_query($cxn,$query);
		
		
		while($row = mysqli_fetch_assoc($result)){
			$id          = $row['id'];
			$title       = $row['title'];
			$description = $row['description'];
			$price       = $row['price'];
			$image       = $row['image'];
			
			
			?>
			
			
			<div id="product_on_category_page">
				<img src="../products/<?php echo $image; ?>" width="175px" height="175px">
				<br>
				<br>
				<b><?php echo $title; ?></b>
				<br>
				<br>
				<div id="view_button"><?php echo $price; ?></div>

				<div id="view_button" style="background-color:#FAFAFA;">
				<a href="editProduct.php?id=<?php echo $id; ?>" style="font-size:12px;">EDIT</a> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<a id="deleteButton" onclick="deleteConfirm(<?php echo $page_category; ?>, <?php echo $id; ?>, <?php echo "'" . $title . "'"; ?>)" style="font-size:12px;">DELETE</a>
				</div>
			</div>
			
			
			<?php
			
		}
	
	}
	
	?>
	
	
	<script>
	function deleteConfirm(cat_id, del_id, del_name) {
	    
	    if (confirm("Delete '" + del_name + "' ?") == true) {
	        window.location.href = "?id=" + cat_id + "&del_id=" + del_id;
	    }
	    
	}
	</script>
	
	
	<?php
	include('footer.php');
	
?>