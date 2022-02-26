<?php
  require 'dbconfig/config.php';
  session_start();
      if(isset($_SESSION['id'])){
    header('location:index.php');
  }
  ?>
<html>
<head>
    <link rel="stylesheet" href="css/register.css">
<?php include 'bootstrap.php'; ?>

</head>
<body style="background-image: url('images/bg.jpg');">

<div align="center" style="width: 50%;margin: auto;"> 
<div style="background-color:white;border-radius:25px;width:60%;">
    <form class="form-register text-center" method="post">
      <h1 class="h3 mb-3 font-weight-normal"><strong>Registration Form</strong></h1>
          <img class="mb-4" src="images/logo1.png " alt="" width="100" height="100">

          <label for="inputName" class="sr-only">Name:</label>
          <input type="Name" name="name" id="inputName" class="form-control" placeholder="Name" required autofocus>

          <label for="inputPhoneno" class="sr-only">Phone No</label>
          <input name="phoneno"id="inputPhoneno" class="form-control" placeholder="Phone No" pattern="[1-9]{1}[0-9]{9}" required autofocus>

          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password"  name="password" id="inputPassword" class="form-control" placeholder="Password" required>

          <label for="inputCPassword" class="sr-only">Confirm password</label>
          <input type="password" name="cpassword" id="inputCPassword" class="form-control" placeholder="Confirm Password" required>

      <a href="index.php"  class="btn btn-info my-2" type="submit">Back to Homepage</a>
      <input name="submit_btn" class="btn btn-success my-2" type="submit" value="Register">
    </form>
</div>
  <?php
      if(isset($_POST['submit_btn']))
      {
        $name = $_POST['name'];
        $phoneno = $_POST['phoneno'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        if($password==$cpassword)
        {
          $encrypted_password = md5($password);
          
          $query= "select * from user WHERE email='$email'";
          $query_run = mysqli_query($con,$query);
          
          if(mysqli_num_rows($query_run)>0)
          {
            echo '<script type="text/javascript"> alert("User already exists.. try another Email") </script>';
          }
          else
          {
            $query = "insert into user values('','$name','$phoneno','$email','$encrypted_password')";
            $query_run = mysqli_query($con,$query);
            
            if($query_run)
            {
              echo '<script type="text/javascript"> alert("User Registered.. Go to login page to login") </script>';
            }
            else
            {
              echo '<script type="text/javascript"> alert("Error!") </script>';
            }
          }
          
          
        }
        else{
        echo '<script type="text/javascript"> alert("Password and confirm password does not match!") </script>';  
        }
      }
    ?>
</body>
</html>