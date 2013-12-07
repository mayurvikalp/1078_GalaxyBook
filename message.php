<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Messages</title>
<script type="text/javascript">
	function check() {
		if(document.getElementById("receiver").value == "") {
			alert("Please enter the username to send the message to.");
			document.getElementById("receiver").focus();
			return false;
		}
		if(document.getElementById("subject").value == "") {
			document.getElementById("subject").value = "No Subject";
		}
		if(document.getElementById("message").value == "") {
			alert("Please enter the message to send.");
			document.getElementById("message").focus();
			return false;
		}
	}
</script>
</head>
<body>
<?php include("header.php"); ?>
<?php 
	if (isset($_SESSION['username'])) {
	if (isset($_REQUEST['d'])) {
		$id = $_REQUEST['d'];
		mysql_query("DELETE FROM messages WHERE id='$id'");	
	}
	$username = $_SESSION['username'];
	if (isset($_REQUEST['submit'])) {
		$sender = $_SESSION['username'];
		$receiver = $_REQUEST['receiver'];
		$subject = $_REQUEST['subject'];
		$message = $_REQUEST['message'];
		
		if ($sender == $receiver)
			die("You cant send message to yourself.");
			
		if (!usernameExists($receiver))
			echo "The entered username doesn't exist.";
		
		$query = "INSERT INTO messages (sender, receiver, subject, message) VALUES ('$sender','$receiver', \"$subject\", \"$message\")";
		$result = mysql_query($query);
		if ($result)
			echo "Message Sent Successfully!";
		else
			echo "Error: Message not sent.";
	}
	else {
?>
	<center>
    <form method="post">
	<table><tr>
        <td>To: </td><td><input type="text" name="receiver" id="receiver" style="width:252px;"/></td></tr>
        <tr><td>Subject: </td><td><input type="text" name="subject" id="subject" style="width:252px;" /></td></tr>
        <tr><td>Message: </td><td><textarea name="message" id="message" cols="31" rows="6"></textarea></td></tr>
        <tr><td></td>
        <td><br /><center><input style="width: 80px;"  type="submit" name="submit" value="Send" onclick="return check();"/></center>
        </td></tr>
    </table>
    </form>
    </center>
<?php
	}
?>
<br />
<br />
<center><b><u>Messages</u></b><br /><br />

<?php
	$query = "SELECT * FROM messages WHERE receiver='$username'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 0) {
		echo "No Messages";
	}
	else {
		?>
        <table>
	        <tr>        
            	<td><strong>Sender</strong></td>
                <td><strong>Subject</strong></td>
                <td></td>
            </tr>
        <?php
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
		?>
			<td>
                <a href="show_message.php?id1=<?php echo $row['sender']; ?>&id2=<?php echo $row['receiver']; ?>">
				<?php echo $row['sender'];?>
                </a>
			</td>
			<td>
            	<a href="show_message.php?id1=<?php echo $row['sender']; ?>&id2=<?php echo $row['receiver']; ?>">
                <?php echo $row['subject'];?></a>
			</td>
		<?php	
			echo "<td> &nbsp; &nbsp;    &nbsp; &nbsp; <a href='message.php?d=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete it?');\">Delete</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}
?>
</center>
<?php 
	}
	else showLoginMessage();
	include("footer.php"); ?>
</body>
</html>