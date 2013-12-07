<?php ini_set("memory_limit", "200000000"); // for large images so that we do not get "Allowed memory exhausted"?>
<?php
// upload the file
if ((isset($_POST["submitted_form"]))) {
	
	// file needs to be jpg,gif,bmp,x-png and 4 MB max
	if (($_FILES["pic"]["type"] == "image/jpeg" || $_FILES["pic"]["type"] == "image/pjpeg" || $_FILES["pic"]["type"] == "image/gif" || $_FILES["pic"]["type"] == "image/x-png") && ($_FILES["pic"]["size"] < 4000000))
	{
		
  		$type = $_FILES["pic"]["type"];
		$name = $_FILES["pic"]["name"]; // File name + Extension
		$tmp_name = $_FILES["pic"]["tmp_name"]; // Temporary Path + .tmp extension
		
		// some settings
		$max_upload_width = 60;
		$max_upload_height = 60;

		
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
		
		$remote_file = "pics/". $name;
		imagejpeg($image_source,$remote_file,100);
		chmod($remote_file,0644);
	
	

		// get width and height of original image
		list($image_width, $image_height) = getimagesize($remote_file);
	
		if($image_width>$max_upload_width || $image_height >$max_upload_height){
			$proportions = $image_width/$image_height;
			
			if($image_width>$image_height){
				$new_width = $max_upload_width;
				$new_height = round($max_upload_width/$proportions);
			}		
			else{
				$new_height = $max_upload_height;
				$new_width = round($max_upload_height*$proportions);
			}		
			
			
			$new_image = imagecreatetruecolor($new_width , $new_height);
			$image_source = imagecreatefromjpeg($remote_file);
			
			imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
			imagejpeg($new_image,$remote_file,100);
			
			imagedestroy($new_image);
		}
		
		imagedestroy($image_source);
		
		
		//header("Location: submit.php?upload_message=image uploaded&upload_message_type=success&show_image=".$_FILES["pic"]["name"]);
		exit;
	}
	else{
		header("Location: submit.php?upload_message=make sure the file is jpg, gif or png and that is smaller than 4MB&upload_message_type=error");
		exit;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Upload with resize</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	font-size: 12px;
}

.upload_message_success {
	padding:4px;
	background-color:#009900;
	border:1px solid #006600;
	color:#FFFFFF;
	margin-top:10px;
	margin-bottom:10px;
}

.upload_message_error {
	padding:4px;
	background-color:#CE0000;
	border:1px solid #990000;
	color:#FFFFFF;
	margin-top:10px;
	margin-bottom:10px;
}

-->
</style></head>

<body>

<h1 style="margin-bottom: 0px">Submit an image</h1>


        <?php if(isset($_REQUEST['upload_message'])){?>
            <div class="upload_message_<?php echo $_REQUEST['upload_message_type'];?>">
            <?php echo htmlentities($_REQUEST['upload_message']);?>
            </div>
		<?php }?>


<form action="submit.php" method="post" enctype="multipart/form-data" name="image_upload_form" id="image_upload_form" style="margin-bottom:0px;">
<label>Image file, maximum 4MB. it can be jpg, gif,  png:</label><br />
          <input name="pic" type="file" id="pic" size="40" />
          <input type="submit" name="submit" value="Upload image" />     
     
     <br />
	<br />

      <p style="padding:5px; border:1px solid #EBEBEB; background-color:#FAFAFA;">
      <strong>Notes:</strong><br />
  The image will not be resized to this exact size; it will be scalled down so that neider width or height is larger than specified.<br />
  When uploading this script make sure you have a directory called &quot;image_files&quot; next to it and make that directory writable, permissions 777.<br />
  After you uploaded images and made tests on our server please <a href="delete_all_images.php">delete all uploaded images </a> :)<br />
  </p>
<input name="submitted_form" type="hidden" id="submitted_form" value="image_upload_form" />
<noscript><a href="http://www.thewebhelp.com/php/scripts/image-upload-with-resize/">PHP image upload script</a></noscript>
</form>




<?php if(isset($_REQUEST['show_image']) and $_REQUEST['show_image']!=''){?>
<p><img src="pics/<?php echo $_REQUEST['show_image'];?>" /></p>
<?php }?>



</body>
</html>


