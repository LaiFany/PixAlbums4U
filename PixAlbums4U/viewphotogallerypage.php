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
         
         function setErrorMessage(msg){
            var errorMsg = document.getElementById("error-msg");
            if(errorMsg != null) {
               errorMsg.innerHTML = "";
               errorMsg.appendChild(document.createTextNode(msg));
            }
         }
      </script>
	</head>
	<body onresize="changePaddingTop()">
		<?php include 'connect.php' ?>
		<?php include 'choose-navbar.php'; ?>
      <script>changePaddingTop();</script>
		<section class = "viewalbumpage-section">
			<form method = "post" class = "formStyle1" role="form">
            <div class ="container-fluid">
            <div class="row">
            <div class="col-md-3" style="border-right: 2px solid black"><!--side-bar-->
               <h1 id="album-name"></h1><br />
               <button type = "submit" name = "editbutton" id = "editbutton" class="btn btn-default">Edit</button>
					<button type = "submit" name = "deletebutton" id = "deletebutton" class="btn btn-default">Delete</button>
               <p id="error-msg" style="margin-top: 5px;"></p>
            </div><!--end col-md-3-->
            <div class="col-md-9"><!--thumbnails-->
					<?php
						//get username from session id.
						$query = mysqli_query($mysqli,"SELECT username FROM members WHERE id = {$_SESSION['id']}");
						$run = mysqli_fetch_assoc($query);
						$username = $run['username'];
						//check whether if there is album created.
						$query = mysqli_query($mysqli,"SELECT id, name FROM album WHERE member_id = {$_SESSION['id']}");
						if(mysqli_num_rows($query) != 0){
							?>
								
							<?php
							//display retrived album information.
							$query1 = mysqli_query($mysqli,"SELECT id, name FROM album WHERE member_id = {$_SESSION['id']}");
							while($run = mysqli_fetch_array($query1)){
								$album_id = $run['id'];
								$album_name = $run['name'];
							
								$query2 = mysqli_query($mysqli,"SELECT url FROM image WHERE album_id = '$album_id' AND member_id = {$_SESSION['id']} ORDER BY date_time_created");
								$run2 = mysqli_fetch_assoc($query2);
								$cover = $run2['url'];
								if(!empty($cover)){
					?>
					<div class ="album_thumbnail">
                  <div class="checkbox">
						<a href = "viewalbumpage.php?id=<?php echo $album_id; ?>" class = "albumnamelink">
							<img src = "uploads/<?php echo $cover; ?>" style="height: 300px; width: 300px"/>
							<br/>
							<strong><?php echo $album_name; ?></strong>
						</a>
                  
						<input style="position: absolute; left: 300px;" type = "checkbox" name = "albumlist[]" value = "<?php echo $album_id;?>">
                  </div>
					</div>
					
					<?php 
								}
								else{
					?>
					<div class ="album_thumbnail">
                  <div class="checkbox">
						<a href = "viewalbumpage.php?id=<?php echo $album_id; ?>" class = "albumnamelink">
							<img src = "images/no_image.jpg" style="height: 300px; width: 300px"/>
							<br/>
							<strong><?php echo $album_name; ?></strong>
						</a>
                  
						<input style="position: absolute; left: 300px;" type = "checkbox" name = "albumlist[]" value = "<?php echo $album_id;?>">
                  </div>
					</div>
					<?php
								}
							}
						}
						else{
							echo "Please create an album to get started! ";
						}
					?>
					<?php
						//delete album.
						if(isset($_POST['deletebutton'])){					
							//check whether there is album created.
							$query = mysqli_query($mysqli,"SELECT * FROM album WHERE member_id = {$_SESSION['id']}");
							if(mysqli_num_rows($query) != 0){
								if(isset($_POST['albumlist'])){
								
									$checklist = $_POST['albumlist'];
									//if no checkbox is checked, display error.
									if(empty($album_id)){
                              ?>
                              <script>setErrorMessage("Album not selected");</script>
                              <?php
									}
									else{
										$selected = count($checklist);
										for($i = 0; $i < $selected; $i++){
											//delete album row with acquired album id.
											$query2 = mysqli_query($mysqli, "DELETE FROM album WHERE id = '$checklist[$i]' AND member_id = {$_SESSION['id']}");
											//delete image row with acquired album id.
											$query3 = mysqli_query($mysqli,"SELECT url FROM image WHERE album_id = '$checklist[$i]' AND member_id = {$_SESSION['id']}");
											while($run3 = mysqli_fetch_array($query3)){
												$img = $run3['url'];			
												//if image is deleted from the directory successfully, delete the image row from database table.
												if(unlink("uploads/".$img)){
												$query4 = mysqli_query($mysqli, "DELETE FROM image WHERE url = '$img' AND album_id = '$checklist[$i]' AND member_id = {$_SESSION['id']}");
												}
											}
											exit(header("Location:viewphotogallerypage.php"));
										}	
									}
								}
								else{
									?>
                              <script>setErrorMessage("Album not selected");</script>
                              <?php
								}
							}
							else{
								echo "No album to delete! ";
							}
						}
					?>
            <?php 
						if(isset($_POST['editbutton'])){
							if(isset($_POST['albumlist'])){
						
								$checklist = $_POST['albumlist'];
								//if no checkbox is checked, display error.
								if(empty($checklist)){
									?>
                              <script>setErrorMessage("Album not selected");</script>
                              <?php
								}
								else{
									//assign count for loop, for selection purpose.
									$selected = count($checklist);
									if($selected != 1){
                              ?>
                              <script>setErrorMessage("Please select only 1 album to edit!");</script>
                              <?php
									}
									else{
										exit(header("Location: editalbumpage.php?id=$checklist[0]"));
									}
								}
							}
							else{
								?>
                              <script>setErrorMessage("Album not selected");</script>
                              <?php
							}
						}
					?>
               </div><!--end div col-md-9-->
               <div class = "sidebar">
                  <h1 id="temp-album-name"><?php echo $username; ?>'s <br/> Albums</h1><br />
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
      <?php
         ob_end_flush();
      ?>
	</body>
</html>