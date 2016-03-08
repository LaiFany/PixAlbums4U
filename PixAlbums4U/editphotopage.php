<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'common.php'?>
      <title>Edit Photo - PixAlbums4U</title>
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
		<?php include 'connect.php'?>
      <script>changePaddingTop();</script>
		<section class = "uploadImg" id = "uploadImg">
				<form method = "post" role="form">
            <div class="container">
					<?php
						$url = $_GET['url'];
						if(isset($_POST['name'])){
							$name = mysqli_real_escape_string($mysqli, $_POST['name']);
							$date = $_POST['date'];
							$description = mysqli_real_escape_string($mysqli, $_POST['desc']);
							$album_id = $_POST['album'];
							
							//check whether photo detail is a duplicate within the album.
							$query = mysqli_query($mysqli,"SELECT name, album_id, description, date FROM image WHERE album_id = '$album_id'");
							while($run = mysqli_fetch_array($query)){
								$name1 = $run['name'];
								$date1 = $run['date'];
								$description1 = $run['description'];
								$album_id1 = $run['album_id'];
								if($name == $name1 && $date == $date1 && $description == $description1 && $album_id == $album_id1){
									echo "Details entered are a duplicate of the previous! ";
								}
								else{
									//update album with entered details.
									if(mysqli_query($mysqli,"UPDATE image SET name = '$name', date = '$date', description = '$description', album_id = '$album_id' WHERE url = '$url' AND member_id = {$_SESSION['id']}")){
										echo "Photo updated !";
									}
									else{
										echo "Photo not updated! ";
									}
								}
							}
						}
					?>

					<h1>Edit your image!</h1>

                  <img src = "uploads/<?php echo $url; ?>" style="height: auto; max-width: 50%;">

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
									//display the albums created by the user in a select form. 
									$query1 = mysqli_query($mysqli, "SELECT album_id FROM image WHERE url = '$url'");
									$run1 = mysqli_fetch_assoc($query1);
									$selected_id = $run1['album_id'];
									$query = mysqli_query($mysqli,"SELECT id,name FROM album WHERE member_id = {$_SESSION['id']}");
									while($run = mysqli_fetch_array($query)){
										$album_id = $run['id'];
										$album_name = $run['name'];
										if($selected_id == $album_id){
											echo "<option value = '$album_id' selected>$album_name</option>";
										}
										else{
											echo "<option value = '$album_id'>$album_name</option>";
										}
									}
								?>
							</select>
                     </div>
							<button type = "submit" name = "editbutton" class="btn btn-default">Edit</button>
                     <button type = "button" name = "cancelbutton" value="cancel" class="btn btn-default" onclick="history.back();">Cancel</button>
               </div><!--end div container-->
				</form>
		</section>
      <script type = "text/javascript" src = "javascript/background.js"></script>
	</body>
</html>