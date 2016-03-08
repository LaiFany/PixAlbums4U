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
            <li><a href="./">Home</a></li>
            <li class="active"><a href="usermainpage.php"><?php echo "{$_SESSION['username']}" ?></a></li>
         </ul>
      </div>
   </div>
</nav>
