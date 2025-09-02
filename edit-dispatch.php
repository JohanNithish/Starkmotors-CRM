<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$Act=$_GET['act'];

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

$currentDate=date('Y-m-d');
if( $_SESSION['USERTYPE']>>0){ 
  header('Location:list-dispatch.php');
}
if($Submit=='Update Dispatch')
{

$dispatch_num=addslashes($dispatch_num);
$dispatch_date=addslashes($dispatch_date);
$CountId=count($ProductId);
$tot_count = 0;
$check_id=0;
   
$x=$i+1;
$motornum=$_POST['motor_num'];

if($motornum != '')
{  
$tot_count = $tot_count +1;
if(count($motornum)>1){
$Motor_num=implode("~",$motornum);
}else{
$Motor_num=$motornum[0]; 
}
$Quantity=addslashes($quantity);
$Document_num=addslashes($document_num);

$rs_UpdValues=mysqli_query($conn,"update ordered_products set total_dispatch = '$Quantity', modified_datetime = '$currentTime' where id='$sales_product_id' ");
$rs_InsValues=mysqli_query($conn,"update dispatch set motor_num='$Motor_num', quantity='$Quantity', document_num='$Document_num', dispatch_num = '$dispatch_num', dispatch_date = '$dispatch_date', dispatch_through = '$dispatch_through',  po_reference = '$refered_by',  modified_datetime = '$currentTime' where id='$ID' ");
 $mess_Motor_Num=str_replace("~",", ",$Motor_num);
  }


$select_date=mysqli_query($conn,"select (select MAX(dispatch_date) from dispatch where sales_id='$sales_id') as maxdate, (select COUNT(quantity) from ordered_products where quantity=total_dispatch and sales_id='$sales_id') as TotalCount, (select products_count from order_confirmation where id='$sales_id') as TotalProducts");
  $row_date=mysqli_fetch_array($select_date);
  $TotalCount=$row_date['TotalCount']; 
  $maxdate=$row_date['maxdate'];
  $TotalProducts=$row_date['TotalProducts'];
  if($TotalCount==$TotalProducts){
    $update_product=mysqli_query($conn,"update order_confirmation set dispatch_date='$maxdate', status='Dispatched', modified_datetime = '$currentTime' where id='$sales_id' ");
  }

if($rs_InsValues)

   {

$sel_values_mail=mysqli_query($conn,"select * from order_confirmation where id = '$ID'"); 
$row_values_mail=mysqli_fetch_array($sel_values_mail);
$customer_id=$row_values_mail['customer_id'];
$mobile=$row_values_mail['mobile'];
$customer_type=$row_values_mail['customer_type'];
$company_name=$row_values_mail['company_name'];
$customer_name=$row_values_mail['customer_name'];
$refered_by=$row_values_mail['refered_by'];
$invoice_date=$row_values_mail['invoice_date'];
$company_address=$row_values_mail['company_address'];
if($company_address==1){$company_add="Stark Engineers";}else{$company_add="Stark Motors";}
if($company_name==""){$to_name=$customer_name;}else{$to_name=$company_name;}


$select_customer=mysqli_query($conn,"select * from customer where id='$customer_id'");
$row_customer_mess=mysqli_fetch_array($select_customer);
$email=$row_customer_mess['email'];

      $msg = 'Product Dispatched Successfully';
     header('Location:list-dispatch.php?msg='.$msg);
   }
   else
   {
      $alert_msg = 'Could not able to add try once again!!!';     
   }
}


