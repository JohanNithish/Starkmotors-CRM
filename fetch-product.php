<?
extract($_REQUEST);
include 'dilg/cnt/join.php';
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');
$ID = $_POST['id'];
$Value = $_POST['value'];
$Customer_id = $_POST['customer_id'];
if ($Value==''){
	$text_val="Enter Motor Serial Number";
}else{
	$text_val="Invalid Motor Serial Number";
}
$select_product=mysqli_query($conn,"select * from dispatch where FIND_IN_SET('$Value', REPLACE(motor_num, '~', ',')) and customer_id='$Customer_id' "); 
if(mysqli_num_rows($select_product) >>0) {
$row_product=mysqli_fetch_array($select_product);
$dispatch_id=$row_product['id'];
$product_name=$row_product['product_name'];
$invoice_num=$row_product['document_num'];
?>
<script type="text/javascript">
$("#product_name<?=$ID;?>").val('<?=$product_name;?>');
$("#dispatch_id<?=$ID;?>").val('<?=$dispatch_id;?>');
$("#invoice_num<?=$ID;?>").val('<?=$invoice_num;?>');
</script>
<?  } else{?>
<script type="text/javascript">
$("#product_name<?=$ID;?>").val('');
$("#dispatch_id<?=$ID;?>").val('');
$("#invoice_num<?=$ID;?>").val('');
</script>
<?  } ?>