<?php 

session_start();
$count = 0;
$myarr = ['phone','laptop','watch','TV','Washing Machiene ', 'Air Conditioners','Refrigerators','Footwear','Clothing','Grooming',
'Clothing','Footwear','Grooming','Home Decor','Furnishing',
'Kitchen','Sports','Fitness','Book'];

require 'dbconfig/config.php'; 
?>
<?php include 'bootstrap.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>
<hr>
<?php include 'navbar1.php'; ?>
<hr>
<div class="container">
<div id="message">

<?php
$mycount = 0;
if(isset($_COOKIE['option'])){
    
    $mytype = $_COOKIE['option'];
    $query="select * from product where category_id  = '$mytype'";
    unset($_COOKIE['option']);
}


  $query_run = mysqli_query($con,$query);
   if(mysqli_num_rows($query_run)>0)
  {
    while($row = mysqli_fetch_array($query_run))
    {
      $mycount++;
      if ($count % 3 == 0)
      {
          echo '<main role="main" style="overflow-x:hidden;">
          <div id="message">
          <div class="container">
        <div class ="row">';
      }
?>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img class="bd-placeholder-img card-img-top" width="auto" height="auto" src="<?php echo $row["image"]; ?>"/>
            <hr>
            <center><h6><strong><center><?php echo $row["name"]; ?></center></strong></h6></center>
            <div class="card-body">
              <p class="card-text"><?php echo $row["desp"]; ?></p>
              <form action="" class="form-submit">
                <input type="hidden" class="pid" value="<?php echo $row['product_id']; ?>">
                <input type="hidden" class="pname" value="<?php echo $row['name']; ?>">
                <input type="hidden" class="pprice" value="<?php echo $row['price']; ?>">
                <input type="hidden" class="pimage" value="<?php echo $row['image']; ?>">
                <input type="hidden" class="pquantity" value="<?php echo $row['quantity']; ?>">

                  <button data-product="<?php echo $row["id"]; ?>" data-action="add" class="btn btn-outline-secondary add-btn">Add to Cart</button>
                  
                  <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="<?php echo '#'.'myModal'.$mycount; ?>">View</button>
              </form>


                  <h4 style="display: inline-block; float: right"><strong>$<?php echo $row["price"]; ?></strong></h4>
                  <!--MODAL-->
                  <div class="modal fade" id="<?php echo "myModal".$mycount; ?>" role="dialog">
                    <div class="modal-dialog modal-xl" >
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title"><?php echo $row["name"]; ?></h4>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                          <img style="width:auto;height:auto;" src="<?php echo $row["image"]; ?>">
                        </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
<?php
          if ($count + 1 % 3 == 0)
          {
            echo '</div> ';
          }
          $count += 1;
    }
  }
  else
  {
    echo "<center><h4>The item you have searched for does not exist <br> You Searched for this - '".$mytype."'</h4><center>"; 
  }
?>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".add-btn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pquantity = $form.find(".pquantity").val();
      var pimage = $form.find(".pimage").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data:{pid: pid,pname: pname,pprice: pprice,pquantity: pquantity,pimage: pimage,},
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
</script>
