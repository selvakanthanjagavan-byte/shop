<?php

@include 'config.php';

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'AND password='$password'") or die('query failed');

    if(mysqli_num_rows($check_email) > 0){
        $message[] = 'User already exists!';
    } else {

        if($password != $cpassword){
            $message[] = 'Confirm password not matched!';
        } else {

            $insert = mysqli_query($conn,
                "INSERT INTO `users`(name, email, password, user_type) 
                VALUES('$name', '$email', '$password', '$user_type')"
            ) or die('query failed');

            if($insert){
                $message[] = 'Registered success(fully!';
                header('location:login.php');
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-uA-compatible" content="IE=edge">
    <title> register </title>

    <!-- font awsome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!--customer css file link-->
    <link rel="stylesheet"  href="style.css">

</head>
<body>



<?php
  if(isset($message)){
       foreach($message as $message){
          echo'
        <div class="message">
    <span> '.$message.'</span>
    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
       }
  }


?>





    <div class="form-container">
        <form action="" method="post">
            <h3>Register Now</h3>
            <input type="text" name="name" placeholder="Enter your name" required class="box">
            <input type="email" name="email" placeholder="Enter your email" required class="box">
            <input type="password" name="password" placeholder="Enter your password" required class="box">
             <input type="password" name="cpassword" placeholder="Enter your  confirm password" required class="box">

            <select name="user_type" class="box">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" name="submit" value="Register Now" class="btn">
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>


</html>