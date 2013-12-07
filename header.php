<?php
	require("variables.php");
	require("connect.php");
	require("functions.php");
	session_start();
?><head>
<title><?php echo $WEBSITE_NAME; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<div id="bigwrapper">
<div id="wrapper">
    <div class="header">
    <div class="logo_container">
	    <div class="logo">Galaxybook</div>
	</div>
    <div class="right_header_container">
		<?php			
        if (isLoggedIn()) {
        ?>
        <div class="right_header"">
                    <div style="float: left ; clear: right;"> <?php
                    echo "<img src='profile_pics/thumbnails/" . getData($_SESSION['username'], "profile_pic") . "'/></div>&nbsp; ";
                    echo $USER_FULLNAME = getFullName($_SESSION['username']);
                    echo "";
                ?>
                <br>
                <div style="text-align:center;">
                    <a href='logout.php'>(Logout)</a>
                </div>
        </div>
       	
		<?php } else {?>
        <div class="login">    
                <a href="login.php">Login</a>&nbsp;|&nbsp;<a href="register.php">Register</a>
        </div>    
        <?php } ?>
	</div>
</div>
	<?php $tempUsername = ""; if (isLoggedIn()) {?>
    <div class="nav">
    	<div class="menu">
            <ul>
            	<?php
					if (isset($_REQUEST['p'])) $tempUsername = $_REQUEST['p'];
					else $tempUsername = $_SESSION['username']; 
				?>
                <li <?php if(getPageName() == "home.php") echo "id = \"active\""; ?>><a href="home.php">Home</a></li>
                <li <?php if(getPageName() == "profile.php" && $tempUsername == $_SESSION['username']) echo "id = \"active\""; ?>><a href="profile.php">Profile</a></li>
                <li <?php if(getPageName() == "friends.php") echo "id = \"active\""; ?>><a href="friends.php">Friends</a></li>
                <li <?php if(getPageName() == "message.php") echo "id = \"active\""; ?>><a href="message.php">Messages</a></li>
                <li <?php if(getPageName() == "upload.php") echo "id = \"active\""; ?>><a href="upload.php">Upload</a></li>
                <li <?php if(getPageName() == "gallery.php") echo "id = \"active\""; ?>><a href="gallery.php">Gallery</a></li>
            </ul>
        </div>
    </div>
    
	<?php 
        } // If statement of isLoggedIn() ends...
        else {
            
        }
    ?>
    <div class="con">