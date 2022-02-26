<?php require 'dbconfig/config.php'; 
session_start();
?> 
<!DOCTYPE html>
<html>
<head>
<title>Add Products</title>
<link rel="stylesheet" href="css/product.css">

<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("imglink").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
</head>
<body style="background-color:#bdc3c7">
<form class="myform" action="product.php"method="post" enctype="multipart/form-data" >
	<div id="main-wrapper">
		<center>
			<h2>Registration Form</h2>
			<img class="logo" src="images/logo1.png"/><br>
		</center>
			<label><b>CategoryId:</b></label><br>
			<input name="category_id" type="text" class="inputvalues" placeholder="Type Product CategoryId" required/><br>	
			<label><b>Name:</b></label><br>
			<input name="name" type="text" class="inputvalues" placeholder="Type Product Name" required/><br>
			<label><b>Price:</b></label><br>
			<input name="price" type="text" class="inputvalues" placeholder="Enter MRP" required/><br>
			<label><b>Image:</b></label><br>
			<input type="file" id="imglink" name="imglink" accept=".jpg,.jpeg,.png,.webp" onchange="PreviewImage();"/><br>
			<label><b>Description:</b></label><br>
			<input name="desp" type="text" class="inputvalues" placeholder="Enter Description" required/><br>
			<input name="submit_btn" type="submit" id="signup_btn" value="Add Product"/><br>
			<a href="index.php"><input type="button" id="back_btn" value="Back"/></a>
	</div>
</form>
	<?php
			if(isset($_POST['submit_btn']))
			{
				
				$category_id =$_POST['category_id'];
				$name = $_POST['name'];
				$price = $_POST['price'];
				
				$img_name = $_FILES['imglink']['name'];
				$img_size =$_FILES['imglink']['size'];
			    $img_tmp =$_FILES['imglink']['tmp_name'];
				
				$directory = 'productimg/';
				$target_file = $directory.$img_name;
				$desp = $_POST['desp'];
				$status = 1;
				
				$query0= "select * from product WHERE name='$name'";
				$query_run0 = mysqli_query($con,$query0);
					
				if(mysqli_num_rows($query_run0)>0)
				{
						// there is already a user with the same username
					echo '<script type="text/javascript"> alert("Product already exists.. try another Product") </script>';
				}
				else if(file_exists($target_file))
				{
					echo '<script type="text/javascript"> alert("Image file already exists.. Try another image file") </script>';
				}
					
				else if($img_size>10000000)
				{
					echo '<script type="text/javascript"> alert("Image file size larger than 10 MB.. Try another image file") </script>';
				}
					
				else
				{
					move_uploaded_file($img_tmp,$target_file); 	
					$query1 = "insert into product values('','$category_id','$name','$price','$target_file','$desp','$status','')";
					$query_run1 = mysqli_query($con,$query1);
						
					if($query_run1)
					{
						echo '<script type="text/javascript"> alert("Product Added......")</script>';
					}
					else
					{
						echo '<script type="text/javascript"> alert("Error!") </script>';
					}
				}	
			}
	?>
</body>
</html>