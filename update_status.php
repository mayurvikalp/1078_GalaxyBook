<?php
session_start();
require('connect.php');
if (isset($_SESSION['username'])) {
	echo $query = "INSERT INTO statuses (user,status) VALUES ('" . $_SESSION['username'] ."',\"" . $_REQUEST['status'] . "\")";
	$result = mysql_query($query);
	
	if (!$result) echo "error";
	else echo "Your status has been updated.";
}
?>