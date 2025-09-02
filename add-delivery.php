<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$Act=$_GET['act'];
if($Act!="delivery"){
 header('Location:list-sales.php');
}
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

$currentDate=date('Y-m-d');

if($Submit=='Move to Delivery')
{
if (is_array($check)) {
$CountId=count($check);
for($i=0; $i<=$CountId; $i++)
  {
     $x=$check[$i];
     $rs_InsValues=mysqli_query($conn,"update service_product set delivery_date='$delivery_date[$x]', status='Delivered', modified_datetime = '$currentTime' where id='$update_id[$x]' ");
}
if($rs_InsValues){
$select_date=mysqli_query($conn,"select total_delivery, products_count from service where id = '$ID'");
  $row_date=mysqli_fetch_array($select_date);
  $current_delivery=$row_date['total_delivery']; 
  $products_count=$row_date['products_count'];
  $total_delivery=$CountId+$current_delivery;
  if($products_count==$total_delivery){
      $subqry=" , status='Out' ";
      $Dispatched="&status=Out";
  }
    $update_product=mysqli_query($conn,"update service set total_delivery='$total_delivery', modified_datetime = '$currentTime' $subqry where id='$ID' ");
}


if($update_product)
   {
      $msg = 'Product Dispatched Successfully';
      header('Location:list-services.php?msg='.$msg.$Dispatched);
   }
   else
   {
      $alert_msg = 'Could not able to add try once again!!!';     
   }
}else{
  $alert_msg = 'Please deliver at least one item!!!';   
}
}
$sel_values=mysqli_query($conn,"select * from service where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
$customer_id=$row_values['customer_id'];
$mobile=$row_values['mobile'];
$customer_type=$row_values['customer_type'];
$enquiry_num=$row_values['enquiry_num'];
$refered_by=$row_values['refered_by'];
$service_num=$row_values['service_num'];
$service_date=$row_values['service_date'];
$CountQtn = mysqli_num_rows($sel_values); 
$terms_condition=$row_values['terms_condition'];
$company_address=$row_values['company_address'];

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
  <h5 class="text-uppercase mb-0">Move to Delivery</span></h5>
 <?if($CountQtn>>0){?> <a href="<?=$_SERVER['HTTP_REFERER'];?>" class="btn btn-danger">Back</a><?}?> 
  </div>
<hr>
<div class="card-title row ">

  <? $sql_customer=mysqli_query($conn,"select * from  customer where id='$customer_id'"); 
$row_customer=mysqli_fetch_array($sql_customer); ?>


<div class="col-xl-5 mt-4">
  <h5>Customer Details</h5><hr class="mt-2">
  <div class="d-flex gap-2">
<div class="row">
<div class="d-flex col-12">
<div class=" col-4">
<label for="inputLastName" class="form-label mt-20">Company Name&nbsp;:</label>
</div>
<p class="mb-0"><?=$row_customer['company_name'];?></p>
</div>
<div class="d-flex col-12">
<div class=" col-4">
<label for="inputLastName" class="form-label mt-20">Name&nbsp;:</label>
</div>
<p class="mb-0"><?=$row_customer['customer_name'];?></p>
</div>
<div class="d-flex col-12">
<div class=" col-4">
<label for="inputLastName" class="form-label mt-20">Mobile&nbsp;:</label>
</div>
<p class="mb-0"><?=$row_customer['mobile'];?></p>
</div>
<div class="d-flex col-12">
<div class=" col-4">
<label for="inputLastName" class="form-label mt-20">Customer Type&nbsp;:</label>
</div>
<p class="mb-0"><?=$row_customer['customer_type'];?></p>
</div>

</div>
<div class="lh-1-1">

</div>
</div>
</div>
<div class="col-xl-4 mt-4">
  <h5 class="mb-0">Service Details</h5>
  <div class="d-flex gap-2">
<div class="">
  <hr class="mt-2 w-105">
<label for="inputLastName" class="form-label mt-20">Service ID :</label><br>
<label for="inputLastName" class="form-label mt-20">Service Date :</label><br>
</div>
<div class="lh-1-1">
  <hr class="mt-2 mb-3">
  <p class="mb-0 ">SRV<?=$ID;?></p><br>

<p class="mb-0"><?=date("d-m-Y", strtotime($service_date));?></p><br>
</div>
</div>
</div>



<!-- <div class="col-xl-2 mt-3">
<label for="inputLastName" class="form-label mt-20">Invoice No</label>
<input type="text" class="form-control" name="invoice_num" value="<?=$invoice_num;?>" Placeholder="Invoice No." required>
</div>
 -->

</div>
<div class="bg-3f663a text-center mt-1 mb-3 rounded-1">
  <h5 class="text-white py-1">Product List</h5>
</div>
<div class="px-2" id="Regular" >
<div id="frm_scents">
<? if($CountQtn >>'0') { ?>

<div class="row g-2 mt-1 mb-2">

<div class="w-3">
  #
</div>

<div class="w-25 col-ms-68">
<label for="inputLastName" class="form-label mt-20 mb-0">Product Name</label>

</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Motor Serial No</label>
</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Invoice Number</label>

</div>
<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Warranty</label>
</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Out Date</label>
</div>
<div class="w-17">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-500">Remarks</label>
</div>
 
</div>
<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from service_product where service_id = '$ID' and status='Not Delivered' order by id"); 
while($row_product=mysqli_fetch_array($sel_product))
{ 
$service_id=$row_product['id'];
$dispatch_id=$row_product['dispatch_id'];
$product_name=$row_product['product_name'];
$brand_name=$row_product['brand_name'];
$motor_num=$row_product['motor_num'];
$invoice_num=$row_product['invoice_num'];
$warranty=$row_product['warranty'];
$estimated_date=$row_product['estimated_date'];
$remarks=$row_product['remarks'];
?>
<hr class="my-2">
<div class="row my-1 align-items-center">
<div class="w-3">
<input class="form-check-input" type="checkbox" onchange="setReq(this.value)" name="check[]" value="<?=$SNo;?>" id="Product<?=$SNo;?>">
<input type="hidden" name="update_id[]" value="<?=$service_id;?>">
</div>
<div class="w-25">
<label class="m-0 fw-lighter py-2" for="Product<?=$SNo;?>"><?=$product_name;?></label>
</div>

<div class="w-15  ps-2">
<p class="m-0"><?=$motor_num;?></p>
</div>
<div class="w-15  ps-2">
<p class="m-0"><?=$invoice_num;?></p>
</div>
<div class="w-10  ps-2">
<p class="m-0"><?=$warranty;?></p>
</div>
<div class="w-15  ps-1">
<input type="date" class="form-control" name="delivery_date[]" value="<?=$currentDate;?>" required>
</div>
<div class="w-17  ps-0">
<p class="m-0"><?=$remarks;?></p>
</div>

</div>
<? $SNo = $SNo + 1; 
}  } ?>
</div>
<!-- export-shiping.php -->
 
<div class="col-12 mt-3">
<input type="submit" name="Submit" class="btn btn-primary px-3" value="Move to Delivery" >
</div> 
</div>
</div>
</div></div></div></div></div>
</form>
</div></div>

<?php

}

include 'template.php';

?>