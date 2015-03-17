<?php
	session_start();
	
	// Include database connection file
	include("../includes/sql.php");
	
?>
<html>
<head>
<meta charset="utf-8">
<title>Mr Tobacco II - Administration Panel</title>

<style>

body {
	background-color: rgb(247, 247, 247);
	margin-top: 30px;
	width: 100%;
	height: 100%;
	
	font-family: sans-serif;
}

#main-container {
	width: 1100px;
	margin: 0 auto;
	background-color:white;
	box-shadow: 0px 0px 10px #4c4c4c;
	min-height: 400px;
}

nav {
	width: 100%;
	height: 60px;
	line-height: 56px;
	background-image: url("../images/nav_bar_bg.png");
	text-align: center;
	
}

a:link, a:visited, a:active {
	font-family: 'Lato', sans-serif;
	font-weight: 700;
	font-size: 15px;
	color: rgb(130, 23, 27);
	
	text-shadow: 0px 0px 3px rgb(255,255,255);
	text-transform: uppercase;
	letter-spacing: .4px;
	text-decoration: none;

}

footer {
	background-color: rgba(161, 157, 131, 0.5);
	height:80px;
	padding: 20px;
	box-sizing: border-box;
	
	border-top-color: rgba(0,0,0,0.3);
	border-top-style: solid;
	border-top-width: 1px;
	
	/* FONT */
	color: rgba(0,0,0,0.7);
	font-size: 13px;
	letter-spacing: 1px;
	word-spacing: 3px;
}

#content {
	width: 100%;
	box-sizing: border-box;
	min-height: 400px;
	font-size: 19px;
	line-height: 40px;
	font-weight: 100;
}

input, button {
	width:470px;
	height: 40px;
	background-color: white;
	border: 1px #CCC solid;
	font-size: 14px;
	padding:10px;
}


select {
	width:470px;
	height: 40px;
	background-color: white;
	border: 1px #CCC solid;
	font-size: 14px;
	padding:10px;
}


textarea {
	width:470px; height: 200px; background-color: white; border: 1px #CCC solid; font-size: 13px; padding:10px;
}




li {
	display: inline-block;
	height:50px;
	padding-left: 15px;
	padding-right: 15px;
	list-style:none;
	text-align: center;
	
}

li:hover {
	background-color: rgba(255,255,255, 0.4);
}


#product_on_category_page {

	display: inline-block;
	width: 175px;
	
	margin: 20px;
	margin-top: 50px;
	margin-bottom: 50px;
	
	box-sizing: border-box;
	
	font-size: 15px;
	text-align: center;
	color: black;
	line-height: 20px;


}

#view_button {
	width: 100%;
	text-align: left;
	padding-top: 10px;
	padding-bottom: 10px;
	
	
	background-color: #e9e9e9;
	color: black;
	text-align: center;
	
}

#categoriesList {
	background:linear-gradient(to right, white, #DDD, white);
	text-align: center;
	height: 35px;
	margin-top: 20px;
	margin-bottom:20px;
	line-height:35px;
}


option {
	
	padding-bottom: 4px;
	padding-top: 4px;
}



/* NAVIGATION DROP DOWN BOX */

ul.cssMenu, ul.cssMenu ul
{
	list-style:none;
	margin:0; padding:0;
	position: relative;
}



ul.cssMenu ul 						
{ 
	display:none; /*initially menu item is hidden*/
    position: absolute; /*absolute positioning is important for menu to float*/
}



/* Hover effect for menu*/
ul.cssMenu li:hover > ul 			
{ 
	position: absolute;
	margin-top:12px;
	
	float: left;
	text-align: left;
	display:block;
	background-color: #c9c9c9;
	
}



</style>

</head>

<body>
<?php

	if (!isset($_SESSION['currently_logged_in_status'])) {
		echo '<meta http-equiv="refresh" content="0;url=http://mrtobacco2.com">';
		
	}

?>

<div id="main-container">
	<nav>
	
	 <a href="addProduct.php">ADD PRODUCT</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
	 <a href="viewProducts.php?id=1">EDIT/DELETE PRODUCT</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
	 <a href="addCategory.php">ADD CATEGORY</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
	 <a href="viewCategories.php">EDIT/DELETE CATEGORY</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
	 <a href="slideshow.php">SLIDESHOW</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
	 <a href="logout.php">LOGOUT</a>
	 
	</nav>
	
	<div id="content">


