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
		<?php include 'connect.php' ?>
		<?php include 'choose-navbar.php'; ?>
      <script>changePaddingTop();</script>
		<section class = "viewalbumpage-section">
			<form method = "post" class = "formStyle1">
				<div class ="container-fluid">
            <div class="row">
            <div class="col-md-3" style="border-right: 2px solid black"><!--side-bar-->
               <h1 id="album-name"></h1>
            </div><!--end col-md-3-->
            <div class="col-md-9"><!--thumbnails-->
					<?php
						if(isset($_GET['username']))
							$username = $_GET['username'];
						else
							$username = '';
						$query = mysqli_query($mysqli, "SELECT id FROM members WHERE username = '$username'");
						$run = mysqli_fetch_assoc($query);
						$member_id = $run['id'];
						//check whether if there is album created.
						$query1 = mysqli_query($mysqli,"SELECT id, name FROM album WHERE member_id = '$member_id'");
						if(mysqli_num_rows($query1) != 0){
							//display retrieved album information.
							$query2 = mysqli_query($mysqli,"SELECT id, name FROM album WHERE member_id = '$member_id'");
							while($run2 = mysqli_fetch_array($query2)){
								$album_id = $run2['id'];
								$album_name = $run2['name'];
							
								$query3 = mysqli_query($mysqli,"SELECT url FROM image WHERE album_id = '$album_id'");
								$run3 = mysqli_fetch_assoc($query3);
								$cover = $run3['url'];
								if(!empty($cover)){
					?>
					<div class ="album_thumbnail">
						<a href = "guestviewalbum.php?id=<?php echo $album_id; ?>" id = "albumnamelink">
							<img src = "uploads/<?php echo $cover; ?>" height = "300px" width = "300px"/>
							<br/>
							<b><?php echo $album_name; ?></b>
						</a>
					</div>
					
					<?php 
								}
								else{
					?>
					<div class ="album_thumbnail">
						<a href = "guestviewalbum.php?id=<?php echo $album_id; ?>" id = "albumnamelink">
							<img src = "images/no_image.jpg"/>
							<br/>
							<b><?php echo $album_name; ?></b>
						</a>
					</div>
					<?php
								}
							}
						}
						else{
							echo "This album contains no photos! ";
						}
					?>
            </div><!--end div col-md-9-->
				<div class = "sidebar">
					<h1 id="temp-album-name"><?php echo $username; ?>'s <br/> Albums</h1>
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
      </script>
	  <script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>