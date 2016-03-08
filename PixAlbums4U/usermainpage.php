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
      
		<?php include 'connect.php'; ?>
		<?php include 'choose-navbar.php'; ?>
      <script>changePaddingTop();</script>
		<section class = "usermainpage-section">
			<div class = "container">
         <div class="row">
         <div class="col-md-8">
				<h1>Photos</h1>
				<?php
					//check for available images in database to display.
					$query = mysqli_query($mysqli,"SELECT id, url, description, member_id, album_id, name FROM image ORDER BY RAND()");
					if(empty($query)){
						echo 'No available images to display.';
					}
					else{
						while($run = mysqli_fetch_array($query)){
							$image_id = $run['id'];
							$url = $run['url'];
							$description = $run['description'];
							$name = $run['name'];
							$member_id = $run['member_id'];
							$album_id = $run['album_id'];
							//get username for each displayed photos.
							$query1 = mysqli_query($mysqli,"SELECT username FROM members WHERE id = '$member_id'");
							$run1 = mysqli_fetch_assoc($query1);
							$username = $run1['username'];
							//get album name for each displayed photos.
							$query2 = mysqli_query($mysqli,"SELECT name FROM album WHERE id = '$album_id'");
							$run2 = mysqli_fetch_assoc($query2);
							$album_name = $run2['name'];
							?>
							<div id = "usermainpage-images">
									<img src = "uploads/<?php echo $url;?>"/>
									<div id = "topimageinfo">
										<div class = "imageauthor">
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
									<div id = "bottomimageinfo">
										<div class = "imagename">
											<a href = "photopagebyid.php?id=<?php echo $image_id;?>"><?php echo $name ; ?></a>
										</div>
										<div class = "imagedesc">
											<?php echo $description ; ?>
										</div>
									</div>
							</div>
									
							<?php
						}
					}
				?>
            </div><!--end div col-md-8-->
            
            <div class="col-md-4">
               <div class = "explore">
                     <a href = "explore.php"><h1>Explore</h1></a>
                     <?php
                        //display a group of 6 images sorted at random.
                        $query3 = mysqli_query($mysqli,"SELECT url FROM image ORDER BY RAND() LIMIT 6");
                        if(empty($query3)){
                           echo 'No images to display!';
                        }
                        else{
                           while($run3 = mysqli_fetch_array($query3)){
                           $url = $run3['url'];
                     ?>
                        <img src = "uploads/<?php echo $url; ?>" style="width: 100px; height: 100px">
                     <?php
                     }
                  }
                  ?>
               </div>
               
               <div class = "latestphoto">
                  <a href = "latestphotopage.php"><h1>Latest Photos</h1></a>
                  <?php
                     //display a group of 6 images sorted by their creation date and time.
                     $query3 = mysqli_query($mysqli,"SELECT url FROM image ORDER BY date_time_created DESC LIMIT 6");
                     if(empty($query3)){
                        echo 'No images to display!';
                     }
                     else{
                        while($run3 = mysqli_fetch_array($query3)){
                           $url = $run3['url'];
                  ?>
                  <img src = "uploads/<?php echo $url; ?>" style="width: 100px; height: 100px">
                  <?php
                     }
                  }
                  ?>
               </div>
            </div><!--end div col-md-4-->
            </div><!--end div row-->
			</div><!--end div container-->
		</section>
        <script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>