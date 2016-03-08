<?php
   if(isset($_POST['signupbutton'])){
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirmpassword = $_POST['confirmpassword'];
				
      //check whether username already exists
      $query = mysqli_query($mysqli,"SELECT username FROM members WHERE username = '$username'");
      if(mysqli_num_rows($query) != 0){
         echo "Username already exists.";
      }
      else if($password != $confirmpassword){
         echo "Password and Confirm Password do not match! ";
      }
      else{
         //check whether e-mail already exists
         $query = mysqli_query($mysqli,"SELECT email FROM members WHERE email = '$email'");
         if(mysqli_num_rows($query) != 0){
            echo "E-mail already exists. Please try a different E-mail! ";
         }
         else{
            //insert value into table
            mysqli_query($mysqli,"INSERT INTO members (username,email,password)
            VALUES ('$username','$email','$password')");
            $query = mysqli_query($mysqli,"SELECT id FROM members WHERE username = '$username'");
            $run = mysqli_fetch_array($query);
            $id = $run['id'];
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            header('Location: usermainpage.php');
         }
      }
   }
?>