<?php require 'dbconfig/config.php'; 
session_start();
  if(!isset($_SESSION['id'])){
  	header('location:login.php');
  }

?> 
<html> 
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head> 
  <title>Shopezzy</title>

  <style type="text/css">
@import url(//codepen.io/chrisdothtml/pen/ojLzJK.css);
.button {
  display: block;
  background-color: #c0392b;
  width: 100%;
  height: 40px;
  padding:10px;
  margin: auto;
  color: #fff;
  position: relative;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  cursor: pointer;
  border-radius: 5px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.3);
  -webkit-transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
}
.button span,
.button .icon {
  display: block;
  height: 100%;
  text-align: center;
  position: absolute;
  top: 0;
}
.button span {
  width: 72%;
  line-height: inherit;
  font-size: 10px;
  text-transform: uppercase;
  left: 0;
  -webkit-transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
}
.button span:after {
  content: '';
  background-color: #a53125;
  width: 2px;
  height: 70%;
  position: absolute;

}
.button .icon {
  width: 28%;
  right: 0;
  -webkit-transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4);
}
.button .icon .fa {
  vertical-align: middle;
  -webkit-transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4), height 0.25s ease;
  transition: all 0.25s cubic-bezier(0.31, -0.105, 0.43, 1.4), height 0.25s ease;
}
.button .icon .fa-remove {
  height: 36px;
}
.button .icon .fa-check {
  display: none;
}
.button.success span, .button:hover span {
  left: -72%;
  opacity: 0;
}
.button.success .icon, .button:hover .icon {
  width: 100%;
}
.button.success .icon .fa, .button:hover .icon .fa {
  font-size: 45px;
}
.button.success {
  background-color: #27ae60;
}
.button.success .icon .fa-remove {
  display: none;
}
.button.success .icon .fa-check {
  display: inline-block;
}
.button:hover {
  opacity: .9;
}
.button:hover .icon .fa-remove {
  height: 46px;
}
.button:active {
  opacity: 1;
}
</style>

<?php include 'bootstrap.php'; ?>
<style>

	body{
		background-color: #ebeff5;
	}


	#total-orders{
		background-color: #4cb4c7;
	}


	#orders-delivered{
		background-color: #7abecc;
	}

	#orders-pending{
		background-color: #7CD1C0;
	}

td,th{

	width: 10%;
	text-align: center;
}

