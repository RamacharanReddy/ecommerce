<?php
  session_start();
  require 'dbconfig/config.php';
  if(!isset($_SESSION['id'])){
    header('location:login.php');
  }
?>
<html>
<head>
<title>Checkout</title>
<?php include 'bootstrap.php'; ?>
</head>
<style type="text/css">
body{
  background-color: hsl(0, 0%, 98%);
}

h1,h2,h3,h4,h5,h6{
  color:hsl(0, 0%, 30%);
}

.box-element{
  box-shadow:hsl(0, 0%, 80%) 0 0 16px;
  background-color: #fff;
  border-radius: 4px;
  padding: 10px;
}

.thumbnail{
  width: 100%;
  height: 200px;
  -webkit-box-shadow: -1px -3px 5px -2px rgba(214,214,214,1);
    -moz-box-shadow: -1px -3px 5px -2px rgba(214,214,214,1);
    box-shadow: -1px -3px 5px -2px rgba(214,214,214,1);
}

.product{
  border-radius: 0 0 4px 4px;
}

.bg-dark{
  background-color: #4f868c!important;
}

#cart-icon{
  width:25px;
  display: inline-block;
  margin-left: 15px;
}

#cart-total{
  display: block;
  text-align: center;
  color:#fff;
  background-color: red;
  width: 20px;
  height: 25px;
  border-radius: 50%;
  font-size: 14px;
}

.col-lg-4, .col-lg-6, .col-lg-8, .col-lg-12{
  margin-top: 10px;
}

.btn{
  border-radius: 0;
}

.row-image{
  width: 100px;
}

.form-field{
  width:250px;
  display: inline-block;
  padding: 5px;
}

.cart-row{
  display: flex;
    align-items: flex-stretch;
    padding-bottom: 10px;
    margin-bottom: 10px;
    border-bottom: 1px solid #ececec;

}

.quantity{
  display: inline-block;
  font-weight: 700;
  padding-right:10px;
  

}

.chg-quantity{
  width: 12px;
  cursor: pointer;
  display: block;
  margin-top: 5px;
  transition:.1s;
}



.hidden{
  display: none!important;

</style>
<?php
$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
$query_run0 = mysqli_query($con,$query0);
$row1 = mysqli_fetch_assoc($query_run0);
$x = $row1['user_id'];

$query1="SELECT * FROM `cart` WHERE user_id='".$x."' ";
$query_run1 = mysqli_query($con,$query1);
?>
<?php include 'navbar.php'; ?><hr>
 <body>
<div class="container" id="message">
  <div class="row">
    <div class="col-lg-6">
      <div class="box-element" id="form-wrapper">
          <div id="shipping-info">
            <hr>
            <p>Shipping Information:</p>
            <hr>
            <form class="form-submit" action="action2.php" method="post">
              <div class="form-field" >
                <input class="form-control address" type="text" name="address" placeholder="Address.." required/>
              </div>
              <div class="form-field">
                <input class="form-control city" type="text" name="city" placeholder="City.." required/>
              </div>
              <div class="form-field">
                <input class="form-control state" type="text" name="state" placeholder="State.." required/>
              </div>
              <div class="form-field">
                <input class="form-control zipcode" type="text" name="zipcode"  placeholder="Zip code.." required/>
              </div>
              <div class="form-field">
                <input class="form-control country" type="text"   name="country"  placeholder="Country." required/>
              </div>
              <hr>
              <button class="btn btn-success btn-block" type="submit">Continue</button>
            </form>
          </div>
      </div>
      <br>
    </div>

    <div class="col-lg-6">
      <div class="box-element">
        <a  class="btn btn-outline-dark" href="cart.php">&#x2190; Back to Cart</a>
        <hr>
        <h3>Order Summary</h3>
        <hr>
        <?php 
        while($row = mysqli_fetch_array($query_run1))
        {
        ?>
        <div class="cart-row">
          <div style="flex:2"><img class="row-image" src="<?php echo $row['image'] ?>"></div>
          <div style="flex:2"><p><?php echo $row['product_name']; ?></p></div>
          <div style="flex:1"><p>$ <?php echo $row['price']; ?></p></div>
          <div style="flex:1"><p>x<?php echo $row['quantity']; ?></p></div>
        </div>
        <?php
        }
        $query="SELECT * FROM `cart` WHERE user_id='".$x."' ";
        $query_run = mysqli_query($con,$query);
        $tqty= 0;
        $ttotal =0;
        while ($row1 = mysqli_fetch_assoc ($query_run)) {
          $tqty += $row1['quantity'];
          $ttotal += $row1['total_price'];
        } 
        ?>
        <h5>Items:<?php echo $tqty;?></h5>
        <h5>Total:$ <?php echo $ttotal;?></h5>
      </div>
    </div>
  </div>
</div>
</script>
</body>
</html>
