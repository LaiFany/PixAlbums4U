<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'common.php'?>
      <title>Create Album - PixAlbums4U</title>
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
		<section class = "album-section" id = "uploadImg">
			<div class = "container">
			<?php include 'connect.php' ?>
				<form method = "post" role="form">
					<?php						
						if(isset($_POST['name'])){
							$name = mysqli_real_escape_string($mysqli, $_POST['name']);
							$sessionid = $_SESSION['id'];
							if(empty($name)){
								echo "Please enter album name.";
							}
							else{
								//check whether album name exists.
								$query = mysqli_query($mysqli,"SELECT name FROM album WHERE name = '$name' AND member_id = '$sessionid'");
								if(mysqli_num_rows($query) != 0){
									
									echo "Album name already exists. Please try a different name. ";
								}
								else{
									//create album with entered name.
									mysqli_query($mysqli,"INSERT INTO album (name, member_id) VALUES('$name','$sessionid')");
									echo $name." created!" ;
								}
							}
						}
					?>
					<div class = "formStyle1">
						<h1>Create your album!</h1>
                  <div class="form-group">
                     <label>Album Name</label>
                     <input class="form-control" type = "text" name = "name" required/>
                  </div>
						<button type = "submit" value = "Create" class="btn btn-default">Create</button>
                  <button type = "button" name = "cancelbutton" value="cancel" class="btn btn-default" onclick="history.back();">Cancel</button>
					</div>
				</form>
			</div>
		</section>
		<script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>