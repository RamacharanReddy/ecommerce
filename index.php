<?php require 'dbconfig/config.php'; 
session_start();
$count=0;
?> 
<html> 
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head> 
  <title>Shopezzy</title>
<?php include 'bootstrap.php'; ?>
</head>
<?php include 'navbar.php'; ?>
<hr>
<?php include 'navbar1.php'; ?>
<body>
<div>
<?php include 'slider.php'; ?>
</div>
<?php
$mycount = 0;
$query="select * from product";
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
?>
</main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#" style="color: black">Back to top</a>
    </p>
  </div>
</footer>
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script> 
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
        }
      });
    });
  });
</script>
</body>
</html> 
  