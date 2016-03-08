<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
      <?php include 'common.php'?>
		<title>Upload Album - PixAlbums4U</title>
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
	</head>
	<body onresize="changePaddingTop()">
		<?php include 'choose-navbar.php'; ?>
		<?php include 'connect.php'?>
      <script>changePaddingTop();</script>
		<section class = "album-section" id = "uploadImg">
			<div class = "container">
				<form method = "post" enctype = "multipart/form-data" role="form">
					<?php
						if(isset($_POST['uploadbutton'])){
							$query = mysqli_query($mysqli,"SELECT id, name FROM album WHERE member_id = {$_SESSION['id']}");
							if(mysqli_num_rows($query) != 0){
								
								$album_id = $_POST['album'];
								$name = mysqli_real_escape_string($mysqli, $_POST['name']);
								$description = mysqli_real_escape_string($mysqli, $_POST['desc']);
								$date = $_POST['date'];
								$file_type = $_FILES['img']['size'];
								$file_tmp = $_FILES['img']['tmp_name'];
								$url = basename( $_FILES['img']['name']);
								//set directory path
								$target_path = "uploads/";
								//add filename to target path. e.g. uploads/filename.extension
								$target_path = $target_path . basename($_FILES['img']['name']);
									
										// upload file
										if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
											mysqli_query($mysqli,"INSERT INTO image (album_id, member_id, name, description, date, url) VALUES ('$album_id', {$_SESSION['id']}, '$name', '$description','$date','$url')");
											echo "The photo ".$name. " has been uploaded.";
										} 
										else {
											echo "Sorry, there was an error uploading your file.";
										}
							}
							else{
								echo "Please create an album!";
							}
						}
					?>
					<h1>Upload your image!</h1>
					
                  <div class="form-group">
							<label>Select image to upload</label>
							<input class="form-control" type = "file" accept="image/*" name = "img" id = "img" onchange = "readURL(this);" required/>
                  </div>
							<img id = "image" src = "#" alt = "No image uploaded" />
                  <div class="form-group">
							<label>Name</label>
							<input class="form-control" type = "text" name = "name" id = "name" required/>
                  </div>
                  <div class="form-group">
							<label>Date</label>
							<input class="form-control" type = "date" name = "date" id = "date"/>
                  </div>
                  <div class="form-group">
							<label>Description</label>
							<input class="form-control" type = "text" name = "desc" id = "desc"/>
                  </div>
                  <div class="form-group">
							<label>Select Album</label>
							<select class="form-control" name = "album">
								<?php
									$query = mysqli_query($mysqli,"SELECT id,name FROM album WHERE member_id = {$_SESSION['id']}");
									while($run = mysqli_fetch_array($query)){
										$album_id = $run['id'];
										$album_name = $run['name'];
										echo "<option value = '$album_id'>$album_name</option>";
									}
								?>
							</select>
                  </div>
                  <button type = "submit" name = "uploadbutton" class="btn btn-default">Upload</button>
                  <button type = "button" name = "cancelbutton" value="cancel" class="btn btn-default" onclick="history.back();">Cancel</button>
				</form>
			</div>
		</section>
		<script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>