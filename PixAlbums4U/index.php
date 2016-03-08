<?php
	if(!isset($_SESSION)){
    session_start();
	function testInput($data) {
		 $data = trim($data);
		 $data = stripslashes($data);
	     $data = htmlspecialchars($data);
		 return $data;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include 'common.php'?>
      
      <style>
         body {
            padding-top: 60px;
            background-size: cover;
			transition: background 2s ease-out;
         }
         @media (max-width: 767px) {
            body {
               padding-top: 155px;
            }
         }
      </style>
      
      <title>Home - PixAlbums4U</title>
   </head>
   <body>
      <?php include 'navbar-main.php'; ?>
      <?php include 'connect.php';?>
      <?php
         //if user is logged in, transfer immediately to member main page.
         if(!empty($_SESSION['id'])){
            $member_id = $_SESSION['id']; 
            header("Location:usermainpage.php?id=$member_id");
         }
      ?>
      <div class="container-fluid">
         <div class="jumbotron">
            <blockquote>
               <p id="rotatequote">What I like about photographs is that they capture a moment that’s gone forever, impossible to reproduce.</p>
               <footer id="rotateauthor">Karl Lagerfeld</footer>
            </blockquote>
         </div>
      </div>
      
      <div class="container">
         <div class="row">
            <div class="col-md-6">
               <h3>Already a member?</h3>
               <form name="login" action="#" method="post" role="form">
               <?php include 'login-validation.php' ?>
                  <div class="form-group">
                     <label for="login-username">User name</label>
                     <input id="login-username" name="username" class="form-control" type="text" required="required"/>
                  </div>
                  <div class="form-group">
                     <label for="login-password">Password</label>
                     <input id="login-password"  name="password" class="form-control" type="password" required="required"/>
                  </div>
                  <button name="loginbutton" type="submit" class="btn btn-default">Login</button>
               </form>
            </div>
            <div class="col-md-6">
               <h3>Be a part of PixAlbums4U!</h3>
               <form name="signup" action="#" method="post" role="form">
                  <?php include 'signup-validation.php' ?>
                  <div class="form-group">
                     <label for="signup-username">User name</label>
                     <input id="signup-username" name="username" class="form-control" type="text" required="required"/>
                  </div>
                  <div class="form-group">
                     <label for="signup-email">Email</label>
                     <input id="signup-email" name="email" class="form-control" type="email" required="required"/>
                  </div>
                  <div class="form-group">
                     <label for="signup-password">Password</label>
                     <input id="signup-password" name="password" class="form-control" type="password" required="required"/>
                  </div>
                  <div class="form-group">
                     <label for="signup-confirm-password">Confirm Password</label>
                     <input id="signup-confirm-password" name="confirmpassword" class="form-control" type="password" required="required"/>
                  </div>
                  <button type="submit" name="signupbutton" class="btn btn-default">Sign up</button>
               </form>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <h3>About Us!</h3>
               <p>We're not too sure ourselves too. We will update you guys!</p>
            </div>
         </div>
         <?php include 'footer.php'?>
      </div>
      
      <script type = "text/javascript" src = "javascript/rotatequote.js"></script>
	  <script type = "text/javascript" src = "javascript/background.js"></script>
   </body>

</html>