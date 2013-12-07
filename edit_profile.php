<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Galaxybook</title>
<style>
input[type=text], select {
	padding: 10px;
	width: 300px;	
}
select {
	width: 325px;	
}
#edit_profile tr {
	line-height: 3em;
}
tr td:first-child:not(#submit_td) {
	text-align: right;	
	padding-right: 15px;
}
</style>
<script type="text/javascript">
	function checkValues() {
		if (document.getElementById("fn").value == "") {
			alert("Please enter the first name.");
			document.getElementById("fn").focus();
			return false;
		}
		if (document.getElementById("ln").value == "") {
			alert("Please enter the last name.");
			document.getElementById("ln").focus();
			return false;
		}
		if (document.getElementById("phn").value.length != 10) {
			alert("Please enter a 10 digits Mobile Number.");
			document.getElementById("phn").focus();
			return false;
		}
		if (document.getElementById("dob").value == "") {
			alert("Please enter the Date of Birth.");
			document.getElementById("dob").focus();
			return false;
		}
		if (document.getElementById("answer").value == "") {
			alert("Please enter the Security Answer.");
			document.getElementById("answer").focus();
			return false;
		}
	}
</script>	
</head>
<body>
<?php include("header.php"); ?>
<center>
<b>Profile</b>
<br>
<?php
	if (isLoggedIn()) {
	$un = $_SESSION['username'];
	if (isset($_REQUEST['su'])) {
		
		$fn = $_REQUEST['fn'];
		$ln = $_REQUEST['ln'];
	 	$phn = $_REQUEST['phn'];
		$gender = $_REQUEST['gender'];
		$dob = $_REQUEST['dob'];
		$question = $_REQUEST['question'];
		$answer = $_REQUEST['answer'];
		
		$query = "UPDATE users SET first_name = '$fn', last_name = '$ln', phone_number = '$phn', gender = '$gender', dob = '$dob', question = \"$question\", answer = \"$answer\" WHERE user_name = '$un' ";
		
		$result = mysql_query($query); 
		if ($result == 1) 
			echo "<br>Your profile has been updated. <br>";					
		else 
			echo "<br>There was an error in updating your profile. <br>";
	}
	
	$q = mysql_query("SELECT * FROM users WHERE user_name = '$un'");
	$q1 = mysql_fetch_array($q);

?>
<br>

<form method="post" onSubmit="return checkValues();">
<table id="edit_profile">
	<tr>
    	<td>First Name: </td>
        <td>
        	<input type="text" name="fn" id="fn" value="<?php echo $q1['first_name'];?>">
        </td>
	</tr>
	<tr>
    	<td>Last Name: </td>
        <td>
        	<input type="text" name="ln" id="ln" value="<?php echo $q1['last_name'];?>">
        </td>
	</tr>
	<tr>
    	<td>Gender: </td>
        <td>
        	<?php 
				if ($q1['gender'] == "male") { ?>
					Male: <input type="radio" name="gender" value="male" checked="checked">
					Female: <input type="radio" name="gender"  value="female">					
                    <?php
				}
				else { ?>
                    Male: <input type="radio" name="gender" value="male" >
                    Female: <input type="radio" name="gender" value="female" checked="checked">
                <?php
                }
			?>
        </td>
	</tr>
	<tr>
    	<td>Phone Number: </td>
        <td>
        	<input type="text" name="phn" id="phn" value="<?php echo $q1['phone_number'];?>">
        </td>
	</tr>
	<tr>
    	<td>Date Of Birth: </td>
        <td>
        	<input type="text" name="dob" id="dob" value="<?php echo $q1['dob'];?>">
        </td>
	</tr>
	<tr>
    	<td>Security Question: </td>
        <td>
        	<select name="question">
				<?php				
                    $ques1 = "What was your first School name?";
                    $ques2 = "What's your Rashee?";
                    $ques3 = "What's your birth place?";
                    $ques4 = "What's your mother's maiden name?";
                    
                    switch ($q1['question']) {
                        case $ques1: 
                            echo "<option>" . $ques1 . "</option>";
                            echo "<option>" . $ques2 . "</option>";
                            echo "<option>" . $ques3 . "</option>";
                            echo "<option>" . $ques4 . "</option>";
							break;
						case $ques2:
                            echo "<option>" . $ques2 . "</option>";
                            echo "<option>" . $ques1 . "</option>";
                            echo "<option>" . $ques3 . "</option>";
                            echo "<option>" . $ques4 . "</option>";
							break;
						case $ques3:
                            echo "<option>" . $ques3 . "</option>";
                            echo "<option>" . $ques1 . "</option>";
                            echo "<option>" . $ques2 . "</option>";
                            echo "<option>" . $ques4 . "</option>";
							break;
						case $ques4:
                            echo "<option>" . $ques4 . "</option>";
                            echo "<option>" . $ques1 . "</option>";
                            echo "<option>" . $ques2 . "</option>";
                            echo "<option>" . $ques3 . "</option>";
							break;
                    }
                    
                ?>
            </select>
        </td>
	</tr>
	<tr>
    	<td>Security Answer: </td>
        <td>
        	<input type="text" name="answer" id="answer" value="<?php echo $q1['answer'];?>">
        </td>
	</tr>
    
    <tr>
    	<td colspan="2" id="submit_button">
        	<center>
	            <input type="submit" value="Update" name="su" style="width: 120px; padding: 10px;">
            </center>
        </td>
    </tr>
</table>
</form>
<br /><br />
<?php
	if (isset($_REQUEST['uploadProfilePic'])) {
		if (isset($_FILES['pic'])) {			
			$username = $_SESSION['username'];	
			$aa=$_FILES['pic'];
			
			$name=$aa['name'];
			$size=$aa['size'];
			$type=$aa['type'];
			$tmp_name=$aa['tmp_name'];
			
			$tmp = substr($type, 0 , 5);
			if ( $tmp == "image") {
				
					$max_upload_width = 60;
					$max_upload_height = 50;
					
					// if uploaded image was JPG/JPEG
					if($type == "image/jpeg" || $type == "image/pjpeg"){	
						$image_source = imagecreatefromjpeg($tmp_name);
					}		
					// if uploaded image was GIF
					if($type == "image/gif"){	
						$image_source = imagecreatefromgif($tmp_name);
					}	
					// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
					// if uploaded image was BMP
					if($type == "image/bmp"){	
						$image_source = imagecreatefromwbmp($tmp_name);
					}			
					// if uploaded image was PNG
					if($type == "image/x-png"){
						$image_source = imagecreatefrompng($tmp_name);
					}
					
					$ext = substr($name, strpos($name, "."));
					$new_file_name = $_SESSION['username'] . $ext;
					
					$remote_file = "profile_pics/thumbnails/$new_file_name";
					imagejpeg($image_source,$remote_file,100);
					chmod($remote_file,0644);
			
					// get width and height of original image
					list($image_width, $image_height) = getimagesize($remote_file);
				
					if($image_width>$max_upload_width || $image_height >$max_upload_height){
						$proportions = $image_width/$image_height;
						
						if($image_width>$image_height) {
							$new_width = $max_upload_width;
							$new_height = round($max_upload_width/$proportions);
						}		
						else {
							$new_height = $max_upload_height;
							$new_width = round($max_upload_height*$proportions);
						}		
						
						$new_image = imagecreatetruecolor($new_width , $new_height);
						$image_source = imagecreatefromjpeg($remote_file);
						
						imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
						imagejpeg($new_image,$remote_file,100);
						
						imagedestroy($new_image);
					}
//					imagedestroy($image_source);
					move_uploaded_file($tmp_name, "profile_pics/$new_file_name");
					
					//header("location: " . getPageName());			
			}
			else echo "Please select a valid image file.";
		}
		else echo "Please select a photo to set as your profile pic.";
	}
?>

<form enctype="multipart/form-data" method="post" >
	<table cellspacing="15">
        <tr>
            <td>Profile Pic: </td>
            <td>
            	<input type="file" name="pic"/>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<center><input type="submit" name="uploadProfilePic" value="Upload Profile Pic"/></center>
            </td>
        </tr>
  	</table>
</form>
</center>
<?php 
	}
	else showLoginMessage();
	include("footer.php"); ?>
</body>
</html>