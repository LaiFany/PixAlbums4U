<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'common.php'?>
      <title>Gallery - PixAlbums4U</title>
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
	</head>
	<body onresize="changePaddingTop()">
		<?php include 'choose-navbar.php'; ?>
		<?php include 'connect.php' ?>
      <script>changePaddingTop();</script>
		<section class = "viewalbumpage-section">
			<form method = "post" class = "formStyle1">
			<div class = "container-fluid">
         <div class="row">
            <div class="col-md-3" style="border-right: 2px solid black"><!--side-bar-->
               <h1 id="album-name"></h1>
               <h2 id="album"></h2>
            </div><!--end col-md-3-->
            <div class="col-md-9"><!--thumbnails-->
				<?php
					$album_id = $_GET['id'];
					//get album name and member id based on album id retrieved.
					$query = mysqli_query($mysqli,"SELECT name, member_id FROM album WHERE id = '$album_id'");
					while($run = mysqli_fetch_array($query)){
						$album_name = $run['name'];
						$member_id = $run['member_id'];
					}
					//get username based on member id retrieved.
					$query = mysqli_query($mysqli,"SELECT username FROM members WHERE id = '$member_id'");
					$run = mysqli_fetch_assoc($query);
					$username = $run['username'];
					//get image information based on the album id retrieved.
					$query = mysqli_query($mysqli,"SELECT id, name, url, description FROM image WHERE album_id = '$album_id'");
					if(mysqli_num_rows($query) != 0){
						
						while($run = mysqli_fetch_array($query)){
							$photo_id = $run['id'];
							$name = $run['name'];
							$url = $run['url'];
							$description = $run['description'];
				?>
				<div class = "image_thumbnail">
					<a href = "photopagebyalbumid.php?id=<?php echo $photo_id;?>" id = "albumnamelink">
						<img src = "uploads/<?php echo $url; ?>" style="height: 150px; width: 150px"/>
						<br/>
						<b><?php echo $name; ?></b>
						<br/>
					</a>
				</div>
				<?php
						}
					}
					else{
						echo "This album contains no photos! ";
					}
				?>
				</div><!--end div col-md-9-->
				<div class = "sidebar">
					<h1 id="temp-album-name"><?php echo $username; ?>'s <br/> Albums</h1>
					<h2 id="temp-album"><?php echo $album_name; ?></h2>
				</div>
         </div><!--end div row-->
			</div><!--end div container-fluid-->
			</form>
		</section>
      <script>
         // move the text of album name to col-md-3
         var albumName = document.getElementById("album-name");
         var tempAlbumName = document.getElementById("temp-album-name");
         albumName.appendChild(document.createTextNode(tempAlbumName.textContent));
         
         // empty the text of temp album name
         tempAlbumName.innerHTML = "";
         
         // set document title to the same textContent
         
         document.title = albumName.textContent;
         
         var album = document.getElementById("album");
         var tempAlbum = document.getElementById("temp-album");
         
         album.appendChild(document.createTextNode(tempAlbum.textContent));
         
         tempAlbum.innerHTML = "";
      </script>
	  <script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>