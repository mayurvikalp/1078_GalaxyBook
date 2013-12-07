
<?php
	// User-defined Functions go here


	function getThumbnail($user) {
		return "profile_pics/thumbnails/" . getData($user, "profile_pic");
	}

	function getProfilePic($user) {
		return "profile_pics/" . getData($user, "profile_pic");
	}	
	
	function make_thumb($src,$dest,$desired_width)
	{
	
		/* read the source image */
		$source_image = imagecreatefromjpeg($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		
		/* find the "desired height" of this thumbnail, relative to the desired width  */
		$desired_height = floor($height*($desired_width/$width));
		
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
		
		/* copy source image at a resized size */
		imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
		
		/* create the physical thumbnail image to its destination */
		imagejpeg($virtual_image,$dest);
	}
	function usernameExists($user) {
		$result = mysql_query("SELECT * FROM users WHERE user_name = '$user'");
		if (mysql_num_rows($result) == 0)
			return false;
		else
			return true;
	}
	
	function getData($user, $type) {
		$result = mysql_query("SELECT * FROM users WHERE user_name = '$user'");
		if (mysql_num_rows($result) == 0)
			return false;
		else {
			$row = mysql_fetch_array($result);
			return $row[$type];
		}
	}
	function getFullName($user) {
		return getData($user, "first_name") . " " . getData($user, "last_name");	
	}
	
	function isLoggedIn() {
		if (isset($_SESSION['username']))
			return true;
		else 
			return false;
	}
	
	function showLoginMessage() {
		echo "<center>Please <a href='login.php'>Login</a> first.</center>";	
	}
	
	function loginRedirect() {
		header("location:login.php");	
	}
	
	function getPageName() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	

}
?>