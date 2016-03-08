<?php 
   if(isset($_SESSION['username']) && $_SESSION['username'] != "Guest"){
      include 'navbar-user.php';
?>
      <script>isGuest = false;</script>
<?php
   }
   else{
      include 'navbar-guest.php';
   }
?>