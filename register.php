<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
input[type=text], input[type=password], #question {
	width: 300px;
	padding: 10px;
}
#question {
	width: 252px;	
}
#register_table tr {
	line-height: 2.5em;
}
tr td:first-child:not(#submit_td) {
	text-align: right;	
	padding-right: 15px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register - Galaxybook</title>
<script type="text/javascript">
function abc()
{
	if(document.getElementById("fn").value=="")
	{
		document.getElementById("fn").focus();
		alert("Please enter the first name");
		return false;
	}
	if(document.getElementById("ln").value=="")
	{
		document.getElementById("ln").focus();
		alert("Please enter the last name");
		return false;
	}
	if(document.getElementById("un").value=="")
	{
		document.getElementById("un").focus();
		alert("Please enter the user name");
		return false;
	}
	if(document.getElementById("pw").value.length < 6)
	{
		document.getElementById("pw").focus();
		alert("Please  a password of atleast 6 characters");
		return false;
	}
	
	if (document.getElementById("phn").value == "" ||
								isNaN(document.getElementById("phn").value) || 
								document.getElementById("phn").value.length > 10 || 
								document.getElementById("phn").value.length < 10) {
		document.getElementById("phn").focus();
		alert("Please enter a valid 10 digit Phone number");
		return false;
	}
	
	if (!document.getElementById("g_male").checked && !document.getElementById("g_female").checked) {
		alert("Please select your gender.");
		return false;
	}
	
	if(document.getElementById("dt").value=="Date")
	{
		document.getElementById("dt").focus();
		alert("Please enter the date");
		return false;
	}
	if(document.getElementById("mh").value=="Month")
	{
		document.getElementById("mh").focus();
		alert("Please enter the month");
		return false;
	}
	if(document.getElementById("yr").value=="Year")
	{
		document.getElementById("yr").focus();
		alert("Please enter the year");
		return false;
	}
	if(document.getElementById("sa").value=="")
	{
		document.getElementById("sa").focus();
		alert("Please enter the security answer");
		return false;
	}
	if(document.getElementById("pw").value != document.getElementById("cpw").value)
	{
		document.getElementById("cpw").focus();
		alert("Passwords don't match");
		return false;		
	}
}

</script>
</head>
<body>
<?php require("header.php");?>
<center><h2>Register</h2></center>
<form action="register_submit.php" method="post" onsubmit="return abc();">
<table align="center" id="register_table">
	<tr> 
        <td>First Name: </td> 
    	<td><input type="text" id="fn"  name="fn"/></td>
        </tr>
        <tr>
        <td>Last Name: </td>
        <td><input type="text"  id="ln" name="ln"/></td>
    </tr>
	<tr> 
    	<td>Username: </td>
        <td><input type="text" id="un" name="un"/></td>
    </tr>
	<tr> 
    	<td>Password: </td>
        <td><input type="password" id="pw" name="pw"/></td>
    </tr>
	<tr> 
    	<td>Confirm Password: </td>
        <td><input type="password" id="cpw" name="cpw"/></td>
    </tr>
	<tr> 
    	<td>Phone Number:</td>
        <td><input type="text" id="phn" name="phn"/></td>
    </tr>
	<tr> 
    	<td>Date of Birth: </td>
        <td>
        	<select id="dt" name="date" style="padding: 5px; width: 70px;">
            	<option>Date</option>
               <?php
			   for($i=1;$i<=31;$i++)
			   {
				   echo "<option> $i </option>"; 
			   }
			   ?>
			</select>
            <select id="mh" name="month" style="margin-left: 0px; padding: 5px; width: 105px;">
            	<option>Month</option>
                <option>January</option>
                <option>February</option>
                <option>March</option>
                <option>April</option>
                <option>May</option>
                <option>June</option>
                <option>July</option>
                <option>August</option>
                <option>September</option>
                <option>October</option>
                <option>November</option>
                <option>December</option>
			</select>
            <select id="yr" name="year" style="margin-left: 0px; padding: 5px; width: 70px">
            	<option>Year</option>
               <?php
			   for($i=2012;$i>=1900;$i--)
			   {
               		echo "<option> $i </option>";
               }
			   ?>
			</select>      
        </td>
    </tr>
    <tr>
    	<td>Gender: </td>
        <td><colorMe> Male: </colorMe><input type="radio" value="male" name="Gender" id="g_male" checked="checked"/>
        	<colorMe> Female: </colorMe><input type="radio" value="female" name="Gender" id="g_female"/>
        </td>
    </tr>
    <tr>
    	<td>Security Question: </td>
        <td>
        	<select name="question" id="question">
            	<option>What was your first School name?</option>
                <option>What's your Rashee?</option>
                <option>What's your birth place?</option>
                <option>What's your mother's maiden name?</option>
			</select>
		</td>
	</tr>
    <tr>
    	<td>Secret Answer: </td>
        <td><input type="text" id="sa" name="answer"/></td>
	</tr>  
    <tr>
    	<td  colspan="2" align="center" id="submit_td">
        	<br />
            <input type="submit" value="Submit" name="submit_button" class="paddedButton" />
        </td>
    </tr>    
</table>
</form>
<?php
if(isset($_REQUEST['v']))
{
	?>
    <script type="text/javascript">
    	alert("Username Already Exists!");
    </script>
    <?php
}
?>
<?php include ("footer.php"); ?>
</body>
</html>