<?php
   if(isset($_POST['loginbutton'])){
      $username = testInput($_POST['username']);
      $password = testInput($_POST['password']);				
      // change to prepare statement
      // original code: // $select_user = "select * from members where username = '$username' AND password = '$password'";

      // new code:
      $select_user = "select id from members where username = ? AND password = ?";
            
      // original code: // $run_user = mysqli_query($mysqli,$select_user);
      // new code:
      if($stmt = mysqli_prepare($mysqli, $select_user)){
         mysqli_stmt_bind_param($stmt, "ss", $username, $password);
               
         mysqli_stmt_execute($stmt);
               
         mysqli_stmt_bind_result($stmt, $id_result);
               
         mysqli_stmt_fetch($stmt);
               
         $check_user = $id_result;
               
         mysqli_stmt_close($stmt);
      }
            
      // original code: // $check_user = mysqli_num_rows($run_user);
      // check existence of user 
      // original code: // if(!empty($check_user)){
      // new code:
      if(isset($check_user)){
         $query = mysqli_query($mysqli,"SELECT id FROM members WHERE username = '$username'");
         $run = mysqli_fetch_array($query);
         $id = $run['id'];
         $_SESSION['username'] = $username;
         $_SESSION['id'] = $id;
         header('Location: usermainpage.php');
      }
      else{
         echo "Invalid Login";
      }
   }
?>