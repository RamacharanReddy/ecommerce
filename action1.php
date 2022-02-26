<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
$conn =  new mysqli("localhost", "root", "", "ecommercedb");
include('dbconfig/config.php');
session_start();

$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
$query_run0 = mysqli_query($con,$query0);
$row1 = mysqli_fetch_assoc($query_run0);
$x = $row1['user_id'];

$query =  "SELECT * FROM `cart` WHERE user_id = $x";
$query_run = mysqli_query($con,$query);
if (mysqli_num_rows($query_run)>0) {
	while ($row = mysqli_fetch_assoc($query_run)) {
		$y = $row['product_id'];
		$query1 = "INSERT INTO  order_items (order_item_id, user_id, product_id,status) VALUES ('',$x,$y,'')";
		$query_run1 = mysqli_query($con,$query1) ;
	}
}

header("location:checkout.php")
?>