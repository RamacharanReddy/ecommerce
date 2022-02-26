<?php
require('fpdf.php');


if(isset($_COOKIE['order'])){
    $order_id = $_COOKIE['order'];
    $pid = $_COOKIE['prod'];
    $con = mysqli_connect("localhost","root","","ecommercedb") or die("Unable to connect");

$query = "SELECT * FROM  order_table WHERE order_id = $order_id";
$query_run = mysqli_query($con,$query);
if($query_run){
    $result = mysqli_fetch_assoc($query_run);
    $shipping_id = $result['shipping_id'];
    $transaction_id = $result['transaction_id'];
    $date = $result['date_ordered'];

$query1 = "SELECT * FROM  payment WHERE transaction_id = $transaction_id";
$query_run1 = mysqli_query($con,$query1);
if($query_run1){
    $result1    = mysqli_fetch_assoc($query_run1);
    $user_id   = $result1['user_id'];
    $card_name = $result1['card_name'];
    $card_no   = $result1['card_no'];

$query2 = "SELECT * FROM  shipping_address WHERE shipping_id = $shipping_id";

$query_run2 = mysqli_query($con,$query2);

if($query_run2){
    $result2    = mysqli_fetch_assoc($query_run2);
    $addr    = $result2['address'];
    $city    = $result2['city'];
    $state   = $result2['state'];
    $zip     = $result2['zipcode'];
    $country = $result2['country'];


class PDF extends FPDF{
// Page header
    function Header(){
        // Logo
        $this->Image('logo1.png',10,6,30);
    // Arial bold 15
        $this->SetFont('Arial','B',15);
        $this ->Ln(40);
            // Move to the right
        $this->Cell(80);
    // Title
        $this->Cell(30,10,'Invoice/ Reciept',0,0,'C');
     // Line break
    }

    // Page footer
    function Footer()
    {

        $this->SetY(-15);

        $this->SetFont('Arial','I',8);
                $this->Cell(0,10,'This is a computer generated invoice and dosent reqire the need for any physical signature Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
    $pdf->Ln(20);
        $pdf->Cell(30,5,"Ordered by : ".$user_id,0,1,'L');
        $pdf->Cell(30,5,"Order id : ".$order_id,0,1,'L');
        $pdf->Cell(30,5,"Ordered on : ".$date,0,1,'L');
        $pdf->Cell(30,5,"Address Details : ",0,1,'L');
        
        $pdf->Cell(30,5,$addr,0,1,'L');
        
        $pdf->Cell(30,5,$city,0,1,'L');
        
        $pdf->Cell(30,5,$state,0,1,'L');
        $pdf->Cell(30,5,$zip,0,1,'L');
        $pdf->Cell(30,5,$country,0,1,'L');
        $pdf->Ln(20);
        $pdf->Cell(80);
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(30,5,"Reciept Details ",0,1,'C');
        $pdf ->Ln();
        $pdf->Ln();
        $pdf->SetFont('Times','',12);
        $pdf->Cell(20);
        $pdf->Cell(10,5,"S No",1,0,'R');
        $pdf->Cell(80,5,"Name",1,0,'R');
        $pdf->Cell(20,5,"Price",1,0,'R');
        $pdf->Cell(30,5,"Quantity",1,0,'R');
        $pdf->Cell(20,5,"Total Price",1,0,'R');
        $i = 0;
        $query3 = "SELECT * FROM  order_items WHERE order_id = $order_id and product_id = $pid";

        $query_run3 = mysqli_query($con,$query3);
        while ($row = mysqli_fetch_assoc($query_run3)) {
        	$i++;
            $pid = $row['product_id'];
            $total = $row['total_price'];
            $qty = $row['quantity'];
            $price = $row['price'];
            $query4 = "SELECT * FROM  product WHERE product_id = $pid";
            $query_run4 = mysqli_query($con,$query4);
            $result4    = mysqli_fetch_assoc($query_run4);
            $pname    = $result4['name'];
            $pdesc   = $result4['desp'];
            $pdf->Ln();
            $pdf->Cell(20);
        $pdf->Cell(10,5,$i,1,0,'R');
        $pdf->Cell(80,5,$pname,1,0,'R');
        $pdf->Cell(20,5,$price,1,0,'R');
        $pdf->Cell(30,5,$qty,1,0,'R');
        $pdf->Cell(20,5,$total,1,0,'R');
    }
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Output();
        $pdf = new PDF();
    }else{
        echo "$query_2";
    }
}

else{
    echo "$query";
}
}else{
    echo "$query";
}}else{
    echo "Invaid";
}
