<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$act=$_GET['act'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$DATE = date('Y-m-d');
$TIME = date('H:i:s');
if($Submit=='Create Quotation')
{
$terms_condition=addslashes($terms_condition);
$select_customer=mysqli_query($conn,"select * from customer where id='$customer' "); 
$Row_customer=mysqli_fetch_array($select_customer);
$company_name = $Row_customer['company_name'];
$customer_name = $Row_customer['customer_name'];
$customer_type = $Row_customer['customer_type'];
$mobile = $Row_customer['mobile'];
$products_count=count($product_name);
$status='Pending';
$insert_product=mysqli_query($conn,"insert into quotation set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', customer_type='$customer_type', terms_condition='$terms_condition', mobile='$mobile', company_address= '$company_address',  products_count='$products_count', status='Pending', created_by=".$_SESSION['UID']."");

$quotation_id = $conn->insert_id;
$tot_count = 0;
$gst_amount = 0;
$total_gst_amount = 0;
$total_package_amount = 0;
$total_product_amount = 0;

for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 
$tot_count = $tot_count +1;
$product_amount=round(($rate[$i]*$quantity[$i]),2);
$Gst_amount=round(($product_amount*($gst[$i]/100)),2);
$gst_amount= round(($gst_amount + $Gst_amount),2);
$total_product_amount= round(($total_product_amount + $product_amount),2);
$package_amount=round(($Gst_amount + $product_amount),2)/100*$pkg[$i];
$total_package_amount=$total_package_amount+$package_amount;

$total_order_amount = round(($total_order_amount+ $total_amount[$i]),2);

$rs_InsValues=mysqli_query($conn,"insert into quotation_product set quotation_id='$quotation_id', product_name='$product_name[$i]', brand_name='$brand_name[$i]', rate='$rate[$i]', quantity = '$quantity[$i]', estimated_delivery = '$estimated_delivery[$i]', product_amount = '$product_amount', gst = '$gst[$i]', package_percent = '$pkg[$i]', package_amount = '$package_amount', gst_amount = '$Gst_amount', total_amount = '$total_amount[$i]', remarks='$remarks[$i]', created_datetime = '$currentTime', created_by=".$_SESSION['UID']."");

$insert_log = mysqli_query($conn,"insert into price_log (quotation_id, category, product_name, type, new_value, total_amount, created_date, created_time, created_by) values 
  ('$quotation_id', '0', '$product_name[$i]', 'rate', '$rate[$i]', '$total_amount[$i]', '$DATE', '$TIME', '".$_SESSION['UID']."'),
  ('$quotation_id', '0', '$product_name[$i]', 'quantity', '$quantity[$i]', '$total_amount[$i]', '$DATE', '$TIME', '".$_SESSION['UID']."'),
  ('$quotation_id', '0', '$product_name[$i]', 'package', '$pkg[$i]', '$total_amount[$i]', '$DATE', '$TIME', '".$_SESSION['UID']."'),
	('$quotation_id', '0', '$product_name[$i]', 'gst', '$gst[$i]', '$total_amount[$i]', '$DATE', '$TIME', '".$_SESSION['UID']."')
");
}
}
if($freight_charges!=""){
$gst_freight = round(($freight_charges * $freight_gst) / 100,2);
$total_freight = $freight_charges + $gst_freight;
}else{
 $total_freight="0"; 
}

$total_order_amount=$total_freight+$total_order_amount;
$update_total=mysqli_query($conn,"update quotation set product_amount='$total_product_amount', gst_amount='$gst_amount', freight_charges='$freight_charges', freight_gst='$freight_gst', total_freight='$total_freight', total_order_amount='$total_order_amount', total_package_amount='$total_package_amount',  created_datetime = '$currentTime' where id='$quotation_id'");
if($update_total && $rs_InsValues)
{
$msg = 'Quotation Added Successfully';
header('Location:add-quotation.php?id='.$quotation_id.'&msg='.$msg."#preview-btn");
}
else
{
$alert_msg = 'Could not able to add try once again!!!';     
}
}