.example::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.example {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

</style>
</head>
<?php include 'navbar.php'; ?>
<hr>
<body style="background-color: #fff" class="example">
<div class="row" >
<?php 
$query = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
$query_run = mysqli_query($con,$query);
$row = mysqli_fetch_assoc($query_run);
$x = $row['user_id']
;
$query1="SELECT * FROM `order_items` WHERE user_id=$x ";
$query_run1 = mysqli_query($con,$query1);
$torder=0;
if ($query_run1) {
$torder = mysqli_num_rows($query_run1);
}
$query1="SELECT * FROM `order_items` WHERE user_id=$x AND status=1 ";
$query_run1 = mysqli_query($con,$query1);
$dorder=0;
if ($query_run1) {
$dorder = mysqli_num_rows($query_run1);
}
$query1="SELECT * FROM `order_items` WHERE user_id=$x AND status=0 ";
$query_run1 = mysqli_query($con,$query1);
$porder=0;
if ($query_run1) {
$porder = mysqli_num_rows($query_run1);
}
?>
	<div class="col">
		<div class="col-md">
			<div class="card text-center text-white  mb-3" id="total-orders">
			  	<div class="card-header">
			  		<h5 class="card-title">Total Orders</h5>
			  	</div>
			  	<div class="card-body">
			    	<h3 class="card-title"><?php echo $torder; ?></h3>
			  	</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="col-md">
			<div class="card text-center text-white  mb-3" id="orders-delivered">
			  	<div class="card-header">
			  		<h5 class="card-title">Items Delivered</h5>
			  	</div>
			  	<div class="card-body">
			    	<h3 class="card-title"><?php echo $dorder; ?></h3>
			  	</div>
			</div>
		</div>
	</div>



	<div class="col">
		<div class="col-md">
			<div class="card text-center text-white  mb-3" id="orders-pending">
			  	<div class="card-header">
			  		<h5 class="card-title">Items Pending</h5>
			  	</div>
			  	<div class="card-body">
			    	<h3 class="card-title"><?php echo $porder; ?></h3>
			  	</div>
			</div>
		</div>
	</div>
</div>

<br>
<?php 
	$query2 = "SELECT * FROM `order_items` WHERE user_id=$x ORDER BY `order_items`.`order_id` DESC ";
	$query_run2 = mysqli_query($con,$query2);
	if($query_run2){
?>
<div class="row">
	<div style="margin-left:4%" class="col-md-11">
		<h5 style="text-align: center;">ORDERS</h5>

			<div class="card card-body">
			<table class="table table-sm">
				
				<tr>
					<th>Order id</th>
					<th>Product</th>
					<th>Date Orderd</th>
					<th>Quantity</th>
					<th>Total Price</th>
					<th>Status</th>
					<th>Cancel Order ?</th>
				</tr>
			<?php
				 $old_id = -1;
				while($row = mysqli_fetch_assoc($query_run2)){ 
						
						$pid = $row['product_id'];
						$oid = $row['order_id'];
						$pqtn = $row['quantity'];
						$tprice = $row['total_price'];
						$status = $row['status'];

						$query3 = "SELECT * FROM `product` WHERE product_id=$pid";
					$query_run3 = mysqli_query($con,$query3);
					$row1 = mysqli_fetch_assoc($query_run3);
					$pname = $row1['name'];
					$query4 ="SELECT * FROM `order_table` WHERE order_id = $oid";
					$query_run4 = mysqli_query($con,$query4);
					$row2 = mysqli_fetch_assoc($query_run4);
					$pdate = $row2['date_ordered'];
					$flag = $oid;
						if($status == 0){
							$s = 'Cancel Order';
							$s1 = 'Ordered';
						}
						else if($status == 1){
							$s = 'Download Invoice';
							$s1 = 'Delivered';
						}
						else{
							$s = 'cancelled';
							$s1 = 'Cancelled';
						} 
			?>
			<table class="table table-sm">
				<tr>
					<?php 

					if($flag != $old_id)
					{	$old_id = $flag;
						echo "
						<td>   $oid      </td>";$flag++;}
					else{
						echo " <td>   </td>";
					}
					?>
					<td>    <?php echo $pname ;?>    </td>
					<td>    <?php echo $pdate ;?>    </td>
					<td>    <?php echo $pqtn ;?>     </td>
					<td>  $ <?php echo $tprice ;?>   </td>
					<td>    <?php echo $s1 ;?>       </td>
					<td>
				
						<a class="button disable" name="<?php echo "$status"; ?>" id = "<?php echo $oid;?>" role="button" onclick = "Action(this); " rel = "<?php echo "$pid"?>">
							<span id  = "a"><?php echo "$s"?></span>
							<div class="icon">
								<i class="fa fa-remove"></i>
								<i class="fa fa-check" ></i>
							</div>
						</a>
					</td>

				</tr>
			</table>
		
			</table>
	<?php
	 $flag++;
	}
}
?>

<script type="text/javascript">
(function () {
  var removeSuccess;

  removeSuccess = function () {
    document.getElementById("a").innerHTML = "Removed";
    return $('.button').removeClass('success');
  };

  $(document).ready(function () {
    return $('.button').click(function () {
      $(this).addClass('success');
      document.getElementById("a").innerHTML = "Remove";
      return setTimeout(removeSuccess, 3000);
    });
  });

}).call(this);

function Action(a){
	
	console.log(a.name)
	if(a.name == '1'){
	document.cookie = "order = " + a.id;
	document.cookie = "prod = " + a.rel;
	location.href = 'fpdf/a.php';
	}else if(a.name == '0'){
		document.cookie = "order = " + a.id;
		document.cookie = "prod = " + a.rel;
		location.href = 'cancel.php';
	}
}
</script>

		</div>
	</div>
</div>


</body>
</html>

