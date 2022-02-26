<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
include('dbconfig/config.php');
session_start();

$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
$query_run0 = mysqli_query($con,$query0);
$row1 = mysqli_fetch_assoc($query_run0);
$x = $row1['user_id'];
// Add products into the cart table
if (isset($_POST['pid'])) {
	$pid = $_POST['pid'];
	$scale = $_POST['scale'];
	$query2 = "SELECT * FROM cart WHERE user_id = $x AND product_id=$pid";
}
	$query_run2 = mysqli_query($con,$query2);
	$row = mysqli_fetch_assoc($query_run2);
	$my_qty = $row['quantity'];
	$my_price = $row['price'];
	$new_qty = $my_qty + $scale;
	$new_price = $my_price * $new_qty;

	$query="update cart set quantity = $new_qty where product_id = $pid and user_id=$x";
	$query_run = mysqli_query($con,$query);
	$query="update cart set total_price = $new_price where product_id = $pid and user_id=$x" ;	
	$query_run = mysqli_query($con,$query);
	if($new_qty == 0){
		$query="delete from cart where product_id = $pid and user_id=$x";
		$query_run = mysqli_query($con,$query);
		echo "<script>
			location.href = 'cart.php'
		</script>";		
	}
?>
