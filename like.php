<?php
	require("variables.php");
	require("connect.php");
	require("functions.php");
	session_start();
	if (isset($_SESSION['username']) && isset($_REQUEST['id']) && isset($_REQUEST['type']) && isset($_REQUEST['value']) ) {
		$un = $_SESSION['username'];
		$id = $_REQUEST['id'];
		$value = $_REQUEST['value'];
		
		if ($_REQUEST['type'] == "status") {
			$query = "SELECT likes, liked_by FROM statuses WHERE id='$id'";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			
			$new_likes = 0;
			$new_liked_by = '';
			if ($value == "like") {

				$liked_by = explode(",", $row['liked_by']);
				$pos = array_search($un, $liked_by);
				if ($pos != "") // User already had liked the post.
					die("error");				
					
				$new_likes = $row['likes'] + 1;
				$new_liked_by = $row['liked_by'] . ",$un";
				
			}
			else if ($value == "dislike") {
				$new_likes = $row['likes'] - 1;
				if($new_likes < 0) $new_likes = 0;
				
				$liked_by = explode(",", $row['liked_by']);
				$pos = array_search($un, $liked_by);
				if ($pos == "") // User previously hadn't liked the post.
					die("error");				
				$new_liked_by_array = $liked_by;
				unset($new_liked_by_array[$pos]);
				var_dump($new_liked_by_array);				
				$new_liked_by = implode(",",$new_liked_by_array);
			}
			$query = "UPDATE statuses SET likes='$new_likes', liked_by='$new_liked_by' WHERE id='$id'";
			$result = mysql_query($query);
			if ($result) echo $value . "d";
			else echo "false";
		}
		else if ($_REQUEST['type'] == "image") {
			$query = "SELECT likes, liked_by FROM upload WHERE id='$id'";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			
			$new_likes = 0;
			$new_liked_by = '';
			if ($value == "like") {

				$liked_by = explode(",", $row['liked_by']);
				$pos = array_search($un, $liked_by);
				if ($pos != "") // User already had liked the post.
					die("error");				
					
				$new_likes = $row['likes'] + 1;
				$new_liked_by = $row['liked_by'] . ",$un";
				
			}
			else if ($value == "dislike") {
				$new_likes = $row['likes'] - 1;
				if($new_likes < 0) $new_likes = 0;
				
				$liked_by = explode(",", $row['liked_by']);
				$pos = array_search($un, $liked_by);
				if ($pos == "") // User previously hadn't liked the post.
					die("error");				
				$new_liked_by_array = $liked_by;
				unset($new_liked_by_array[$pos]);
				var_dump($new_liked_by_array);				
				$new_liked_by = implode(",",$new_liked_by_array);
			}
			$query = "UPDATE upload SET likes='$new_likes', liked_by='$new_liked_by' WHERE id='$id'";
			$result = mysql_query($query);
			if ($result) echo $value . "d";
			else echo "false";
		}
	}
	else echo "error";
?>