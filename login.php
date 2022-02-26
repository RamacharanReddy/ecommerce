<?php
include "dbconfig/config.php"
?>
<html>
  <head>
    <title>Login page</title>
<link rel="stylesheet" href="css/login.css">
<?php include 'bootstrap.php'; ?>
</head>
 </head>
 <body style="background-image: url('images/bg.jpg');"> 
 	<div style="width: 50%;margin: auto;">
<div align="center">
<div style="background-color: white;border-radius: 20px; padding:10px; padding-top:0px; padding-bottom: 0px;max-width: 60%;">
  <form class="text-center form-signin"  method="post"><br> <br>
  	
      <h1 class="h3 mb-3 font-weight-normal"><B>Login Form</B></h1>
      <img class="mb-4" src="images/logo1.png" alt="" width="100" height="100">

      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
      <span id = "a" style="color: red;margin: 3px;"></span>
      <p>
          <a href="index.php" class="btn btn-info my-2" type="submit">Back to Homepage</a>
          <input name="login" class="btn btn-success my-2" type="submit" value="sign in">
      </p>
  </form>
</div>
</div>
</div>
  <?php
    if(isset($_POST['login']))
    {
      $email=$_POST['email'];
      $password=$_POST['password'];
      $encrypted_password = md5($password);
      
      $query="select * from user WHERE email='$email' AND password='$encrypted_password'";
      
      $query_run = mysqli_query($con,$query);
      if(mysqli_num_rows($query_run)>0)
      {
        session_start();
        $_SESSION['id'] = $email;
        header('location:index.php');
      }
      else
      {
        echo "<script>
        		document.getElementById('a').innerHTML = 'Invalid combination Try Again'
        	</script>";
      }
      
    }
  ?>
</body>
</html>