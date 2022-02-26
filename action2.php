<?php
$conn =  new mysqli("localhost", "root", "", "ecommercedb");	
require ('dbconfig/config.php');
session_start();


$query0 = "SELECT `user_id` FROM `user` WHERE email='".$_SESSION['id']."' ";
$query_run0 = mysqli_query($con,$query0);
$row1 = mysqli_fetch_assoc($query_run0);
$x = $row1['user_id'];

$address = '';
$city = '';
$state = '';
$zipcode = '';
$country = ''; 
if( isset( $_POST['address'])) {
    $address = $_POST['address']; 

} 
if( isset( $_POST['city'])) {
    $city = $_POST['city'];

} 
if( isset( $_POST['state'])) {
    $state = $_POST['state']; 
} 
if( isset( $_POST['zipcode'])) {
    $zipcode = $_POST['zipcode'];
} 
if( isset( $_POST['country'])) {
    $country = $_POST['country']; 
} 

$query = "INSERT INTO shipping_address(user_id,address,city,state,zipcode,country) VALUES ($x,'$address','$city','$state',$zipcode,'$country')";

$query_run = mysqli_query($con,$query);

header("location:payment.php")
?>
