<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<link rel="stylesheet" type="text/css" href="css/lightbox.css" media="screen" />
<script type="text/javascript">
$(function() { $('a.lightbox').lightBox({keyToPrev: 123123}); });

	function checkForEnter(e) {
		var evt = e ? e:event;
		var KEY_ENTER = 13;
		if (evt.keyCode == KEY_ENTER && !evt.shiftKey)
			updateStatus();
	}
	function updateStatus() {
		var text = document.getElementById('status').value;
		if (text == null || text == "") {
			// Do nothing.
		}
		else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET", "update_status.php?status=" + document.getElementById('status').value);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
					var response = xmlhttp.responseText;
					if (response == "error") {
						document.getElementById('messages').innerHTML = "ERROR";
					}
					else {
						document.getElementById('status').value = "";	
					}
				}
			}
			xmlhttp.send();
		}		
	}
	function likePost(obj, id, type, value) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", "like.php?id=" + id + "&type=" + type + "&value=" + value);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
				var response = xmlhttp.responseText;
				if (response == "liked") {
					obj.src = "images/heart-red.png";
					obj.setAttribute("onmouseover", "this.src='images/heart-gray.png';");
					obj.setAttribute("onmouseout", "this.src='images/heart-red.png';");
					obj.setAttribute("title", "Unlike");
					obj.title = "Unlikeee";
				}
				else if(response == "disliked") {
					
				}
				else {
					// Show Error Dialog	
				}
			}
		}
		xmlhttp.send();
	}
