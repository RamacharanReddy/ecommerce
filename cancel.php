<?php

if(isset($_COOKIE['order'])){
    $order_id = $_COOKIE['order'];
    $pid = $_COOKIE['prod'];
    $con = mysqli_connect("localhost","root","","ecommercedb") or die("Unable to connect");

    $query = "UPDATE order_items SET status = 2 WHERE order_id = $order_id and product_id = $pid";
    $query_run = mysqli_query($con,$query);
    if($query_run){
 	echo "$query";
 	echo "<script>
 	location.href = 'dashboard.php';
 	</script>";
}else{
	echo "$query";
}}else{
	echo "Invalid";
}

?>