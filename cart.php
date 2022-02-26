<?php
	session_start();
  require 'dbconfig/config.php';
  if(!isset($_SESSION['id'])){
  	header('location:login.php');
  }
?>
<html>
<head>
  <title>Shopezzy</title>
<?php include 'bootstrap.php'; ?>
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
</head>
<?php include 'navbar.php'; ?><hr>
<body>
<div class="container">
<?php
$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
$query_run0 = mysqli_query($con,$query0);
$row1 = mysqli_fetch_assoc($query_run0);
$x = $row1['user_id'];


$query="SELECT * FROM `cart` WHERE user_id='".$x."' ";
$query_run = mysqli_query($con,$query);
$tqty= 0;
$ttotal =0;
while ($row = mysqli_fetch_assoc ($query_run)) {
    $tqty += $row['quantity'];
    $ttotal += $row['total_price'];
}
$query="SELECT * FROM `cart` WHERE user_id='".$x."' ";
$query_run = mysqli_query($con,$query);
?>
		<div class="col-lg-12">
			<div class="box-element">
				<a  class="btn btn-outline-dark" href="index.php">Continue Shopping</a>
				<a  style="float:right; margin:5px;" class="btn btn-success checkout" href="action1.php">Checkout</a><br>
				<br>
				<table class="table">
					<tr>
						<th><h5>Items: <?php echo $tqty;?><strong></strong></h5></th>
						<th><h5>Total:<strong>$ <?php echo $ttotal;?> </strong></h5></th>
						<th>
						</th>
					</tr>
				</table>

			</div>
		</div>
		<?php 
		while($row = mysqli_fetch_array($query_run))
		{
		?>
		<div class="col-lg-12">
			<div class="box-element">
				<div class="cart-row">
					<div style="flex:2"></div>
					<div style="flex:2"><strong>Item</strong></div>
					<div style="flex:1"><strong>Price</strong></div>
					<div style="flex:1"><strong>Quantity</strong></div>
					<div style="flex:1"><strong>Total</strong></div>
				</div>
			  <form class="form-submit">
				<div class="cart-row">
					<div style="flex:2"><img class="row-image" src="<?php echo$row['image']; ?>"></div>

                	<input type="hidden" class="pid" value="<?php echo $row['product_id']; ?>">

					<div style="flex:2"><p><?php echo $row['product_name']; ?> </p></div>
					<div style="flex:1" class="pprice"><p>$<?php echo $row['price']; ?></p></div>
					<div style="flex:1">
						<p class="quantity pquantity"><?php echo $row['quantity']; ?></p>
						<div class="quantity">
							<img data-product="<?php echo$row['product_id']?>" class="chg-quantity add-btn" onClick="reloadThePage()" src="images/arrow-up.png">
					
							<img data-product="<?php echo$row['product_id']?>" class="chg-quantity remove-btn" onClick="reloadThePage()" src="images/arrow-down.png">
						</div>
					</div>
					<div style="flex:1"><p>$<?php echo $row['total_price']; ?></p></div>
				</div>
			  </form>
			</div>
		</div>
	
		<?php
    	}
		?><br>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".add-btn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var scale = +1;
      $.ajax({
        url: 'action4.php',
        method: 'post',
        data:{pid: pid,scale:scale,},
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
        }
      });
    });
  });
$(document).ready(function() {
    $(".remove-btn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var scale = -1;
      $.ajax({
        url: 'action4.php',
        method: 'post',
        data:{pid: pid,scale:scale,},
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
        }
      });
    });
  });
function reloadThePage(){
    window.location.reload();
} 
</script>
</html>
