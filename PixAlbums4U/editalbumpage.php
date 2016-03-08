<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'common.php'?>
      <title>Edit Album - PixAlbums4U</title>
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
		<section class = "album-section" id = "uploadImg">
			<div class = "container">
				<form method = "post" role="form">
					<?php						
						$album_id = $_GET['id'];
							if(isset($_POST['name'])){
								$name = mysqli_real_escape_string($mysqli, $_POST['name']);
							
								if(empty($name)){
									echo "Please enter album name.";
								}
								else{
									//check whether album name exists.
									$query = mysqli_query($mysqli,"SELECT name FROM album WHERE name = '$name' AND member_id = {$_SESSION['id']}");
									if(mysqli_num_rows($query) != 0){
										
										echo "Album name already exists. Please try a different name. ";
									}
									else{
										//update album with entered name.
										mysqli_query($mysqli,"UPDATE album SET name = '$name' WHERE id = '$album_id' AND member_id = {$_SESSION['id']}");
										echo "Album updated !";
									}
								}
							}
					?>
					<div class = "formStyle1">
						<h1>Edit your album!</h1>
                  <div class="form-group">
                     <label>Album Name</label>
                     <input class="form-control" type = "text" name = "name" required/>
                  </div>
						<button type = "submit" name = "editbutton" class="btn btn-default">Edit</button>
                  <button type = "button" name = "cancelbutton" value="cancel" class="btn btn-default" onclick="history.back();">Cancel</button>
					</div>
				</form>
			</div>
		</section>
		<script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>