if($Submit=='Update Quotation')
{
$select_customer=mysqli_query($conn,"select * from customer where id='$customer' "); 
$Row_customer=mysqli_fetch_array($select_customer);
$company_name = $Row_customer['company_name'];
$customer_name = $Row_customer['customer_name'];
$customer_type = $Row_customer['customer_type'];
$mobile = $Row_customer['mobile'];
$products_count=count($product_name);
$terms_condition=addslashes($terms_condition);
$update_product=mysqli_query($conn,"update quotation set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', customer_type='$customer_type', mobile='$mobile', terms_condition='$terms_condition',  company_address= '$company_address', products_count='$products_count', status='Pending', created_by=".$_SESSION['UID']." where id='$ID' ");

$quotation_ProductDelete = mysqli_query($conn,"delete from quotation_product where quotation_id ='$ID' ");

$tot_count = 0;
$gst_amount = 0;
$total_gst_amount = 0;
$total_package_amount=0;
for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 
$tot_count = $tot_count +1;
$product_amount=round(($rate[$i]*$quantity[$i]),2);
$Gst_amount=round(($product_amount*($gst[$i]/100)),2);
$gst_amount= round(($gst_amount + $Gst_amount),2);
$total_product_amount= round(($total_product_amount + $product_amount),2);
$package_amount= round(($Gst_amount + $product_amount),2)/100*$pkg[$i];
$total_package_amount=$total_package_amount+$package_amount;

$total_order_amount = round(($total_order_amount+ $total_amount[$i]),2);

$rs_InsValues=mysqli_query($conn,"insert into quotation_product set quotation_id='$ID', product_name='$product_name[$i]', brand_name='$brand_name[$i]', rate='$rate[$i]', quantity = '$quantity[$i]', estimated_delivery = '$estimated_delivery[$i]', package_amount = '$package_amount', product_amount = '$product_amount', gst = '$gst[$i]', remarks='$remarks[$i]', package_percent = '$pkg[$i]', gst_amount = '$Gst_amount', total_amount = '$total_amount[$i]', created_datetime = '$currentTime', created_by=".$_SESSION['UID']."");
}
}
if($freight_charges!=""){
$gst_freight = round(($freight_charges * $freight_gst) / 100,2);
$total_freight = $freight_charges + $gst_freight;
}else{
 $total_freight="0"; 
}
$total_order_amount=$total_freight+$total_order_amount;
$update_total=mysqli_query($conn,"update quotation set product_amount='$total_product_amount', gst_amount='$gst_amount', freight_charges='$freight_charges', freight_gst='$freight_gst', total_freight='$total_freight', total_order_amount='$total_order_amount', total_package_amount='$total_package_amount', modified_datetime = '$currentTime' where id='$ID' ");

if($update_total && $rs_InsValues)
{
$msg = 'Quotation Updated Successfully';
header('Location:add-quotation.php?id='.$ID.'&msg='.$msg."#preview-btn");
}
else
{
$alert_msg = 'Could not able to updated try once again!!!';    
}
}

