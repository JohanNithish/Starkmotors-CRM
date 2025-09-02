<?
extract($_REQUEST);
include 'dilg/cnt/join.php';
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');
$ID = $_POST['id'];
if($ID!='') {
$select_customer_type=mysqli_query($conn,"select * from customer where id='$ID' "); 
$row_customer_type=mysqli_fetch_array($select_customer_type);
$customer_type=$row_customer_type['customer_type'];
$mobile=$row_customer_type['mobile'];
?>
<div>
<label for="inputLastName" class="form-label mt-20">Customer Type</label><br>
<p><?=$customer_type;?></p>
<input type="hidden" name="cust_type" id="customer_type" value="<?=$customer_type;?>">
</div>
<div>
<label for="inputLastName" class="form-label mt-20">Mobile</label><br>
<p><?=$mobile;?></p>
</div>
<? } ?>