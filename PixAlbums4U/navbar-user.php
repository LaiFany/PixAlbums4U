<?php
	if(!isset($_SESSION)){
    session_start();
   }
	if(empty($_SESSION['username'])){
		$_SESSION['username'] = "Guest";
	}
?>

<nav class="navbar navbar-inverse navbar-fixed-top">
   <div class="container-fluid">
      <div class="navbar-header">
         <a class="navbar-brand" href="./">PixAlbums4U</a>
      </div>
      <div>
         <ul class="nav navbar-nav navbar-right">
            <li><a href="createalbumpage.php" class="button-primary">Create Album</a></li>
            <li><a href="uploadphotopage.php" class="button-primary">Upload Photo</a></li>
            <li><a href="viewphotogallerypage.php" class="button-primary">View Photo Gallery</a></li>
            <li><a href = "logout.php" class = "button-primary">Log Out</a></li>            
            <li class="active"><a href="usermainpage.php"><?php echo "{$_SESSION['username']}" ?></a></li>
         </ul>
      </div>
   </div>
</nav>
