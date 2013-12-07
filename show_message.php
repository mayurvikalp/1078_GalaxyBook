<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Messages</title>
</head>

<body>
<?php
	include("header.php");
	require("connect.php");
	if(isset($_REQUEST['id2']) && isset($_REQUEST['id1']) ) {
		$id2 = $_REQUEST['id2'];
		$id1 = $_REQUEST['id1'];
		$query = "SELECT * FROM messages WHERE sender in('$id1','$id2') AND receiver in('$id1','$id2') ORDER BY id DESC";
		$result1 = mysql_query($query);
		
		echo "<table border='0'>";
		if (mysql_num_rows($result1) != 0) {
			while ($row = mysql_fetch_array($result1)) {
				echo "<tr><td><b>" . $row['sender'] . ": </b></td>";
				echo "<td><b>" . $row['subject'] . "</b></td></tr>";
				echo "<tr><td></td><td>" . $row['message'] . "</td></tr>";
				echo "<tr></tr>";
			}
		}
		
		/*$query = "SELECT * FROM messages WHERE sender='$id2' AND receiver = '$id1'";
		$result2 = mysql_query($query);
		if (mysql_num_rows($result2) != 0) {
			
			while ($row = mysql_fetch_array($result2)) {
				echo "<tr><td><b>" . $row['sender'] . ": </b></td>";
				echo "<td><b>" . $row['subject'] . "</b></td></tr>";
				echo "<tr><td></td><td>" . $row['message'] . "</td></tr>";
				echo "<tr></tr>";
			}
		}*/
		
		echo "</table>";
		
		if (mysql_num_rows($result1) == 0 && mysql_num_rows($result2) == 0) 
			echo "No Conversation";
	}
?>
<?php include("footer.php"); ?>
</body>
</html>