$sel_values=mysqli_query($conn,"select * from quotation where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
$customer_id=$row_values['customer_id'];
$mobile=$row_values['mobile'];
$customer_type=$row_values['customer_type'];
$CountQtn = mysqli_num_rows($sel_values); 
$terms_condition=$row_values['terms_condition'];
$company_address=$row_values['company_address'];
$freight_charges=$row_values['freight_charges'];
$freight_gst=$row_values['freight_gst'];

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
<h5 class="text-uppercase mb-0"><?if($CountQtn>>0){ echo"Update";}else{echo "Add";}?> Quotation</span></h5>
<?if($CountQtn>>0){?> <a href="list-quotation.php" class="btn btn-danger">Back</a><?}?> 
</div>
<hr>
<div class="card-title row align-items-center">

<div class="col-xl-6" >
<label for="inputLastName" class="form-label mt-20">Select Company / Customer</label>
<select class="single-select" data-placeholder="Choose anything" multiple="multiple" name="customer" onchange="getCustomer(this.value)" id="customer_id" required>
<? 
$sql_customer=mysqli_query($conn,"select * from  customer where status='1' ORDER BY customer_name asc"); 
while($row_customer=mysqli_fetch_array($sql_customer))
{
?>
<option value="<?=$row_customer['id']?>" <? if($row_customer['id'] == $customer_id) { ?>selected<? } ?> ><?if($row_customer['company_name']!='')echo $row_customer['company_name'].' / ';?><?=$row_customer['customer_name'];?> (<?=$row_customer['mobile'];?>)</option>
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
<p><?=$customer_type;?></p>
<input type="hidden" name="cust_type" id="customer_type" value="<?=$customer_type;?>">
</div>
<div>
<label for="inputLastName" class="form-label mt-20">Mobile</label><br>
<p><?=$mobile;?></p>
</div>
<?}?>
</div>



</div>
<div id="productSection" class=" mt-4 mb-3 " <?if($CountQtn==0){echo'style="display: none;"';} ?>>
<div class="bg-3f663a text-center rounded-1">
<h5 class="text-white py-1">Add Product</h5>
</div>
<div class="px-2" id="Regular" >
<div id="frm_scents">
<? if($CountQtn =='0') { ?>
<div class="row g-2 mt-1 mb-2">
<div class="w-22-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Product</label>

</div>
<div class="w-11">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Brand</label>

</div>
<div class="w-7-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty.</label>
</div>

<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Pkg.</label>
</div>

<div class="w-7">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>

<div class="w-13">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>

<div class="w-12">
<label for="inputLastName" class="form-label mt-20 mb-0">Est. Deliv. Date</label>
</div>

<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

</div>

<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0">Action</label>
</div>
</div>

<div class="row my-1" id="p_scents">

<div class="w-22-5">
<select class="multiple-select" name="product_name[]" id="product_name1" onchange="getPrice(this.value, '1')" required>
<option value="">Select Product</option>
<? 
$sql_product=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); 
while($row_product=mysqli_fetch_array($sql_product))
{
?>
<option value="<?=$row_product['product']?>" <? if($row_product['product'] == $ID) { ?>selected<? } ?> ><?=$row_product['product'];?></option>
<?
}
?>
</select>
</div>
<div class="w-11">
<select class="form-select" name="brand_name[]" required>
<option value="">Select Brand</option>
<? 
$sql_brand=mysqli_query($conn,"select * from  brand where status='1' ORDER BY brand_name asc"); 
while($row_brand=mysqli_fetch_array($sql_brand))
{
?>
<option value="<?=$row_brand['brand_name']?>" <? if($row_brand['brand_name'] == $ID) { ?>selected<? } ?> ><?=$row_brand['brand_name'];?></option>
<?
}
?>
</select>
</div>
<div class="w-7-5">
<input type="number" class="form-control p-qnt" id="rate1" name="rate[]" step="any" onchange="getTotal(1)" placeholder="Rate" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>>
</div>
<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity1" min="0" onchange="getTotal(1)" name="quantity[]" placeholder="Qty" required>
</div>
<div class="w-6 percent">
<input type="number" class="form-control p-qnt percent-wrapper" id="pkg1" min="0" max="99" onchange="getTotal(1)" value="0" name="pkg[]" placeholder="Pkg" required>
<span>%</span>
</div>
<div class="w-7">
<select class="form-select p-qnt" onchange="getTotal(1)" name="gst[]" id="gst1">
<option value="0">0%</option>
<option value="5">5%</option>
<option value="12">12%</option>
<option value="18" selected>18%</option>
<option value="28">28%</option>
</select>
</div>
<div class="w-13">
<textarea class="form-control" rows="1" id="remarks1" name="remarks[]" placeholder="Remarks"></textarea>
</div>
<div class="w-12">
  <input type="date" class="form-control p-qnt" name="estimated_delivery[]" value="<?=$estimated_delivery;?>" required="">
</div>
<div class="w-10">
<label class="ItemTotal fw-6" id="tot1">₹0.00</label>
<input type="hidden" id="tot_val1" name="total_amount[]">
</div>
<div class="w-5 text-end">
<a type="button" id="addScnt" tooltip="Add Product" class="pe-1"  style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a>

</div>
</div>
<? } else { ?>

<div class="row g-2 mt-1 mb-2">
<div class="w-22-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Product</label>

</div>
<div class="w-11">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Brand</label>

</div>
<div class="w-7-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty.</label>
</div>

<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Pkg.</label>
</div>

<div class="w-7">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>

<div class="w-13">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>

<div class="w-12">
<label for="inputLastName" class="form-label mt-20 mb-0">Est. Deliv. Date</label>
</div>

<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

</div>

<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0">Action</label>
</div>
</div>

<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from quotation_product where quotation_id = '$ID'"); 
while($row_product=mysqli_fetch_array($sel_product))
{ 
$SNo = $SNo + 1; 
$product_name=$row_product['product_name'];
$brand_name=$row_product['brand_name'];
$rate=$row_product['rate'];
$quantity=$row_product['quantity'];
$gst=$row_product['gst'];
$total_amount=$row_product['total_amount'];
$estimated_delivery=$row_product['estimated_delivery'];
$package_percent=$row_product['package_percent'];
$remarks=$row_product['remarks'];
?>

<div class="row my-1" id="p_scents">

<div class="w-22-5">
<select class="multiple-select" name="product_name[]" id="product_name<?=$SNo;?>" onchange="getPrice(this.value, '<?=$SNo?>')" required>
<option value="">Select Product</option>
<? 
$sql_product=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); 
while($row_product=mysqli_fetch_array($sql_product))
{
?>
<option value="<?=$row_product['product']?>" <? if($row_product['product'] == $product_name) { ?>selected<? } ?> ><?=$row_product['product'];?></option>
<?
}
?>
</select>
</div>
<div class="w-11">
<select class="form-select" name="brand_name[]" required>
<option value="">Select Brand</option>
<? 
$sql_brand=mysqli_query($conn,"select * from  brand where status='1' ORDER BY brand_name asc"); 
while($row_brand=mysqli_fetch_array($sql_brand))
{
?>
<option value="<?=$row_brand['brand_name']?>" <? if($row_brand['brand_name'] == $brand_name) { ?>selected<? } ?> ><?=$row_brand['brand_name'];?></option>
<?
}
?>
</select>
</div>
<div class="w-7-5">
<input type="number" class="form-control p-qnt" id="rate<?=$SNo?>" name="rate[]" step="any" onchange="getTotal(<?=$SNo?>);addRate(<?=$SNo?>,this.value,'rate');" placeholder="Rate" value="<?=$rate;?>" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>>
<input type="hidden" id="rateChange<?=$SNo?>" value="1">
</div>

<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity<?=$SNo?>" onchange="getTotal(<?=$SNo?>);addRate(<?=$SNo?>,this.value,'quantity');" name="quantity[]" placeholder="Qty" min="0" value="<?=$quantity;?>" required>
<input type="hidden" id="quantityChange<?=$SNo?>" value="1">
</div>
<div class="w-6 percent">
<input type="number" class="form-control p-qnt" id="pkg<?=$SNo?>" value="<?=$package_percent; ?>" min="0" max="99" onchange="getTotal(<?=$SNo?>);addRate(<?=$SNo?>,this.value,'package');" name="pkg[]" placeholder="Pkg" required>
<input type="hidden" id="packageChange<?=$SNo?>" value="1">
<span>%</span>
</div>
<div class="w-7">
<select class="form-select p-qnt" onchange="getTotal(<?=$SNo?>);addRate(<?=$SNo?>,this.value,'gst');" name="gst[]" id="gst<?=$SNo?>">
<option value="0" <? if($gst == "0") { ?>selected<? } ?>>0%</option>
<option value="5" <? if($gst == "5") { ?>selected<? } ?>>5%</option>
<option value="12" <? if($gst == "12") { ?>selected<? } ?>>12%</option>
<option value="18" <? if($gst == "18") { ?>selected<? } ?>>18%</option>
<option value="28" <? if($gst == "28") { ?>selected<? } ?>>28%</option>
</select>
<input type="hidden" id="gstChange<?=$SNo?>" value="1">
</div>
<div class="w-13">
<textarea class="form-control" rows="1" id="remarks<?=$SNo?>" name="remarks[]" placeholder="Remarks"><?=$remarks;?></textarea>
</div>
<div class="w-12">
  <input type="date" class="form-control p-qnt" name="estimated_delivery[]" value="<?=$estimated_delivery;?>" required="">
</div>
<div class="w-10">
<label class="ItemTotal fw-6" id="tot<?=$SNo?>">₹<?=$total_amount;?></label>
<input type="hidden" id="tot_val<?=$SNo?>" name="total_amount[]" value="<?=$total_amount;?>">
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
<hr>


<div class="col-md-12 row g-3">
<div class="col-lg-3">
<label for="inputAddress" class="form-label">Freight Charges</label>
<input type="number" class="form-control" name="freight_charges" value="<?=$freight_charges;?>" required="">
</div>
<div class="col-lg-2">
<label for="inputAddress" class="form-label">Freight GST (%)</label>
<select class="form-select p-qnt" name="freight_gst" id="freight_gst">
<option value="0"  <? if($freight_gst == "0") { ?>selected<? } ?>>0%</option>
<option value="5" <? if($freight_gst == "5") { ?>selected<? } ?>>5%</option>
<option value="12" <? if($freight_gst == "12") { ?>selected<? } ?>>12%</option>
<option value="18" <? if($freight_gst == "18" || $freight_gst == "" ) { ?>selected<? } ?>>18%</option>
<option value="28" <? if($freight_gst == "28") { ?>selected<? } ?>>28%</option>
</select>
</div>
<div class="col-lg-6">
</div>
<div class="col-lg-6">
	<label for="inputAddress" class="form-label">Terms & Conditions</label>
	<textarea id="editor" name="terms_condition"><?if($terms_condition==''){?>Fitted with SKF/FAG bearings<br>
Insulation Class F<br>
Degree Of Protection : IP55<br>
Construction Material : CI/AL available<br>
Payment : Against Proforma invoice<br>
Delivery : 1 week<br>
Freight : TO Pay basis<br>
Goods once sold will not be taken back<?}else{echo stripslashes($terms_condition);}?></textarea>
</div>

<div class="col-md-6 ">
	<label for="inputAddress" class="form-label width-100 mt-3" >Company Name</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="company_address" id="inlineRadio1" value="0" <? if($company_address =='0' || $company_address=='') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">Stark Motors</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="company_address" id="inlineRadio2" value="1" <? if($company_address =='1') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio2">Stark Engineers</label>
</div>
</div>

</div>

</div>
<div class="col-12 mt-3" >
<input type="submit" name="Submit" class="btn btn-primary px-3" value="<? if($CountQtn >> 0) {   echo  "Update Quotation"; } else echo "Create Quotation";?>" >
</div> 
<? if($CountQtn >> 0) { ?>
<div class="col-12 mt-3"  id="preview-btn"> 
<a href="preview-quotation.php?id=<?=$ID; ?>" class="btn btn-warning px-3 ">Preview Quotation</a></div>
<? } ?>



</div>
</div> </div></div></div></div></div>
</form>
</div></div>
<script src="assets/js/addmore.js"></script>
<script>
var scntDiv = $("#frm_scents");
var i = $("[id=p_scents]").length + 1;

$(function() {
$("#addScnt").click(function() {
$('<div class="row my-1 slide_show" id="p_scents" style="display:none"><div class="w-22-5"><select class="multiple-select" name="product_name[]" id="product_name'+i+'" onchange="getPrice(this.value, '+i+'<? if($ID!=''){echo", \'new_product\'";}?>)" required><option value="">Select Product</option><? $sql_product=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); while($row_product=mysqli_fetch_array($sql_product)){?><option value="<?=$row_product['product']?>" <? if($row_product['product'] == $ID) { ?>selected<? } ?> ><?=$row_product['product'];?></option><?}?></select></div><div class="w-11"><select class="form-select" name="brand_name[]" required><option value="">Select Brand</option><? $sql_brand=mysqli_query($conn,"select * from  brand where status='1' ORDER BY brand_name asc"); while($row_brand=mysqli_fetch_array($sql_brand)){?><option value="<?=$row_brand['brand_name']?>" <? if($row_brand['brand_name'] == $ID) { ?>selected<? } ?> ><?=$row_brand['brand_name'];?></option><?}?></select></div><div class="w-7-5"><input type="number" class="form-control  p-qnt" id="rate'+i+'" name="rate[]" step="any" onchange="getTotal('+i+');addRate('+i+',this.value,\'rate\');" placeholder="Rate" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>><input type="hidden" id="rateChange'+i+'" value="1"></div><div class="w-6"><input type="number" class="form-control p-qnt" id="quantity'+i+'" name="quantity[]" min="0" onchange="getTotal('+i+');addRate('+i+',this.value,\'quantity\');" placeholder="Qty" required><input type="hidden" id="qtyChange'+i+'" value="1"></div><div class="w-6 percent"><input type="number" class="form-control p-qnt" id="pkg'+i+'" min="0" max="99" name="pkg[]" value="0" onchange="getTotal('+i+');addRate('+i+',this.value,\'package\');" placeholder="Pkg" required><span>%</span><input type="hidden" id="pkgChange'+i+'" value="1"></div><div class="w-7"><select class="form-select p-qnt" onchange="getTotal('+i+');addRate('+i+',this.value,\'gst\');" name="gst[]" id="gst'+i+'"><option value="0" selected>0%</option><option value="5">5%</option><option value="12">12%</option><option value="18" selected>18%</option><option value="28">28%</option></select><input type="hidden" id="gstChange'+i+'" value="1"></div><div class="w-13"><textarea class="form-control" rows="1" id="remarks'+i+'" name="remarks[]" placeholder="Remarks" ></textarea></div><div class="w-12"><input type="date" class="form-control p-qnt" name="estimated_delivery[]" value="" required=""></div><div class="w-10"><label class="ItemTotal fw-6" id="tot'+i+'">₹0.00</label><input type="hidden" id="tot_val'+i+'" name="total_amount[]"></div><div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product" style="width: auto;" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div></div>').appendTo(scntDiv);
$('.single-select').select2({
theme: 'bootstrap4',
width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
placeholder: $(this).data('placeholder'),
allowClear: Boolean($(this).data('allow-clear')),
});
$('.multiple-select').select2({
theme: 'bootstrap4',
width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
placeholder: $(this).data('placeholder'),
allowClear: Boolean($(this).data('allow-clear')),
});
$(".slide_show").slideDown(300);
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
$("#output").html(result);
if(result!=''){
$("#productSection").slideDown(500);
}else{
$("#productSection").slideUp(500);
}

}});
}

function getPrice(val,row_id,is_new){
customer_type=$("#customer_type").val();
if(customer_type !=''){
$.ajax({
url: "fetch-price.php", 
type: "POST",
data: "id="+encodeURIComponent(val)+"&row_id="+row_id+"&customer_type="+customer_type,
success: function(result){
$("#rate"+row_id).val(result);
if($("#quantity"+row_id).val()!=''){
getTotal(row_id);
}
if(is_new!=''){
addRate(row_id,result,'rate');
}
}});
}
}

function getTotal(row_id){
rate=$("#rate"+row_id).val();
quantity=$("#quantity"+row_id).val();
pkg=$("#pkg"+row_id).val();
gst=$("#gst"+row_id).val();
total=rate*quantity;
if(gst!='0'){
tot_gst=(parseFloat(total)+((parseFloat(total)*(parseFloat(gst)/100)))).toFixed(2);
}else{
tot_gst=(total).toFixed(2);
}
if(pkg!='0' && pkg!='' ){
	tot_gst=(parseFloat(tot_gst)+(parseFloat(tot_gst)/100*parseFloat(pkg))).toFixed(2);
}
$("#tot"+row_id).html('₹'+tot_gst);
$("#tot_val"+row_id).val(tot_gst);
}
</script> 
<?if($ID!=''){?>
<script> 
function addRate(row_id,val,type){
table_type=$("#"+type+"Change"+row_id).val();
total_value=$("#tot_val"+row_id).val();
product_name=$("#product_name"+row_id).val();
id=<?=$ID;?>;
$.ajax({
url: "ajax-price-log.php", 
type: "POST",
data: "id="+id+"&product_name="+product_name+"&table_type="+table_type+"&total_value="+total_value+"&type="+type+"&new_value="+val+"&category=0",
success: function(result){
$("#"+type+"Change"+row_id).val('2');
}

});
}
</script> 
<?}?>
 <script src="assets/plugins/ckeditor/ckeditor.js"></script>
  
    <script>
window.addEventListener("load", function () {
if (window.location.hash === "#preview-btn") {
window.scrollTo({
top: document.body.scrollHeight,
behavior: "smooth"
});
}
});

CKEDITOR.replace( 'editor');
  minHeight: '800px'
    </script>

<?php

}

include 'template.php';

?>