<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$DATE = date('Y-m-d');
$TIME = date('H:i:s');
if($Submit=='Add to Services')
{

if(empty(array_filter($product_name))){
  $Num_product=0;
}else{
  $Num_product=count($product_name);
}
	if($Num_product>>0){
$select_customer=mysqli_query($conn,"select * from customer where id='$customer' "); 
$Row_customer=mysqli_fetch_array($select_customer);
$company_name = $Row_customer['company_name'];
$customer_name = $Row_customer['customer_name'];
$customer_type = $Row_customer['customer_type'];
$mobile = $Row_customer['mobile'];
$motor_num=$_POST['motor_num'];
$products_count=count($motor_num);
$status='In';
$insert_product=mysqli_query($conn,"insert into service set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', mobile='$mobile', service_date='$service_date', customer_type='$customer_type',  products_count='$products_count', status='$status', created_by=".$_SESSION['UID'].", created_datetime = '$currentTime'");

$service_id = $conn->insert_id;
$tot_count = 0;
for($i=0; $i<=$products_count; $i++)
{
$tot_count=$tot_count+1;
$Warranty=$_POST['warranty'.$tot_count];
if($product_name[$i] !='')
{ 
$rs_InsValues=mysqli_query($conn,"insert into service_product set service_id='$service_id', dispatch_id='$dispatch_id[$i]', product_name='$product_name[$i]', motor_num='$motor_num[$i]', estimated_date='$estimated_date[$i]', invoice_num='$invoice_num[$i]', warranty='$Warranty', status='Not Delivered', remarks='$remarks[$i]', created_datetime = '$currentTime' ");
}
}

if($insert_product && $rs_InsValues)
{
$msg = 'Services Added Successfully';
header('Location:list-services.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';     
}
}else{
$alert_msg = 'Add atleast one product or check the motor serial number!!!';    	
}
}


if($Submit=='Update Services')
{
if(empty(array_filter($product_name))){
  $Num_product=0;
}else{
  $Num_product=count($product_name);
}
	if($Num_product>>0){
$select_customer=mysqli_query($conn,"select * from customer where id='$customer' "); 
$Row_customer=mysqli_fetch_array($select_customer);
$company_name = $Row_customer['company_name'];
$customer_name = $Row_customer['customer_name'];
$customer_type = $Row_customer['customer_type'];
$mobile = $Row_customer['mobile'];
$motor_num=$_POST['motor_num'];
$products_count=count($motor_num);
$status='In';
$update_product=mysqli_query($conn,"update service set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', mobile='$mobile', service_date='$service_date', customer_type='$customer_type',  products_count='$products_count', modified_datetime = '$currentTime' where id='$ID' ");
$service_ProductDelete = mysqli_query($conn,"delete from service_product where service_id ='$ID' ");

$tot_count = 0;
for($i=0; $i<=$products_count; $i++)
{
$tot_count=$tot_count+1;
$Warranty=$_POST['warranty'.$tot_count];
if($product_name[$i] !='')
{ 
$rs_InsValues=mysqli_query($conn,"insert into service_product set service_id='$ID', dispatch_id='$dispatch_id[$i]', product_name='$product_name[$i]', motor_num='$motor_num[$i]', estimated_date='$estimated_date[$i]', invoice_num='$invoice_num[$i]', warranty='$Warranty', status='Not Delivered', remarks='$remarks[$i]', created_datetime = '$currentTime' ");
}
}

if($update_product && $rs_InsValues)
{
$msg = 'Services Updated Successfully';
header('Location:list-services.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';     
}
}else{
$alert_msg = 'Add atleast one product or check the motor serial no.!!!';    	
}
}
if($ID!=''){
$sel_values=mysqli_query($conn,"select * from service where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
$customer_id=$row_values['customer_id'];
$mobile=$row_values['mobile'];
$customer_type=$row_values['customer_type'];
$service_date=$row_values['service_date'];
$service_num=$row_values['service_num'];
$CountQtn = mysqli_num_rows($sel_values); 
}else{
$service_date=$DATE;

}

?>

<body >
<form action="#" method="post" enctype="multipart/form-data" name="form1">
<div class="row form-label">
<? if($msg !=''){ ?><div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
<div class="d-flex align-items-center">
<div class="font-35 text-white"><i class="bx bxs-check-circle"></i>
</div>
<div class="ms-3">
<h6 class="mb-0 text-white">Successfully</h6>
<div class="text-white"><?=$msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>
<? if($alert_msg !=''){ ?> <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
<div class="d-flex align-items-center">
<div class="font-35 text-white"><i class="bx bxs-message-square-x"></i>
</div>
<div class="ms-3">
<h6 class="mb-0 text-white">Error</h6>
<div class="text-white"><?=$alert_msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>
</div>
<div class="row justify-content-center">
<div class="col-xl-12">
<div class="card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<div class="card-body p-5">
<div class="d-flex justify-space-between align-items-center">
<h5 class="text-uppercase mb-0"><?if($CountQtn>>0){ echo"Update";}else{echo "Add";}?> Services</span></h5>
<?if($CountQtn>>0){?> <a href="list-services.php" class="btn btn-danger">Back</a><?}?> 
</div>
<hr>
<div class="card-title row align-items-center">

<div class="col-xl-6" >
<label for="inputLastName" class="form-label mt-20">Select Company / Customer</label>
<select class="single-select" multiple="multiple" name="customer" onchange="getCustomer(this.value)" id="customer_id" required>
<option value="">Select Customer</option>
<? 
$sql_customer=mysqli_query($conn,"select * from order_confirmation  GROUP BY customer_id asc ORDER BY customer_name asc"); 
while($row_customer=mysqli_fetch_array($sql_customer))
{
?>
<option value="<?=$row_customer['customer_id']?>" <? if($row_customer['customer_id'] == $customer_id) { ?>selected<? } ?> ><?if($row_customer['company_name']!='')echo $row_customer['company_name'].' / ';?><?=$row_customer['customer_name'];?> (<?=$row_customer['mobile'];?>)</option>
<?
}
?>
</select>
</div>
<div class="col-xl-4 d-flex gap-5" id="output">


<?if($CountQtn>>0){
?>
<div>
<label for="inputLastName" class="form-label mt-20">Customer Type</label><br>
<p id="customer_type"><?=$customer_type;?></p>
</div>
<div>
<label for="inputLastName" class="form-label mt-20">Mobile</label><br>
<p><?=$mobile;?></p>
</div>
<?}?>
</div>
<div class="col-lg-2 mt-3">
</div>
<div class="col-lg-2 mt-3 <? if($ID==''){ echo " d-n";} ?>" id="service_date">

<label for="inputLastName" class="form-label mt-20">Service Date</label>
<input type="date" name="service_date" class="form-control" value="<?=$service_date;?>">	

</div>

</div>
<div id="productSection" class=" mt-4 mb-3 " <?if($CountQtn==0){echo'style="display: none;"';} ?>>
<div class="bg-3f663a text-center rounded-1">
<h5 class="text-white py-1">Add Product</h5>
</div>
<div class="px-2" id="Regular" >
<div id="frm_scents">
<? if($ID =='') { ?>
<div class="row g-2 mt-1 mb-2">
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Motor Serial No</label>
</div>
<div class="w-20">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Product Name</label>

</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Invoice Number</label>

</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Warranty</label>
</div>

<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Est. Deliv. Date</label>
</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Remarks</label>
</div>


<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0 fw-500 ">Action</label>
</div>
</div>

<div class="row my-1" id="p_scents">

<div class="w-15">
  <input type="text" class="form-control value-null" name="motor_num[]"  id="motor_num1"  onchange="getProduct(1, this.value)" placeholder="Motor Serial No" required>
</div>
<div class="w-20">
<input type="text" name="product_name[]" id="product_name1" class="form-control value-null" placeholder="
Product Name" value="" required>
<input type="text" class="value-null input-hidden" id="dispatch_id1" name="dispatch_id[]"  value="" >
</div>
<div class="w-15">
<input class="form-control value-null" type="text"name="invoice_num[]" id="invoice_num1" placeholder="Invoice Number"  value="" required="">
</div>
<div class="w-15">

<div class="form-check form-check-inline">
<input class="form-check-input ckeck-new" type="radio" name="warranty1" id="inlineRadio1-1" value="Yes" checked required>
<label class="form-check-label" for="inlineRadio1-1">Yes</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="warranty1" id="inlineRadio2-1" value="No" required>
<label class="form-check-label" for="inlineRadio2-1">No</label>
</div>

</div>
<div class="w-15">
  <input type="date" class="form-control p-qnt value-null" name="estimated_date[]"  id="estimated_date1" required>
</div>
<div class="w-15">
<textarea class="form-control value-null" rows="1" id="remarks1" name="remarks[]" placeholder="Remarks"></textarea>
</div>

<div class="w-5 text-end">
<a type="button" id="addScnt" tooltip="Add Product" class="pe-1"  style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a>

</div>
</div>
<? } else { ?>
<div class="row g-2 mt-1 mb-2">
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Motor Serial No</label>
</div>
<div class="w-20">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Product Name</label>

</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Invoice Number</label>

</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Warranty</label>
</div>

<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Est. Deliv. Date</label>
</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Remarks</label>
</div>


<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0 fw-500 ">Action</label>
</div>
</div>

<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from service_product where service_id = '$ID' and status='Not Delivered' "); 
while($row_product=mysqli_fetch_array($sel_product))
{ 
$SNo = $SNo + 1; 
$dispatch_id=$row_product['dispatch_id'];
$product_name=$row_product['product_name'];
$brand_name=$row_product['brand_name'];
$motor_num=$row_product['motor_num'];
$invoice_num=$row_product['invoice_num'];
$warranty=$row_product['warranty'];
$estimated_date=$row_product['estimated_date'];
$remarks=$row_product['remarks'];
?>

<div class="row my-1" id="p_scents">

<div class="w-15">
  <input type="text" class="form-control value-null" name="motor_num[]"  id="motor_num<?=$SNo;?>"  onchange="getProduct(<?=$SNo;?>, this.value)" value="<?=$motor_num;?>" placeholder="Motor Serial No" required>
</div>
<div class="w-20">
	<input type="text" class="value-null form-control" value="<?=$product_name;?>" id="product_name<?=$SNo;?>" placeholder="
Product Name" name="product_name[]" required>
<input type="text" class="value-null input-hidden" value="<?=$dispatch_id;?>" id="dispatch_id<?=$SNo;?>" name="dispatch_id[]">


</div>
<div class="w-15">
	<input type="text" class="value-null form-control" name="invoice_num[]" placeholder="Invoice Number" id="invoice_num<?=$SNo;?>" value="<?=$invoice_num;?>"  required >
</div>
<div class="w-15">

<div class="form-check form-check-inline">
<input class="form-check-input ckeck-new" type="radio" name="warranty<?=$SNo;?>" id="inlineRadio1-<?=$SNo;?>" value="Yes" <? if($warranty=="Yes"){echo "checked ";}?> required>
<label class="form-check-label" for="inlineRadio1-<?=$SNo;?>">Yes</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="warranty<?=$SNo;?>" id="inlineRadio2-<?=$SNo;?>" value="No" <? if($warranty=="No"){echo "checked ";}?> required>
<label class="form-check-label" for="inlineRadio2-<?=$SNo;?>">No</label>
</div>

</div>
<div class="w-15">
  <input type="date" class="form-control p-qnt value-null" name="estimated_date[]"  id="estimated_date<?=$SNo;?>" value="<?=$estimated_date;?>" required>
</div>
<div class="w-15">
<textarea class="form-control value-null" rows="1" id="remarks<?=$SNo;?>" name="remarks[]" placeholder="Remarks"><?=$remarks;?></textarea>
</div>

<? if($SNo == 1){ ?>
<div class="w-5 text-end">
<a type="button" id="addScnt" class="pe-1" tooltip="Add Product" style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a></div>
<?} else { ?>
<div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product"  style="width: auto" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div>
<? } ?>

</div>


<? } ?>
<? } ?>
</div>

</div>
<div class="col-12 mt-3">
<input type="submit" name="Submit" id="submitButton" class="btn btn-primary px-3" value="<? if($CountQtn >> 0) {   echo  "Update Services"; } else echo "Add to Services";?>" >
</div> 

</div>
</div> </div></div></div></div></div>
</form>
</div></div>
<div id="output_product"></div>
<script src="assets/js/addmore.js"></script>
<script>
var scntDiv = $("#frm_scents");
var i = $("[id=p_scents]").length + 1;

$(function() {
$("#addScnt").click(function() {
$('<div class="row my-1 slide_show" id="p_scents" style="display:none"><div class="w-15"><input type="text" class="form-control value-null" name="motor_num[]" id="motor_num'+i+'"  onchange="getProduct('+i+', this.value)" placeholder="Motor Serial No" required></div><div class="w-20"><input type="text" name="product_name[]" placeholder="Product Name" id="product_name'+i+'" class="value-null form-control"  value="" required><input type="text" class="value-null input-hidden" id="dispatch_id'+i+'" name="dispatch_id[]"  value=""></div><div class="w-15"><input class="value-null form-control" placeholder="Invoice Number" type="text" id="invoice_num'+i+'" name="invoice_num[]"  value="" required></div><div class="w-15"><div class="form-check form-check-inline"><input class="form-check-input ckeck-new" type="radio" name="warranty'+i+'" id="inlineRadio1-'+i+'" value="Yes" checked required><label class="form-check-label" for="inlineRadio1-'+i+'">Yes</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="warranty'+i+'" id="inlineRadio2-'+i+'" value="No" required><label class="form-check-label" for="inlineRadio2-'+i+'">No</label></div></div><div class="w-15"><input type="date" class="form-control value-null p-qnt" name="estimated_date[]"  id="estimated_date1" required></div><div class="w-15"><textarea class="form-control value-null" rows="1" id="remarks'+i+'" name="remarks[]" placeholder="Remarks"></textarea></div><div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product" style="width: auto;" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div></div>').appendTo(scntDiv);
$(".slide_show").slideDown(300).find('#motor_num'+i).focus();
i++;
return false;
});
});
function removeCont(_this) {
if (i > 1) {
$(_this).parent().remove();
}

}
</script>  
<script>

function getCustomer(val){
	$.ajax({
url: "fetch-customer.php", 
type: "POST",
data: "id="+val,
success: function(result){
$(".value-null").val("");
$(".erase").html("");
$('input[type="radio"]').prop('checked', false);
$(".ckeck-new").prop('checked', true);
$("#output").html(result);
if(result!=''){
$("#productSection").slideDown(500);
}else{
$("#productSection").slideUp(500);
}

}});
}
function getProduct(row_id,val){
customer_id=$("#customer_id").val();
$.ajax({
url: "fetch-product.php", 
type: "POST",
data: "id="+row_id+"&value="+val+"&customer_id="+customer_id,
success: function(result){
$("#output_product").html(result);
$('#submitButton').prop('disabled', !allFilled);
}});
}
</script> 

 <script src="assets/plugins/ckeditor/ckeditor.js"></script>
  
<script>
CKEDITOR.replace( 'editor');
</script>

<?php

}

include 'template.php';

?>