<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
$conn =  new mysqli("localhost", "root", "", "ecommercedb");
include('dbconfig/config.php');
session_start();

if(isset($_SESSION['id'])){
	$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
	$query_run0 = mysqli_query($con,$query0);
	$row1 = mysqli_fetch_assoc($query_run0);
	$x = $row1['user_id'];
// Add products into the cart table
if (isset($_POST['pid'])) {
	$pid = $_POST['pid'];
	$pname = $_POST['pname'];
	$pprice = $_POST['pprice'];
	$pquantity = 1;
	$total_price = $pprice * $pquantity;
	$pimage = $_POST['pimage'];
	$query =  "SELECT product_id FROM cart WHERE product_id=? AND user_id=$x";
}
$stmt = $conn->stmt_init();

if(!$stmt->prepare($query))
{
	print "Failed to prepare statement\n";
}

$stmt->bind_param("i", $pid);
$stmt->execute();
$res = $stmt->get_result();
$r = $res->fetch_assoc();
$code = $r['product_id'] ?? '';
$stmt->close();
if (!$code) {
	$query1 = "INSERT INTO cart (user_id,product_id,product_name,quantity,price,total_price,image) VALUES (?,?,?,?,?,?,?)";

	if ($stmt1 = $conn->prepare($query1)) {
		$q= 0;
	}
	else {
     	echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	if (!$stmt1->bind_param("iisiiis",$x,$pid,$pname,$pquantity,$pprice,$total_price,$pimage)) {
    	echo "Binding parameters failed: (" . $stmt1->errno . ") " . $stmt->error;
	}

	if (!$stmt1->execute()) {
    echo "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error;
	echo '<div class="alert alert-danger alert-dismissible mt-2">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Some random error try again later</strong>
		</div>';
	}

	else{ 	
		echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item added to your cart!</strong>
			  </div>';
		echo "<script>
			location.reload();
		</script>";
	}
		$stmt1->close();
}

else{
	echo '<div class="alert alert-success alert-dismissible mt-2">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Item Quantity Increased!!</strong>
	  </div>';
	echo "<script>
			location.reload();
		</script>";
	$query2 = "SELECT * FROM cart WHERE user_id = $x AND product_id=$pid";
	$query_run2 = mysqli_query($con,$query2);
	$row = mysqli_fetch_assoc($query_run2);
	$my_qty = $row['quantity'];
	$my_price = $row['price'];
	$new_qty = $my_qty + 1;
	$new_price = $my_price * $new_qty;

	$query="update cart set quantity = $new_qty where product_id = $pid and user_id=$x";
	$query_run = mysqli_query($con,$query);
	$query="update cart set total_price = $new_price where product_id = $pid and user_id=$x" ;
	$query_run = mysqli_query($con,$query);
	if($new_qty == 0){
	$query="delete from cart where product_id = $pid and user_id=$x";
	$query_run = mysqli_query($con,$query);		

	}
}
}
else{
	echo 'You must be logged in to use this function';
}

?>
