<?php
  session_start();
  require 'dbconfig/config.php';
  if(!isset($_SESSION['id'])){
    header('location:login.php');
  }
?>
<html>
  <head>
    <title>Payment page</title>
<?php include 'bootstrap.php'; ?>
<style type="text/css">
.box-element{
  box-shadow:hsl(0, 0%, 80%) 0 0 16px;
  background-color: #fff;
  border-radius: 4px;
  padding: 10px;
}
</style>
</head>
<?php include 'navbar.php'; ?><hr>
 <body>
  <div class="container"><br>    
    <div class="box-element" id="form-wrapper">
      <h4><center>Payment Method</center></h4>
      <div class="d-block my-3">
        <div class="custom-control custom-radio">
          <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
          <label class="custom-control-label" for="credit">Credit card</label>
        </div>
        <div class="custom-control custom-radio">
          <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
          <label class="custom-control-label" for="debit">Debit card</label>
        </div>
      </div>
      <form action="action3.php" method="post">
        <div class="row">
          <div class="col-md-4">
            <label><B>Name on card</B></label>
            <input type="text" class="form-control" name="name" required/>
            <small class="text-muted">Full name as displayed on card</small>
          </div>
          <div class="col-md-4 mb-3">
            <label for="cc-number"><B>Credit card number</B></label>
            <input type="text" class="form-control" name="no" id="cc-number" placeholder="" required>
            <div class="invalid-feedback">
              Credit card number is required
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <label for="cc-expiration"><B>Expiration</B></label>
            <input type="text" class="form-control" name="expiry" required>
          </div>
          <div class="col-md-1">
            <label for="cc-cvv"><B>CVV</B></label>
            <input type="password" class="form-control" name="cvv" required>
          </div>
        </div>
        <hr>
        <button class="btn btn-success btn-lg " type="submit">Make Payment</button>
      </form>
    </div>
  </div>
</body>
</html>
