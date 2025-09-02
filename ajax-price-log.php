<?
extract($_REQUEST);
include 'dilg/cnt/join.php';
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
session_start();
$quotation_id = $_POST['id'];
$product_name = $_POST['product_name'];
$type = $_POST['type'];
$table_type = $_POST['table_type'];
$new_value = $_POST['new_value'];
$total_amount = $_POST['total_value']; 
$category = $_POST['category']; 

if($table_type =='1'){
if($type=='package'){
$type='package_percent';
}
$sel_values=mysqli_query($conn,"select $type from quotation_product where quotation_id = '$quotation_id' and product_name='$product_name' "); 
$row_values=mysqli_fetch_array($sel_values);
$old_value=$row_values[0];
$type = $_POST['type'];
}else{
	$sel_values=mysqli_query($conn,"select * from price_log where quotation_id = '$quotation_id' and product_name='$product_name' and type='$type' and id=(select max(id) from price_log where quotation_id = '$quotation_id' and product_name='$product_name' and type='$type')  "); 
	$row_values=mysqli_fetch_array($sel_values);
	$old_value=$row_values['new_value'];
}


if($product_name !=''){
$insert_log=mysqli_query($conn,"insert into price_log set quotation_id = '$quotation_id', category = '$category', product_name = '$product_name', type = '$type',old_value = '$old_value', new_value='$new_value', total_amount='$total_amount',  created_date = '$currentDate', created_time = '$currentTime', created_by='".$_SESSION['UID']."' ");
}
