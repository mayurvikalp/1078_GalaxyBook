<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
tr td:first-child {
	text-align: right;	
	padding-right: 15px;
}
</style>
</head>
<body>
<?php include("header.php"); ?>
<center>
<br>
<?php
	if (isLoggedIn()) { 
	$username = $_SESSION['username'];
	
	$q = mysql_query("SELECT * FROM users WHERE user_name = '$username'");
	if (isset($_REQUEST['p'])) 
		$q = mysql_query("SELECT * FROM users WHERE user_name = '" . $_REQUEST['p'] . "'");
	$q1 = mysql_fetch_array($q);
	
	if (mysql_num_rows($q) == 0) 
		echo "Username doesn't exist.";
	else {
		
?>
<div style="float: left; width: 80%;">
	<p align="center"><h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo getFullName($q1['user_name']); ?></h2></p>
</div>
<div style="float: right;">
	<?php
		if ($tempUsername == $_SESSION['username'])
			echo "<p align='right'><a href='edit_profile.php'>Edit Profile</a></p>";
	?>
</div>
<div class="clear_both"></div>
<ul id="profile_menu">
    <li><a href='gallery.php?p=<?php echo $q1['user_name']; ?>'>Gallery</a></li> |
    <li><a href='friends.php?p=<?php echo $q1['user_name']; ?>'>Friends</a></li> |
    <li><a href='friends.php?rf=<?php echo $q1['user_name']; ?>'>Unfriend</a></li>
</ul><br><br>
<table>
	<tr>
    	<td>Name: </td>
        <td>
        	<?php echo $q1['first_name'] . " " . $q1['last_name'];?>
        </td>
	</tr>
	<tr>
    	<td>Username: </td>
        <td>
        	<?php echo $q1['user_name'];?>
        </td>
	</tr>
	<tr>
    	<td>Gender: </td>
        <td>
        	<?php  echo $q1['gender']; ?>
        </td>
	</tr>
	<tr>
    	<td>Mobile: </td>
        <td>
        	<?php echo $q1['phone_number'];?>
        </td>
	</tr>
	<tr>
    	<td>Date Of Birth: </td>
        <td>
        	<?php echo $q1['dob'];?>
        </td>
	</tr>
    <?php if ($tempUsername == $_SESSION['username']) { ?>
    
	<tr>
    	<td>Security Question: </td>
        <td>
        	<?php echo $q1['question']; ?>
        </td>
	</tr>
	<tr>
    	<td>Security Answer: </td>
        <td>
			<?php echo $q1['answer'];?>
        </td>
	</tr>
    <?php } ?>
</table>
<?php }  
	} 
	else showLoginMessage(); ?>
</center>
<?php include("footer.php"); ?>
</body>
</html>