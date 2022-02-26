<?php
	$conn =  new mysqli("localhost", "root", "", "ecommercedb");	
	require ('dbconfig/config.php');
	session_start();
	
//Get user data
	$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
	$query_run0 = mysqli_query($con,$query0);
	$row1 = mysqli_fetch_assoc($query_run0);

//get payment data
	$x = $row1['user_id'];
	$name = '';
	$no = '';
	$expiry = '';
	$cvv = '';
	
	if( isset( $_POST['name'])) {
    	$name = $_POST['name']; 
	} 
	
	if( isset( $_POST['no'])) {
    	$no = $_POST['no'];
	}

	if( isset( $_POST['expiry'])) {
	    $expiry = $_POST['expiry']; 
	} 

	if( isset( $_POST['cvv'])) {
    	$cvv = $_POST['cvv'];
	} 
 

	//Insert payment details into db
	$query = "INSERT INTO payment (transaction_id,user_id,card_name,card_no,expiry,cvv) VALUES ('',$x,'$name','$no','$expiry',$cvv)";
	$query_run = mysqli_query($con,$query);

	// Get items in the users cart 
	$query1 =  "SELECT * FROM `cart` WHERE user_id = $x";
	$query_run1 = mysqli_query($con,$query1);
	if (mysqli_num_rows($query_run1)>0){
		$query_0 = "SELECT * FROM `shipping_address` WHERE 1";
		$query_run_0 = mysqli_query($con,$query_0);
		if($query_run_0){
			while ($row = mysqli_fetch_assoc($query_run_0)) {
				$sid = $row['shipping_id'];
			}
		}
		$query_1 = "SELECT * FROM payment";
		$query_run_1 = mysqli_query($con,$query_1);
		if($query_run_1){

			while ($row = mysqli_fetch_assoc($query_run_1)) {
				$transaction_id = $row['transaction_id'];
			}
		}
		$date = date('Y/m/d H:i:s');
		$query2 =  "INSERT INTO `order_table`(`order_id`,`shipping_id`,`transaction_id`,`date_ordered`) VALUES ('',$sid,$transaction_id,'$date')";
		$query_run2 = mysqli_query($con,$query2);
		echo $query2."<br>";
		//Get order id from order table
		if($query_run2){
			$query3 =  "SELECT * FROM `order_table` WHERE date_ordered = '$date'";
			$query_run3 = mysqli_query($con,$query3);
			echo $query3."<br>";
			if($query_run3){
				while ($row = mysqli_fetch_assoc($query_run3)) {
					$z = $row['order_id'];
				}
				//Order id generated and stored	
				$old_data = array();
				$count = 0;$count1=0;
				//store item in the cart as an array
				while ($row = mysqli_fetch_assoc($query_run1)) {
					$y = $row['product_id'];
					$qtn = $row['quantity'];
					$price = $row['price'];
					$tprice = $row['total_price'];
					$newdata =  array (
      					'user_id' => $row['user_id'],
      					'product_id' => $row['product_id'],
      					'product_name' => $row['product_name'],
      					'quantity' => $row['quantity'],
      					'price' => $row['price'],
      					'total_price'=> $row['total_price'],
      					'image' => $row['image']
    				); 
					$stockquery = "SELECT stock FROM product WHERE product_id = $y";
					$query_run_s = mysqli_query($con,$stockquery);
					while ($srow = mysqli_fetch_assoc($query_run_s))
					{
					$stock = $srow['stock'];
				}
					
					$old_data[$count][] = $newdata;
					$count++;
			
			
					// Insert into final table (order items)
					$query4 = "INSERT INTO  order_items (order_id,user_id, product_id,quantity,price,total_price) VALUES ($z,$x,$y,$qtn,$price,$tprice)";
					$query_run4 = mysqli_query($con,$query4) ;
				
				

				if($stock + 1  > $qtn){
					$newqtn = $stock - $qtn;
					$query91 =  "UPDATE `product` SET `stock`= $newqtn WHERE `product_id` = $y ";
					echo $query91;
					$query_run91 = mysqli_query($con,$query91);

				}
				else{
					$myarr[$count1][] = $newdata;
					echo "Unable to order the particular item -- Out of Stock ";
					$flag = 1;
					echo "<br>";
					$count1++;
				}
			}


		}
			



			//Delete all the items from cart 
			$query5 =  "DELETE FROM `cart` WHERE user_id = $x";
			$query_run5 = mysqli_query($con,$query5);

			
			if($query_run5){
				echo "Items ordered , your order_id is ".$z."<br>";
				setcookie('reciept', $z, time() + 300, "/");
				echo "<script>window.open('http://localhost/ecommerce/fpdf/reciept.php');</script>";
				echo "<script>window.open('http://localhost/ecommerce/');</script>";
				echo "<script>window.close();</script>";

			}

			else{
				$query_run5 = mysqli_query($con,$query6);
				for ($i=0; $i < $count ; $i++) { 
					$mydata = $old_data[$i];
						foreach ($mydata as $key => $value) {
							$arr = [];
							foreach ($value as $key => $sub) {
								array_push($arr,$sub);
							}
						}

      				$query6 = "INSERT INTO cart (user_id,product_id,product_name,quantity,price,total_price,image) VALUES($arr[0], $arr[1], '$arr[2]', $arr[3], $arr[4],$arr[5],'$arr[6]')";

      				echo $query6."<br>";
      				$query_run6 = mysqli_query($con,$query6);
      			}	
      		}

      		if($flag = 1){
				for ($i=0; $i < $count1 ; $i++) { 
					$mydata = $myarr[$i];
						foreach ($mydata as $key => $value) {
							$arr = [];
							foreach ($value as $key => $sub) {
								array_push($arr,$sub);
								echo $key,$sub;
							}
						}

      				$query6 = "INSERT INTO cart (user_id,product_id,product_name,quantity,price,total_price,image) VALUES($arr[0], $arr[1], '$arr[2]', $arr[3], $arr[4],$arr[5],'$arr[6]')";

      				echo $query6."<br>";
      				$query_run6 = mysqli_query($con,$query6);
      				$query_23 = "DELETE FROM order_items WHERE user_id = 2 and product_id = $arr[1] and order_id = $z";
      				$query_run23 = mysqli_query($con,$query_23);
      			}
      			
      		}
		}
	}
	$my_stop_time = rand(10,10000);
?>