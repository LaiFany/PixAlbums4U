<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'common.php'?>
		<title>View Photos - PixAlbums4U</title>
      <style>
         body {
            padding-top: 60px;
            background-size: cover;
			transition: background 2s ease-out;
         }
         @media (max-width: 767px) {
            body {
               padding-top: 155px; /* guest */
            }
         }
      </style>
      
      <script>
         var isGuest = true;
         
         function changePaddingTop(){
            var width = window.innerWidth;
            
            if(width <= 767){
               if(isGuest){
                  document.body.style.paddingTop = '135px';
               } else{
                  document.body.style.paddingTop = '255px';
               }
            } else{
               document.body.style.paddingTop = '60px';
            }
         }
      </script>
      <script src="javascript/displayimg.js"></script>
      <script src="javascript/kbdViewPhotos.js"></script>
	</head>
	<body onresize="changePaddingTop()" onkeydown="kbdViewPhotos(arguments[0])">
		<?php include 'connect.php' ?>
		<?php include 'choose-navbar.php'; ?>
      <script>changePaddingTop();</script>
			
			<div class = "photoslider">
			<?php
				//if next button is clicked, the photoslider class retrives information loads the next picture sorted by ID, and the photopageinfo class displays the retrieved information.
				if(isset($_GET['previous_id'])){
					$previous_id = $_GET['previous_id'];
					$query = mysqli_query($mysqli, "SELECT * FROM image WHERE id > '$previous_id' ORDER BY id LIMIT 1");
					if(mysqli_num_rows($query) != 0){
						while($run = mysqli_fetch_assoc($query)){
							$id = $run['id'];
							$url = $run['url'];
							$name = $run['name'];
							$member_id = $run['member_id'];
							$album_id = $run['album_id'];
							$description = $run['description'];
							$date = $run['date'];
							?>
							<div id = "image">
							<img src = "uploads/<?php echo $url; ?>" width = "700" height = "500">
							<?php
						}
						?>
						<div class = "prev">
							<a href = "photopagebyid.php?next_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-left"></span></a>
						</div>
						<div class = "next">
							<a href = "photopagebyid.php?previous_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
						</div>
			</div>
			<div class = "photopageinfo">
				<?php
					//find album name from album_id
					$query1 = mysqli_query($mysqli, "SELECT name FROM album WHERE id = '$album_id'");
					$run = mysqli_fetch_assoc($query1);
					$album_name = $run['name'];
					//find member username from member_id
					$query1 = mysqli_query($mysqli, "SELECT username FROM members WHERE id = '$member_id'");
					$run = mysqli_fetch_assoc($query1);
					$username = $run['username'];
				?>
				<div class = "photopage-photoname">
					<h1><?php echo $name; ?></h1>
				</div>
				<div class = "photopage-photodesc">
					"<?php echo $description; ?>"
				</div>
				<div class = "photopage-photodate">
					<?php
						if($date!="0000-00-00"){
							?>
							Date : <?php echo $date; ?>
							<?php
						}
						else{
							?>
							Date : Not Avaliable
							<?php
						}
					?>
				</div>
				<div class = "photopage-albumname">
					<span> Album : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewalbumpage.php"> ' . $album_name . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
					?>			
				</div>
				<div class = "photopage-username">
					<span> Author : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewphotogallerypage.php"> ' . $username . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
					?>												
				</div>
			</div>
			<div class = "photoslider">
			<?php
					}
					//if reached the end of the slide, the photoslider class retrives information,  and loads the same picture, but only displays the previous button, and the photopageinfo class displays the retrieved information.
					else{
						$query = mysqli_query($mysqli, "SELECT * FROM image WHERE id = '$previous_id' ORDER BY id LIMIT 1");
						if(mysqli_num_rows($query) != 0){
							while($run = mysqli_fetch_assoc($query)){
								$id = $run['id'];
								$url = $run['url'];
								$name = $run['name'];
								$member_id = $run['member_id'];
								$album_id = $run['album_id'];
								$description = $run['description'];
								$date = $run['date'];
						?>
							<div id = "image">
							<img src = "uploads/<?php echo $url; ?>" width = "700" height = "500">
						<?php
							}
						?>
						<div class = "prev">
							<a href = "photopagebyid.php?next_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-left"></span></a>
						</div>
						</div>
			</div>
			<div class = "photopageinfo">
				<?php
					//find album name from album_id
					$query1 = mysqli_query($mysqli, "SELECT name FROM album WHERE id = '$album_id'");
					$run = mysqli_fetch_assoc($query1);
					$album_name = $run['name'];
					//find member username from member_id
					$query1 = mysqli_query($mysqli, "SELECT username FROM members WHERE id = '$member_id'");
					$run = mysqli_fetch_assoc($query1);
					$username = $run['username'];
				?>
				<div class = "photopage-photoname">
					<h1><?php echo $name; ?></h1>
				</div>
				<div class = "photopage-photodesc">
					"<?php echo $description; ?>"
				</div>
				<div class = "photopage-photodate">
					<?php
						if($date!="0000-00-00"){
							?>
							Date : <?php echo $date; ?>
							<?php
						}
						else{
							?>
							Date : Not Avaliable
							<?php
						}
					?>
				</div>
				<div class = "photopage-albumname">
					<span> Album : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewalbumpage.php"> ' . $album_name . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
					?>			
				</div>
				<div class = "photopage-username">
					<span> Author : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewphotogallerypage.php"> ' . $username . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
					?>												
				</div>
			</div>		
			<div class = "photoslider">
						<?php
						}
					}
				}
				//if previous button is clicked, the photoslider class retrives information loads the previous picture sorted by ID, and the photopageinfo class displays the retrieved information.
				else if(isset($_GET['next_id'])){
					$next_id = $_GET['next_id'];
					$query = mysqli_query($mysqli, "SELECT * FROM image WHERE id < '$next_id' ORDER BY id DESC LIMIT 1");
					if(mysqli_num_rows($query) != 0){
						while($run = mysqli_fetch_assoc($query)){
							$id = $run['id'];
							$url = $run['url'];
							$name = $run['name'];
							$member_id = $run['member_id'];
							$album_id = $run['album_id'];
							$description = $run['description'];
							$date = $run['date'];
							?>
							<div id = "image">
							<img src = "uploads/<?php echo $url; ?>" width = "700" height = "500">
							<?php
						}
						?>
						<div class = "prev">
							<a href = "photopagebyid.php?next_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-left"></span></a>
						</div>
						<div class = "next">
							<a href = "photopagebyid.php?previous_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
						</div>
			</div>
			<div class = "photopageinfo">
				<?php
					//find album name from album_id
					$query1 = mysqli_query($mysqli, "SELECT name FROM album WHERE id = '$album_id'");
					$run = mysqli_fetch_assoc($query1);
					$album_name = $run['name'];
					//find member username from member_id
					$query1 = mysqli_query($mysqli, "SELECT username FROM members WHERE id = '$member_id'");
					$run = mysqli_fetch_assoc($query1);
					$username = $run['username'];
				?>
				<div class = "photopage-photoname">
					<h1><?php echo $name; ?></h1>
				</div>
				<div class = "photopage-photodesc">
					"<?php echo $description; ?>"
				</div>
				<div class = "photopage-photodate">
					<?php
						if($date!="0000-00-00"){
							?>
							Date : <?php echo $date; ?>
							<?php
						}
						else{
							?>
							Date : Not Avaliable
							<?php
						}
					?>
				</div>
				<div class = "photopage-albumname">
					<span> Album : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewalbumpage.php"> ' . $album_name . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
					?>			
				</div>
				<div class = "photopage-username">
					<span> Author : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewphotogallerypage.php"> ' . $username . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
					?>												
				</div>
			</div>
			<div class = "photoslider">
						<?php
					}
					//if reached the beginning of the slide, the photoslider class retrives information,  and loads the same picture, but only displays the next button, and the photopageinfo class displays the retrieved information.
					else{
						$query = mysqli_query($mysqli, "SELECT * FROM image WHERE id = '$next_id' ORDER BY id LIMIT 1");
						if(mysqli_num_rows($query) != 0){
							while($run = mysqli_fetch_assoc($query)){
								$id = $run['id'];
								$url = $run['url'];
								$name = $run['name'];
								$member_id = $run['member_id'];
								$album_id = $run['album_id'];
								$description = $run['description'];
								$date = $run['date'];
						?>
						<div id = "image">
							<img src = "uploads/<?php echo $url; ?>" width = "700" height = "500">
						<?php
							}
						?>
						<div class = "next">
							<a href = "photopagebyid.php?previous_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
						</div>
			</div>
			<div class = "photopageinfo">
				<?php
					//find album name from album_id
					$query1 = mysqli_query($mysqli, "SELECT name FROM album WHERE id = '$album_id'");
					$run = mysqli_fetch_assoc($query1);
					$album_name = $run['name'];
					//find member username from member_id
					$query1 = mysqli_query($mysqli, "SELECT username FROM members WHERE id = '$member_id'");
					$run = mysqli_fetch_assoc($query1);
					$username = $run['username'];
				?>
				<div class = "photopage-photoname">
					<h1><?php echo $name; ?></h1>
				</div>
				<div class = "photopage-photodesc">
					"<?php echo $description; ?>"
				</div>
				<div class = "photopage-photodate">
					<?php
						if($date!="0000-00-00"){
							?>
							Date : <?php echo $date; ?>
							<?php
						}
						else{
							?>
							Date : Not Avaliable
							<?php
						}
					?>
				</div>
				<div class = "photopage-albumname">
					<span> Album : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewalbumpage.php"> ' . $album_name . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
					?>			
				</div>
				<div class = "photopage-username">
					<span> Author : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewphotogallerypage.php"> ' . $username . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
					?>												
				</div>
			</div>
			<div class = "photoslider">
						<?php
						}
					}
				}
				//if neither the previous nor next button is clicked, photoslider class retrieves information and display the first image sorted by ID, and photopageinfo displays the retrieved information.
				else if($_GET['id']){
					$image_id = $_GET['id'];
					$query = mysqli_query($mysqli, "SELECT * FROM image WHERE id = '$image_id'");
					if(mysqli_num_rows($query) != 0){
						while($run = mysqli_fetch_assoc($query)){
							$id = $run['id'];
							$url = $run['url'];
							$name = $run['name'];
							$member_id = $run['member_id'];
							$album_id = $run['album_id'];
							$description = $run['description'];
							$date = $run['date'];
					?>
					<div id = "image">
					<img src = "uploads/<?php echo $url; ?>" width = "700" height = "500">
					<?php
						}
					?>
						<div class = "prev">
							<a href = "photopagebyid.php?next_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-left"></span></a>
						</div>
						<div class = "next">
							<a href = "photopagebyid.php?previous_id=<?php echo $id;?>" ><span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
			</div>
			<div class = "photopageinfo">
				<?php
					//find album name from album_id
					$query1 = mysqli_query($mysqli, "SELECT name FROM album WHERE id = '$album_id'");
					$run = mysqli_fetch_assoc($query1);
					$album_name = $run['name'];
					//find member username from member_id
					$query1 = mysqli_query($mysqli, "SELECT username FROM members WHERE id = '$member_id'");
					$run = mysqli_fetch_assoc($query1);
					$username = $run['username'];
				?>
				<div class = "photopage-photoname">
					<h1><?php echo $name; ?></h1>
				</div>
				<div class = "photopage-photodesc">
					"<?php echo $description; ?>"
				</div>
				<div class = "photopage-photodate">
					<?php
						if($date!="0000-00-00"){
							?>
							Date : <?php echo $date; ?>
							<?php
						}
						else{
							?>
							Date : Not Avaliable
							<?php
						}
					?>
				</div>
				<div class = "photopage-albumname">
					<span> Album : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewalbumpage.php"> ' . $album_name . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewalbum.php?id=<?php echo $album_id;?>"><?php echo $album_name; ?></a>
					<?php
						}
					?>			
				</div>
				<div class = "photopage-username">
					<span> Author : </span>
					<?php 
						if($_SESSION['username'] != $username){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
						else if($_SESSION['username'] == $username){
							echo '<a href = "viewphotogallerypage.php"> ' . $username . '</a>';
						}
						else if($_SESSION['username'] == "Guest"){
					?>
					<a href = "guestviewphotogallery.php?username=<?php echo $username;?>"><?php echo $username; ?></a>
					<?php
						}
					?>												
				</div>
			</div>
						<?php
					}
				}
			?>
			<script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>