<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
	function check() {
		if (document.getElementById("img").value == "") {
			document.getElementById("img").focus();
			alert("Please select an image.");
			return false;
		}
	}
</script>
</head>

<body>
<?php include("header.php"); ?>
<center>
Upload Photo<br />
<br />

<form enctype="multipart/form-data" method="post">
<input type="file" name="img" id="img" />
<input type="submit" name="su" value="Upload File" onclick="return check();"/>
<?php
if(isset($_REQUEST['su']))
{
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];	
		$aa=$_FILES['img'];
		$name=$aa['name'];
		$name_new = "";
		$temppath = "";
		do {
			$r=rand(1,9999999999999);
			$name_new = $r . $name;
			$temppath = "pic/" . $name_new;
		}
		while (file_exists($temppath));
		
		$size=$aa['size'];
		$type=$aa['type'];
		$path=$aa['tmp_name'];
		$ext = substr($type, 0, 5);
		
		if ($ext != "image") {
			echo "Please select an Image file.";	
		}
		else {
			$new_path = $temppath;
			
			move_uploaded_file($path,$new_path);
			mysql_query("insert into upload(name, size, type, username)values('$name_new', '$size', '$type', '$username')");
			
			echo "<br><br><img src='" . $new_path . "' width='600' height='450'/>";
		}
	}
	else loginRedirect();
}
?>
</form>
</center>
<?php include("footer.php"); ?>
</body>
</html>