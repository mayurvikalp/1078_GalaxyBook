<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gallery</title>

	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/lightbox.js"></script>
    <link rel="stylesheet" type="text/css" href="css/lightbox.css" media="screen" />
    <script type="text/javascript">
    $(function() { $('a.lightbox').lightBox(); });
    </script>
</head>
<body>
<?php include("header.php"); ?>
<center>
<?php
	if (!isset($_SESSION['username']))
		die("Please <a href='login.php'>Login</a> first.");
	
	if (isset($_REQUEST['p']))
		$username = $_REQUEST['p'];
	else
		$username = $_SESSION['username'];
	
	require("connect.php");
	$q=mysql_query("select * from upload where username='$username'");
	
	if (mysql_num_rows($q) == 0) {
		if (isset($_REQUEST['p'])) 
			echo "The user hasn't uploaded any photo.";
		else
			echo "You haven't uploaded any photo yet. <a href='upload.php'>Upload Now</a>";
	}
	else {
		echo getFullName($username) . "'s Gallery<br/><br />";
		echo "<table><tr>";
		$x=0;
		while ($row=mysql_fetch_array($q)) {	
			echo "<td><a class='lightbox' href='pic/" . $row['name'] . "'>";
			echo "<img src='image_resizer/image.php?width=150&height=150&image=". $WEBSITE_DOCROOT . "pic/" . $row['name'] . "' /></a></td>";	
			$x++;
			if ($x >= 5) {
				echo "</tr><tr>";
				$x = 0;
			}
		}
		echo "</tr></table>";
	}
?>
</center>
<?php include("footer.php"); ?>
</body>
</html>