</script>
</head>
<body>
<?php include("header.php"); ?>
<?php
	if(isLoggedIn()) { ?>

        <div style="float: left; width: 20%;">
            <center>
            <a href="edit_profile.php" class="a_clean">
            <img src="image_resizer/image.php?width=150&amp;height=700&amp;image=<?php echo $WEBSITE_DOCROOT; ?>profile_pics/<?php echo getData($_SESSION['username'], "profile_pic"); ?>"/>
            </a>
            <br />
            <a href='profile.php' style='font-face: Lucida Sans Unicode, Lucida Grande, sans-serif; font-size: 13px;'><?php echo getData($_SESSION['username'],"first_name")." ".getData($_SESSION['username'], "last_name"); ?></a>
            </center>
        </div>
        <div style='float: left; width: 80%;'>
                <fieldset>
                    <legend style="font-size: 12px;">Update Status</legend>
                    <form id="form_update_status">
                        <textarea name="status" id="status" style="resize: none; padding: 0px; margin: 0px; height: 50px; width: 84%; float: left;" onkeydown="checkForEnter();"></textarea>
                        <input type="button" value="Update Status" style="padding: 0px; margin: 0px; height: 50px; width: 15%; float: right;" onclick="return updateStatus();"/>
                        <div style="clear: both; margin-left: -5px;">
                            <textSmall>Press <strong>Shift+Enter</strong> to start a new line and <strong>Enter</strong> to update status.</textSmall>
                        </div>
                    </form>
                </fieldset>
                <br />
                
                <fieldset>
                    <legend style="font-size: 12px;">News Feed</legend>
                    <?php
                        $un = $_SESSION['username'];
                        $query = "SELECT * FROM friends WHERE sender='$un' OR receiver='$un' ";
                        $result = mysql_query($query);
                        $allfriends = "";
                        while ($row = mysql_fetch_array($result)) {
                            if ($row['sender'] == $un) $allfriends[] = $row['receiver'];
                            if ($row['receiver'] == $un) $allfriends[] = $row['sender'];
                        }
                        
                        $allfriends_IN = "'" . $_SESSION['username'] . "',";
						if ($allfriends != "") { // Has atleast one friend?
							foreach($allfriends as $frnd) {
								$allfriends_IN .= "'$frnd',";	
							}
							$allfriends_IN = substr($allfriends_IN, 0, strlen($allfriends_IN) - 1);
							
							echo "<table style='border-collapse:separate; border-spacing:.7em;'>";
							$query = "(SELECT statuses.id, statuses.user, statuses.status AS content, statuses.type, statuses.likes, statuses.liked_by, statuses.time AS ts FROM statuses WHERE user IN($allfriends_IN))
	UNION
	(SELECT upload.id, upload.username, upload.name, upload.type, upload.likes, upload.liked_by, upload.time FROM upload WHERE username IN($allfriends_IN))
	ORDER BY ts DESC";
							$result = mysql_query($query);
							$counter = 0;
							while ($row = mysql_fetch_array($result)) {
								echo "<tr style='vertical-align:top;'><td><img src='profile_pics/thumbnails/" . getData($row['user'], "profile_pic") . "'/></td>";
								echo "<td style='width:90%;'><strong><a style='font: Lucida Sans Unicode, Lucida Grande, sans-serif; ' href='profile.php?p=" . $row['user'] . "'>" . getData($row['user'], "first_name") . " " . getData($row['user'], "last_name") . "</a></strong><br>";
								
								if ($row['type'] == "status") 
									echo "<span style='color: #333; font-size: 13px;'>" .$row['content'] . "</span><br><hr>";
								else if (substr($row['type'],0,5) == "image") {
									echo "<center><br>";
									echo "<a class='lightbox' href='pic/" . $row['content'] . "'>";
									echo "<img src='image_resizer/image.php?width=450&height=450&image=" . $WEBSITE_DOCROOT . "pic/" . $row['content'] . "'/>";
									echo "</a></center><hr>";
								}
								if(substr($row['type'],0,5) == "image")
									$row['type'] = "image";
									
								$liked_by = explode(",", $row['liked_by']);
								if (in_array($_SESSION['username'], $liked_by))	echo "<img 
									src='images/heart-red.png' 
									onmouseover=\"this.src='images/heart-gray.png';\" 
									onmouseout=\"this.src='images/heart-red.png'\" 
									onclick=\"likePost(this, '".$row['id']."', '".$row['type']."', 'dislike');\" 
									style='cursor: pointer;' 
									title='Unlike'/> 
									<textSmall style='vertical-align: top;'>You like this.</textSmall>";
								else echo "<img 
									src='images/heart-gray.png' 
									onmouseover=\"this.src='images/heart-red.png';\" 
									onmouseout=\"this.src='images/heart-gray.png'\" 
									onclick=\"likePost(this, '".$row['id']."', '".$row['type']."', 'like');\" 
									style='cursor: pointer;'  
									title='Like'/>";
								
								$like;
								if ($row['likes'] == 1) $like = "like";
								else $like = "likes";
								echo "<textSmall style='vertical-align: top;'>" . $row['likes'] . " $like</textSmall>";
								echo "</td></tr>";
								
								$counter++;
								if ($counter > 10) break;
							}
							echo "</table>";
						} // End of if($allfriends != "")
						else {
							echo "<center><textSmall>No Recent posts available</textSmall></center>";	
						}
                    ?>
                </fieldset>
                <br /><br />
                
                
                <div id="messages">
                    <fieldset style="border: 1px solid #CCC">
                        <legend style="font-size:12px;">Messages</legend>
                        <table>
                        <?php
                            $query = "SELECT * FROM messages WHERE sender='" . $_SESSION['username'] . "' OR receiver='" . $_SESSION['username'] . "' ORDER BY id DESC LIMIT 5";
                            $result = mysql_query($query);
                            if (mysql_num_rows($result) == 0)
                                echo "<center><textSmall>No messages</textSmall></center>";
                            else {
                                while($row = mysql_fetch_array($result)) {
                                    $name = "";
                                    if ($row['sender'] == $_SESSION['username']) $name = "Me";
                                    else $name = getData($row['sender'], "first_name");
                                    echo "<font size='2px'>";
                                    echo "<tr><td><b>$name:</b></td><td>" . $row['message'] . "</td></tr>";
                                    echo "</font>";
                                }
                            }
                        ?>
                        </table>
                    </fieldset>
                </div>
                <br />
                <div id="recent_photos">
                    <fieldset style="border: 1px solid #CCC">
                        <legend style="font-size:12px;">Recent Photos</legend>
                        <?php
                            $query = "SELECT * FROM upload WHERE username='" . $_SESSION['username'] . "' ORDER BY id DESC LIMIT 5";
                            $result = mysql_query($query);
                            if (mysql_num_rows($result) == 0)
                                echo "<center><textSmall>You haven't uploaded any photo to your gallery yet. <a href='upload.php'>Upload Now</a></textSmall></center>";
                            else {
                                while($row = mysql_fetch_array($result)) {
                                    echo "<a href='pic/".$row['name'] . "'><img src='image_resizer/image.php?width=120&height=80&image=" . $WEBSITE_DOCROOT . "pic/".$row['name'] . "'/></a>&nbsp;";
                                }
                            }
                        ?>
                    </fieldset>
                </div>
        </div>
        <div class="clear_both"></div>
<?php 
	} 
	else {?>
    	<font face="Tahoma, Geneva, sans-serif" size="3">
    	<center>
        <br>
        <img src="images/social_networking.jpg" />
        <br>Enjoy the power of social networking.<br><a href='register.php'>Register</a> or <a href='login.php'>Login</a> now!</center>
        </font>
        <?php
	}
?>
<?php include ("footer.php"); ?>
</body>
</html>