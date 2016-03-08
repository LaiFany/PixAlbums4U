<?php
   ob_start();
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
			<div class = "container">
				<form method = "post" class = "formStyle1" role="form">
            <div class = "container-fluid">
            <div class="row">
            <div class="col-md-3" style="border-right: 2px solid black"><!--side-bar-->
               <h1 id="album-name"></h1>
               <h2 id="album"></h2>
               <button type = "submit" name = "editbutton" id = "editbutton" class="btn btn-default">Edit</button>
					<button type = "submit" name = "deletebutton" id = "deletebutton" class="btn btn-default">Delete</button>
            </div><!--end col-md-3-->
            <div class="col-md-9"><!--thumbnails-->
				<?php
					$album_id = $_GET['id'];
					//get username from session id.
					$query = mysqli_query($mysqli,"SELECT username FROM members WHERE id = {$_SESSION['id']}");
					$run = mysqli_fetch_assoc($query);
					$username = $run['username'];
					//get album name based on album id retrieved.
					$query = mysqli_query($mysqli,"SELECT name FROM album WHERE id = '$album_id'");
					$run = mysqli_fetch_assoc($query);
					$album_name = $run['name'];
					//get image info based on album id retrieved.
					$query = mysqli_query($mysqli,"SELECT id, name, url, description FROM image WHERE album_id = '$album_id' AND member_id = {$_SESSION['id']} ORDER BY date_time_created");
					if(mysqli_num_rows($query) != 0){
						?>
							<!--div class = "sidebar">
								<h1><?php echo $username; ?>'s <br/> Albums</h1>
								<h2><?php echo $album_name; ?></h2>
								<button type = "submit" name = "editbutton" id = "editbutton">Edit</button>
								<button type = "submit" name = "deletebutton" id = "deletebutton">Delete</button>
							</div-->
							<?php
						while($run = mysqli_fetch_array($query)){
							$photo_id = $run['id'];
							$name = $run['name'];
							$url = $run['url'];
							$description = $run['description'];
				?>
				<div class = "image_thumbnail">
            <div class="checkbox">
					<a href = "photopagebyalbumid.php?id=<?php echo $photo_id;?>" class = "albumnamelink">
						<img src = "uploads/<?php echo $url; ?>" style="height: 150px; width: 150px"/>
						<br/>
						<strong><?php echo $name; ?></strong>
						<br/>
					</a>
					<input style="position: absolute; left: 150px; bottom: 2px;" type = "checkbox" name = "imagelist[]" value = "<?php echo $url; ?>"></input>
            </div>
				</div>
				<?php
						}
					}
					else{
						echo "<br/>Please insert photos into album! <br/><br/><br/>";
					}
				?>
				</div><!--end div col-md-9-->
				<div class = "sidebar">
					<h1 id="temp-album-name"><?php echo $username; ?>'s <br/> Albums</h1>
					<h2 id="temp-album"><?php echo $album_name; ?></h2>
				</div>
            </div><!--end div row-->
				<?php 
					if(isset($_POST['editbutton'])){
						if(isset($_POST['imagelist'])){
							
							$checklist = $_POST['imagelist'];
							//if no checkbox is checked, display error.
							if(empty($checklist)){
								echo("Image not selected!");
							}
							else{
								//assign count for loop, for selection purpose.
								$selected = count($checklist);
								if($selected != 1){
									echo "Please select only one image to edit! ";
								}
								else{
									exit(header("Location:editphotopage.php?url=$checklist[0]"));
								}
							}
						}
						else{
							?>
							<span id = "sidebar">Image not selected!</span>
							<?php
						}
					}
					//delete image.
					if(isset($_POST['deletebutton'])){					
						//check whether there is image uploaded.
						$query = mysqli_query($mysqli,"SELECT * FROM image WHERE member_id = {$_SESSION['id']}");
						if(mysqli_num_rows($query) != 0){
							if(isset($_POST['imagelist'])){
								
								$checklist = $_POST['imagelist'];
								//if no checkbox is checked, display error.
								if(empty($checklist)){
									echo("Image not selected!");
								}
								else{
									//assign count for loop purpose.
									$selected = count($checklist);
									for($i = 0; $i < $selected; $i++){
										//if image is deleted from the directory successfully, delete the image row from database table.
										if(unlink("uploads/".$checklist[$i])){
											$query4 = mysqli_query($mysqli, "DELETE FROM image WHERE url = '$checklist[$i]' AND member_id = {$_SESSION['id']}");
											exit(header("Location:viewalbumpage.php?id=$album_id"));
										}
									}
								}	
							}
							else{
								echo "Image not selected!";
							}
						}
						else{
							echo "No image to delete! ";
						}
					}
				?>
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
      <?php
         ob_end_flush();
      ?>
	  <script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>