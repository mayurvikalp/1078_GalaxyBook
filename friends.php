<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Friend List</title>
<script type="text/javascript">
	function check() {
		if (document.getElementById("user").value == "" ) {
			alert("Enter a username to send friend request to.");
 			document.getElementById("user").focus();	
			return false;
		}
	}
</script>
</head>
<body>
<?php require("header.php"); ?>
<center>
	<?php		
		if (!isLoggedIn())
			showLoginMessage();
		else {	
		
		$username = $_SESSION['username'];
		if (isset($_REQUEST['ra'])) {
			$requestID = $_REQUEST['ra'];
			$query = "SELECT * FROM friends WHERE id='$requestID'";
			$result = mysql_query($query);
			if (mysql_num_rows($result) != 0) {
				$row = mysql_fetch_array($result);
				$query = "UPDATE friends SET status='1' WHERE id='$requestID'";
				mysql_query($query);
			}
			header("location: friends.php");
		}
		else if (isset($_REQUEST['rd'])) {
			$requestID = $_REQUEST['rd'];
			$query = "SELECT * FROM friends WHERE id='$requestID'";
			$result = mysql_query($query);
			if (mysql_num_rows($result) != 0) {
				$row = mysql_fetch_array($result);
				$query = "DELETE FROM friends WHERE id='$requestID'";
				mysql_query($query);
			}
			header("location: friends.php");
		}
		else if (isset($_REQUEST['rf'])) {
			$request = $_REQUEST['rf'];
			$query = "SELECT * FROM friends WHERE sender IN('$username','$request') AND receiver IN('$username','$request') AND status='1'";
			$result = mysql_query($query);
			if (mysql_num_rows($result) != 0) {
				$row = mysql_fetch_array($result);
				$requestID = $row['id'];
				$query = "DELETE FROM friends WHERE id='$requestID'";
				mysql_query($query);
				echo "Removed from friend list.<br>";
			}
			else header("location: friends.php");
		}
		else if (isset($_REQUEST['send_request'])) {
			
			$receiver = $_REQUEST['user'];
			$sender = $username;
			
			if ($sender == $receiver)
				echo "Can't send friend request to yourself.";
				
			else {
				if (usernameExists($receiver) == false) {
					echo "Username does not Exist.";
				}
				else {
					$query = "SELECT * FROM friends WHERE sender='$username' AND receiver='$receiver'";
					$result = mysql_query($query);
					if (mysql_num_rows($result) == 0) {
						
						$query = "SELECT * FROM friends WHERE sender='$receiver' AND receiver='$sender'";
						$result = mysql_query($query);
						if (mysql_num_rows($result) == 0) {
						
							$query="INSERT INTO friends (sender, receiver, sent_on) VALUES ('$username', '$receiver', NOW())";
							mysql_query($query);
							echo "Friend Request Sent!";
						}
						else {
							$row = mysql_fetch_array($result);
							if ($row['status'] == 1)
								echo "Already in the friend list.";
							else {
								$query="UPDATE friends SET status=1,accepted_on=NOW() WHERE sender='$receiver' AND receiver='$sender'"; 
								mysql_query($query);
								echo "Friend Request Accepted!";					
							}
						}
					}
					else {
						$row = mysql_fetch_array($result);
						if ($row['status'] == 1)
							echo "Already in the friend list.";
						else
							echo "Friend Request Already Sent.";
					}
				}
			}
		}
		if (!isset($_REQUEST['p'])) { 
		?>
            <form method="post">
                Username: <input type="text" name="user" id="user" />
                <input type="submit" name="send_request" value="Send Request" onclick="return check();" />
            </form>
    	<?php
		}
		if (isset($_REQUEST['p'])) {
			if (usernameExists($_REQUEST['p']))
				$username = $_REQUEST['p'];
			else 
				die("Username doesn't exist.");
		}
		?>
        <div id="friends">
		<table><tr><td>
		<?php
		if ($username != $_SESSION['username'])
			echo "<h2><center>" . getFullName($username) . "</center></h2>";
		else {
			$query = "SELECT * FROM friends WHERE receiver='$username' AND status='0'";
			$result = mysql_query($query);
			if (mysql_num_rows($result) != 0) {
				echo "<br><br><center><b>Pending Requests</b></center><br>";
				echo "<center><table>";
				while ($row = mysql_fetch_array($result)) {
					echo "<tr><td><div style='width: 300px;'>";
					echo "<a href='profile.php?p=" . $row['sender'] . "'>";
					echo "<div style='float: left; clear: both;'><img src='" . getThumbnail($row['sender']) . "'/></div>";
					echo "&nbsp;" . getFullName($row['sender']) . "</a></div></td>";
					echo "<td style='float: right;'>";
					echo "<a href='friends.php?ra=".$row['id']."'><img src='images/tick.jpg' title='Approve' /></a>";
					echo "&nbsp;<a href='friends.php?rd=".$row['id']."'><img src='images/cross.jpg' title='Decline' /></a></td>";
					echo "</tr>";
				}
				echo "</center></table>";
			}
		}
		echo "<div class='clear_both'></div>";
		echo "<br><br><center><b>Friend List</b></center><br>";
		$query = "SELECT * FROM friends WHERE sender = '$username' OR receiver = '$username'";
		$result = mysql_query($query);
		
		$no = 0;
		echo "<table><tr>";
		while ($row = mysql_fetch_array($result)) {
			if ($row['status'] == 1) {
				$no ++;
				if ($no > 4)
					echo "</tr><tr>";
				if ($row['sender'] == $username) {
					echo "<td><a href='profile.php?p=".$row['receiver']."'>";
					echo "<div style='float: left; clear: right;'><img src='" . getThumbnail($row['receiver']) . "'></div> &nbsp;";
					echo getFullName($row['receiver']) . "</a>&nbsp; &nbsp; &nbsp;</td>";
				}
				else {
					echo "<td><a href='profile.php?p=".$row['sender']."'>";
					echo "<div style='float: left; clear: right;'><img src='" . getThumbnail($row['sender']) . "'></div> &nbsp;";
					echo getFullName($row['sender']) . "</a></td>";
				}
			}
		}
		echo "</tr></table>";
		?>
		</td>    
		</tr></table>
        </div>
</center>
<?php }
	include("footer.php"); ?>
</body>
</html>