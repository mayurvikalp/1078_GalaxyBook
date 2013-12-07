<?php
	if (!isset($_REQUEST['submit_button']))
		header("location: register.php");
?>
<html>
<head>
<meta http-equiv=”refresh” content=”10;home.php”>
</head>
<body>
<?php
	include( "header.php");
	$fn = $_REQUEST['fn'];	
//	echo "First name: $fn <br>";
	
	$ln = $_REQUEST['ln'];
	//echo "Last name: $ln <br>";
	
	$un  = $_REQUEST['un'];
	//echo "User name: $un <br>";
	
	$phn = $_REQUEST['phn'];
	//echo "Phone Number: $phn <br>";
	
	$d = $_REQUEST['date'];
	$m = $_REQUEST['month'];
	$y = $_REQUEST['year'];
	$dob = $d . "/" . $m . "/" . $y;
	//echo "DOB: $dob <br>";
	
	$g = $_REQUEST['Gender'];
//	echo "Gender: $g <br>";
	
	$question = $_REQUEST['question'];
	//echo "Secret Question: $question <br>";
	
	$answer = $_REQUEST['answer'];
	//echo "Secret Answer: $answer <br>";

	$pw = $_REQUEST['pw'];

	$q=mysql_query("select * from users where user_name='$un'");
	$q1=mysql_fetch_array($q);
	if($q1['user_name'] != $un)
	{
		if ($g == "female") {
			copy("images/profile_pic_female.jpg", "profile_pics/" . $un . ".jpg");
			copy("images/profile_pic_female_thumb.jpg", "profile_pics/thumbnails/" . $un . ".jpg");
		}
		else {
			copy("images/profile_pic_male_thumb.jpg", "profile_pics/thumbnails/" . $un . ".jpg");
		}
			
		$query = "INSERT INTO users(first_name,last_name,user_name, password, phone_number, dob, gender, question, answer, profile_pic) VALUES('$fn','$ln', '$un', '$pw', '$phn', '$dob', '$g', \"$question\", '$answer',  \"$un.jpg\")";
		mysql_query($query);
	
		echo "<center>";
		echo "<br> Your account has been created successfully and you are now being redirected to your home page. ";
		echo "<br><br> <a href='home.php'>Homepage</a>";
		echo "</center>";
		$_SESSION['username'] = $un;		
	}
	else
	{
		header('location:register.php');
	}
	include ("footer.php");
?> 
</html>