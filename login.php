
<?php
include 'config.php';
session_start();

if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // Check user
    $select_users = mysqli_query($conn, 
        "SELECT * FROM `users` WHERE email='$email' AND password='$password'"
    ) or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $row = mysqli_fetch_assoc($select_users);

        if($row['user_type'] == 'admin'){
            $_SESSION['admin_name']  = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id']    = $row['id'];
            header('location: admin_page.php');
            exit();

        } elseif($row['user_type'] == 'user'){
            $_SESSION['user_name']  = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id']    = $row['id'];
            header('location: home.php');
            exit();
        }

    } else {
        $message[] = 'Incorrect email or password!';
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-uA-compatible" content="IE=edge">
    <title> login </title>

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
            <h3>login Now</h3>
            <input type="email" name="email" placeholder="Enter your email" required class="box">
            <input type="password" name="password" placeholder="Enter your password" required class="box">
           
            <input type="submit" name="submit" value="login Now" class="btn">
            <p>Don't have an account? <a href="register.php">register now</a></p>
        </form>
    </div>

</body>
</html>