$sel_values=mysqli_query($conn,"select * from dispatch where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
$sales_id=$row_values['sales_id'];

$sel_sales=mysqli_query($conn,"select * from order_confirmation where id = '$sales_id'"); 
$row_sales=mysqli_fetch_array($sel_sales);

$sel_product=mysqli_query($conn,"select * from ordered_products where sales_id = '$sales_id'"); 
$row_product=mysqli_fetch_array($sel_product);


$customer_id=$row_sales['customer_id'];
$mobile=$row_sales['mobile'];
$customer_type=$row_sales['customer_type'];
$enquiry_num=$row_sales['enquiry_num'];
$refered_by=$row_sales['refered_by'];
$invoice_date=$row_sales['invoice_date'];
$estimated_delivery=$row_sales['estimated_delivery'];
$CountQtn = 1; 
$terms_condition=$row_sales['terms_condition'];
$company_address=$row_sales['company_address'];

$sales_product_id=$row_values['sales_product_id'];
$dispatch_num=$row_values['dispatch_num'];
$dispatch_through=$row_values['dispatch_through'];
$po_reference=$row_values['po_reference'];
$dispatch_num=$row_values['dispatch_num'];
$product_name=$row_values['product_name'];
$dispatch_date=$row_values['dispatch_date'];
$quantity=$row_values['quantity'];
$total_dispatch=$row_values['total_dispatch'];
$motor_num=$row_values['motor_num'];
$document_num=$row_values['document_num'];


$total_quantity=$row_product['quantity'];
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
<div class="row justify-content-center">
<div class="col-xl-12">
<div class="card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<div class="card-body p-5">
  <div class="d-flex justify-space-between align-items-center">
  <h5 class="text-uppercase mb-0">Edit Dispatch</h5>
 <?if($CountQtn>>0){?> <a href="<?=$_SERVER['HTTP_REFERER'];?>" class="btn btn-danger">Back</a><?}?> 
  </div>
<hr>
<div class="card-title row ">

  <? $sql_customer=mysqli_query($conn,"select * from  customer where id='$customer_id' ORDER BY customer_name asc"); 
$row_customer=mysqli_fetch_array($sql_customer); ?>


<div class="col-xl-4 mt-4">
  <h5>Customer Details</h5><hr class="mt-2">
  <div class="d-flex gap-2">
<div class="row">
<div class="d-flex col-12">
<div class=" col-5">
<label for="inputLastName" class="form-label mt-20">Company Name:</label>
</div>
<p class="mb-0"><?=$row_customer['company_name'];?></p>
</div>
<div class="d-flex col-12">
<div class=" col-5">
<label for="inputLastName" class="form-label mt-20">Name:</label>
</div>
<p class="mb-0"><?=$row_customer['customer_name'];?></p>
</div>
<div class="d-flex col-12">
<div class=" col-5">
<label for="inputLastName" class="form-label mt-20">Mobile:</label>
</div>
<p class="mb-0"><?=$row_customer['mobile'];?></p>
</div>
<div class="d-flex col-12">
<div class=" col-5">
<label for="inputLastName" class="form-label mt-20">Customer Type:</label>
</div>
<p class="mb-0"><?=$row_customer['customer_type'];?></p>
</div>

</div>
<div class="lh-1-1">

</div>
</div>
</div>
<div class="col-xl-4 mt-4">
  <h5 class="mb-0">Sales Details</h5>
  <div class="d-flex gap-2">
<div class="col-5">
  <hr class="mt-2 w-105">
<? if($enquiry_num!=''){ ?><label for="inputLastName" class="form-label mt-20">Customer PO No:</label><br><?}?>
<? if($refered_by!=''){ ?><label for="inputLastName" class="form-label mt-20">Job Card No:</label><br><?}?>
<? if($invoice_date!=''){ ?><label for="inputLastName" class="form-label mt-20">PO Date:</label><br><?}?>
<label for="inputLastName" class="form-label mt-20">Company Name:</label>
</div>
<div class="lh-1-1">
  <hr class="mt-2">
<? if($enquiry_num!=''){ ?><p class="mb-0"><?=$enquiry_num;?></p><br><?}?>
<? if($refered_by!=''){ ?><p class="mb-0"><?=$refered_by;?></p><br><?}?>
<? if($invoice_date!=''){ ?><p class="mb-0"><?=date("d-m-Y", strtotime($invoice_date));?></p><br><?}?>
<p class="mb-0"><?if($company_address==1){echo"Stark Engineers";}else{echo"Stark Motors";}?></p>
</div>
</div>
</div>


<div class="col-xl-2 mt-3">
<label for="inputLastName" class="form-label mt-20">Dispatch No</label>
<input type="text" class="form-control" name="dispatch_num" value="<?=$dispatch_num;?>" Placeholder="Dispatch No." required>
<br>
<label for="inputLastName" class="form-label mt-20">LR No</label>
<input type="text" class="form-control" name="refered_by" value="<?=$po_reference;?>" Placeholder="LR No" required>
<input type="hidden" name="customer_id" value="<?=$customer_id;?>">
</div>


<div class="col-xl-2 mt-3">
<label for="inputLastName" class="form-label mt-20">Dispatch Date</label>
<input type="date" class="form-control" name="dispatch_date" value="<?if($dispatch_date!=''){echo $dispatch_date;}else{ echo $currentDate;}?>" required>
<br>
<label for="inputLastName" class="form-label mt-20">Dispatch Through</label>
<input type="text" class="form-control p-qnt" id="dispatch_through"  value="<?=$dispatch_through;?>" name="dispatch_through" placeholder="Dispatch Through"  value="" required>
</div>


<!-- <div class="col-xl-2 mt-3">
<label for="inputLastName" class="form-label mt-20">Invoice No</label>
<input type="text" class="form-control" name="invoice_num" value="<?=$invoice_num;?>" Placeholder="Invoice No." required>
</div>
 -->

</div>
<div class="bg-3f663a text-center mt-1 mb-3 rounded-1">
  <h5 class="text-white py-1">Dispatch List</h5>
</div>
<div class="px-2" id="Regular" >
<div id="frm_scents" class="position-relative ">
<? if($CountQtn >>'0') { ?>

<div class="row g-2 mt-1 mb-2">

<div class="col-12">
  <div class="row ">
<div class="w-3">
  #
</div>

<div class="w-32">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Product Name</label>
</div>

<div class="w-17 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Qty </label>
<span>(<small>min: <?=$quantity;?> - max:<?=$total_quantity;?></small>)</span>
</div>

<div class="w-20 ms-2 ">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Invoice No</label>

</div>

<div class="w-20 px-1 d-flex flex-wrap align-items-center" id="Motor_title">
<div class="w-7-5 pe-0"> <label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">#</label>
</div>
<div class=" pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Motor Serial No</label>
</div>


</div>

</div>
</div>

</div>
<div class="row">
<div class="col-12">

<hr class="my-2">
<div class="row my-1">
<div class="w-3 py-2">
 1
</div>
<div class="w-32">
<label class="m-0 fw-lighter py-2" for="Product<?=$SNo;?>"><?=$product_name;?></label>
<input type="hidden" name="sales_id" value="<?=$sales_id;?>">
<input type="hidden" name="sales_product_id" value="<?=$sales_product_id;?>">
<input type="hidden" name="product_name" value="<?=$product_name;?>">
<input type="hidden" name="total_dispatch" value="<?=$total_quantity-$quantity;?>">
</div>

<div class="w-17 pe-0">
  <div class="d-flex flex-wrap align-items-center">
<input type="number" class="form-control p-qnt w-50" name="quantity" id="quantity<?=$SNo?>" placeholder="Qty"  min="<?=$quantity;?>" max="<?=$total_quantity;?>" value="<?=$quantity;?>" onchange="maxValue(this,this.value,'<?=$quantity;?>','<?=$total_quantity;?>');setList(this.value,'<?=$quantity;?>','<?=$total_quantity;?>');">
<p class="ms-2 mb-0"></p>
</div>
</div>
<div class="w-20 pe-0">
<input type="text" class="form-control p-qnt" id="document_num<?=$SNo?>" name="document_num" value="<?=$document_num?>" placeholder="Invoice No"  value="" >
</div>
<div class="w-25 pe-0">
  <?
   $motor_num = explode("~", $motor_num);
$sno=0;
// Looping through the array using foreach
foreach ($motor_num as $value) {
   ?>
<div class="d-flex mb-2 gap-2 align-items-center"><div class=" pe-0"><?$sno=$sno+01; echo sprintf("%02d", $sno)?></div><div class="pe-0 "><input type="text" class="form-control p-qnt" id="motor_num<?echo sprintf("%02d", $sno)?>" value="<?=$value;?>" name="motor_num[]" placeholder="Motor Serial No"  value="" required ></div>
</div>
   <?
}
?>
<div id="show">

</div>
</div>

</div>



</div>
<div class="col-12 mt-3">
<input type="submit" name="Submit" class="btn btn-primary px-3" value="Update Dispatch" >



</div>
</div>
<?}?>
</div>
</div>
</div>
</div></div></div></div>
</form>


<script type="text/javascript">
function maxValue(obj, val, minVal, maxVal) {
minVal = parseInt(minVal);
maxVal = parseInt(maxVal);
if (val > maxVal) {
$(obj).val(maxVal);
} else if (val < minVal) {
$(obj).val(minVal);
} else {
$(obj).val(val);
}
}

function setList(val,quantity,total_quantity){
$("#show").html(" ");
if(val>quantity && total_quantity>=val){
  quantity_count= val-quantity;
  count_num=quantity;
for (let i = 1; i <= quantity_count; i++) {
count_num++;
  let formatted = count_num < 10 ? "0" + count_num : count_num.toString();
$("#show").append('<div class="d-flex mb-2 gap-2 align-items-center"><div class=" pe-0">'+formatted+'</div><div class="pe-0 "><input type="text" class="form-control p-qnt" id="motor_num'+formatted+'" name="motor_num[]" placeholder="Motor Serial No"  value="" required ></div></div>');
}
}else{
  $("#document_num"+val).prop('required',false);

}
}

</script>
<?php

}

include 'template.php';

?>