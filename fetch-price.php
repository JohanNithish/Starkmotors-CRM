<?
extract($_REQUEST);
include 'dilg/cnt/join.php';
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');

$ID = $_POST['id'];
$Row_id = $_POST['row_id'];
$customer_type = $_POST['customer_type'];
$custm_type=strtolower($customer_type);

if($ID !='' && $Row_id>>0) {
$select_price=mysqli_query($conn,"select * from product where product='$ID' and status='1' "); 
$row_price=mysqli_fetch_array($select_price);
echo $product=$row_price[$custm_type];
}

?>