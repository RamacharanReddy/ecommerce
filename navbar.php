<?php
  if (isset($_POST['search'])) {
    $mytype = $_POST['myinput'];
    if(isset($_COOKIE['text'])){
      unset($_COOKIE['text']);
    }
    setcookie('text',$mytype,time() + 360);
    header('location:sample2.php');
  }
$x =0;
if(isset($_SESSION['id'])){
$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
$query_run0 = mysqli_query($con,$query0);
$row1 = mysqli_fetch_assoc($query_run0);
$x = $row1['user_id'];
}
$query="SELECT * FROM `cart` WHERE user_id='".$x."' ";
$query_run = mysqli_query($con,$query);
$tqty= 0;
$ttotal =0;
while ($row = mysqli_fetch_assoc ($query_run)) {
    $tqty += $row['quantity'];
}
$my = ' ';
$my1 = 'Login';
if(isset($_SESSION['id'])){
  $my = 'disabled';
  $my1 = 'Logged_in';
}


?>
<style>
.navbar-dark{
background-color:#0384fc !important;
}

.form-control1{
width: 500px !important;
}

#navbarDropdown{
color:black !important;
font-size:100% !important;
}
.btn1{
color:#0384fc !important;
width:auto;
max-height: 55px;
border-radius:5px;
font-size:100%;
font-weight:bold;
background-color:white;
}
#cart-icon{
  width:auto;
  display: inline-block;
}
.cart-total{
  display: block;
  text-align: center;
  color:black;
  width:100%;
  height:100%;
  border-radius: 40%;
  font-size:15px;
}
.dropdown:hover .dropdown-menu {display: block;}
</style>
<nav class="navbar navbar-expand-lg navbar-dark" style="margin-bottom:-1%">
  <a class="navbar-brand" href="index.php" style="margin-left:9%">Shopezzy</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
      <form class="form-inline my-2 my-lg-0" style="margin-left:2%;" method="post">
      <input class="form-control1 form-control mr-sm-2" type="search" name="myinput" placeholder="Search" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit" name="search">Search</button>

    </form>
      <button type="button" style="margin-left:1%" class="btn" onclick="Voice()">
      <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-soundwave" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8.5 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5zm-2 2a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm-6 1.5A.5.5 0 0 1 5 6v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm8 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm-10 1A.5.5 0 0 1 3 7v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5zm12 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5z"/>
      </svg>
    </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent" >
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active" style="margin-left:10%;">
        <a class="nav-link btn btn1 <?php echo $my; ?>" href="login.php" diz><?php echo $my1; ?><span class="sr-only"></span></a>
      </li>
      <li class="nav-item dropdown" style="margin-left:10%">
        <label class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</label>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="register.php">Register</a>
          <a class="dropdown-item" href="dashboard.php">Your Orders</a>
          <form action="index.php" method="post">
            <div class="dropdown-divider"></div>
            <input class="dropdown-item" type="submit" name="logout" value="Logout">
          </form>
        </div>
      </li>
      <li class="nav-item" style="margin-left:10%">
        <a href="cart.php" title="Placeholder link title" class="btn">
          <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>        
          </svg>
        </a>
        <li class="nav-item cart-total"><?php echo$tqty; ?></li>
      </li>
    </ul>
  </div>
</nav>
<?php
  if(isset($_POST['logout']))
    {
      session_unset();
        while(!session_destroy()){
          session_destroy();
        }
        echo("<meta http-equiv='refresh' content='1'>");
      }
?>
<script type="text/javascript" src="js/voice.js"></script>
<script type="text/javascript">

</script>