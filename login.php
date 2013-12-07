<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>
<script type="text/javascript">
	function check() {
		if (document.getElementById("n").value=="" || document.getElementById("p").value=="")  {
			alert("Please enter both the username and the password.");
			return false;
		}
	}
</script>

<body>
<?php include ("header.php"); 
	if (isLoggedIn())
		header("location: home.php");
	else {
?>

<form id="login_form" method="post" >
<center><br />
<h3>Login</h3>
<br />

<table>
<tr>
<td><gray>Username</gray></td>
<td><input type="text" name="n" id="n"  /></td>
</tr>
<tr>
<td><gray>Password</gray></td>
<td><input type="password"  name="p" id="p"/></td>
</tr>
<tr><td></td><td>
<textSmall><input type="checkbox" name="keepLoggedIn" /> Keep me logged in</textSmall>
</td>
</tr>
<tr></tr>
<tr>
<td></td>
<td><input type="submit" name="su" value="Submit" onclick="return check();"/></td>
</tr>
<tr><td></td>
<td><textSmall><a href="forgot.php">Forgot Password?</a></textSmall></td></tr>
<tr><td></td>
<td><textSmall>Not registered yet? <a href="register.php">Sign Up Now</a></textSmall></td></tr>
</center>
</table>

<?php
if(isset($_REQUEST['su']))
{
	$un=$_REQUEST['n'];
	$ps=$_REQUEST['p'];
	require("connect.php");
	$q=mysql_query("select * from users where user_name='$un'");
	$q1=mysql_fetch_array($q);
	if($q1['user_name'] == $un && $q1['password'] == $ps) {
		// Correct Username and Password
		session_start();
		$_SESSION['username'] = $un;
		
		header('location:home.php');
	}
	else {
		// Wrong Username or Password
		?>
		
		<script type="text/javascript">
			alert("Invalid Username/Password.");         
        </script>
        
        <?php
	}
}

?>
</form>
<?php }
include ("footer.php"); ?>
</body>
</html>