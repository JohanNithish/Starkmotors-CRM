<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
if($ID==""){
 header('Location:list-delivery-challan.php');
}
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

$currentDate=date('Y-m-d');

if($Submit=='Move to Inward')
{
if(empty(array_filter($quantity))){
  $CountNum=0;
}else{
  $CountNum=count($quantity);
}
if($CountNum>0){

for($i=0; $i<$CountNum; $i++)
  {
if($quantity[$i]>>0){
$rs_InsValues=mysqli_query($conn,"insert into delivery_inward set delivery_challan_id='$ID', product_name='$product_name[$i]', quantity='$quantity[$i]', inward_number='$inward_number', inward_date='$inward_date',  created_datetime = '$currentTime' ");


$rs_UpdValues=mysqli_query($conn,"update delivery_challan_product set total_inward = total_inward+$quantity[$i] where id='$ProductId[$i]' ");


}
}
$sel_values_product=mysqli_query($conn,"select * from delivery_challan_product where quantity != total_inward and delivery_challan_id='$ID' "); 
if(mysqli_num_rows($sel_values_product)==0){
$updateChallan=mysqli_query($conn,"update delivery_challan set status = 'Received', modified_datetime='$currentTime' where  id = '$ID' ");
}

if($rs_InsValues){
$msg = 'Product Inward Successfully';
header('Location:list-delivery-challan.php?msg='.$msg);
}

}
else{
  $alert_msg = 'Please Inward at least one item.';   
}


}
$sel_values=mysqli_query($conn,"select * from delivery_challan where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
foreach($row_values as $K1=>$V1) $$K1 = $V1;
$CountQtn = mysqli_num_rows($sel_values); 

?>

<body >
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
<div class="row">
<div class="<?  if($status!='Received'){echo "col-xl-12";}else{echo "col-xl-10";}?>">
<div class="card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<div class="card-body p-5">
  <div class="d-flex justify-space-between align-items-center">
  <h5 class="text-uppercase mb-0">Received Delivery Challan</h5>
 <?if($CountQtn>>0){?> <a href="<?=$_SERVER['HTTP_REFERER'];?>" class="btn btn-danger">Back</a><?}?> 
  </div>
<hr>
<div class="row">

<div class="col-xl-12">

<div class="col-12 mt-0 py-2 lh-lg">
<p class="mb-0"><b>Customer Name: </b> <?=$company_name;?> (<?=$customer_name;?>) | <b>Delivery Challan Number: </b> <?=$delivery_challan_number;?><? if($reference_number!=''){ ?> | <b>Reference Number: </b> <?=$reference_number;?><?}?></p>

</div>
</div>
</div></div>
</div></div>
<div class="row pe-0">
<?  if($status!='Received'){?>
<div class="col-6 pe-0">
  <div class="card p-3 bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<form action="#" method="post" onsubmit="return confirm('Are you sure you want to move inward?')" enctype="multipart/form-data" name="form1">


<div class="bg-3f663a text-center mb-3 rounded-1">
  <h5 class="text-white py-1">Move to Received</h5>
</div>

<div class="row">
<div class="col-md-6 mt-2">
<label for="inputFirstName" class="form-label">Inward Delivery Challan No.</label>
<input type="text" name="inward_number" id="inward_number" class="form-control" value="<?=$inward_number;?>" placeholder="Inward Delivery No." required>
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>

<div class="col-md-6 mt-2">
<label for="inputFirstName" class="form-label">Inward Delivery Challan Date</label>
<input type="date" name="inward_date" id="inward_date" class="form-control" value="<?if($inward_date!='' && $inward_date!='0000-00-00'){ echo $inward_date;}else{echo $currentDate;}?>" required>
</div>
</div>
<hr>
<div class="px-2" id="Regular" >
<div id="frm_scents" class="position-relative ">
<? if($CountQtn >>'0') { ?>

<div class="row g-2 mt-1 mb-2">

<div class="col-12">
  <div class="row ">
<div class="col-1">
  #
</div>

<div class="col-9">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Product Name</label>
</div>

<div class="col-2 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Qty</label>
</div>





</div>
</div>

</div>
<div class="row">
<div class="col-12">
<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from delivery_challan_product where delivery_challan_id='$ID'"); 
while($row_product=mysqli_fetch_array($sel_product))
{ 
 
$product_id=$row_product['id'];
$product_name=$row_product['product_name'];
$quantity=$row_product['quantity'];
$total_inward=$row_product['total_inward'];
$rem_inward=$quantity-$total_inward;
if($rem_inward>>0){
$SNo = $SNo + 1;
?>
<hr class="my-2">
<div class="row my-1">
<div class="col-1 py-2">
  <?=$SNo;?>
</div>
<div class="col-9">
<label class="m-0 fw-lighter py-2" for="Product<?=$SNo;?>"><?=$product_name;?></label>
<input type="hidden" name="ProductId[]" value="<?=$product_id;?>">
<input type="hidden" name="product_name[]" value="<?=$product_name;?>">
<!-- <input type="hidden" name="total_dispatch[]" value="<?=$total_dispatch;?>"> -->
</div>

<div class="col-2 pe-0">
<input type="number" class="form-control p-qnt" name="quantity[]" id="quantity<?=$SNo?>" placeholder="Qty"  min="1" max="<?=$rem_inward;?>" value="">

<p class=" mb-0">(<small>Bal- <?=$rem_inward;?></small>)</p>
</div>

</div>


<? } } ?>
</div>
<div class="col-12 mt-3">
<input type="submit" name="Submit" class="btn btn-primary px-3" value="Move to Inward" >

</div>
</div>
<?}?>
</div>
</div>



</form>
</div>
</div>


<? }
$sel_inward=mysqli_query($conn,"select * from delivery_inward where delivery_challan_id = '$ID' order by inward_date desc");  
if(mysqli_num_rows($sel_inward)>>0){ ?>
<div class="<?  if($status!='Received'){echo "col-xl-6";}else{echo "col-xl-10";}?> pe-0">
  <div class="p-3 card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<div class="bg-3f663a text-center mb-3 rounded-1">
  <h5 class="text-white py-1 mb-0">Received Items</h5>
</div>


<div class="col-12 my-1">
  <div class="row " >

<div class="col-3 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Inward Date</label>
</div>
<div class="col-2 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Inward No</label>
</div>
<div class="col-6">
<label for="inputLastName" class="form-label mt-20 mb-0 ms-2 fw-bolder">Product Name</label>
</div>
<div class="col-1 pe-0 ps-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Qty</label>
</div>

</div>
</div>
 
<div class="col-12">
<? 
$SNo = 0;
while($row_inward=mysqli_fetch_array($sel_inward))
{ 
$SNo = $SNo + 1; 
$product_id=$row_inward['id'];
$product_name=$row_inward['product_name'];
$quantity=$row_inward['quantity'];
$inward_date=$row_inward['inward_date'];
$inward_number=$row_inward['inward_number'];

?>

<hr class="my-2">
<div class="row my-1 align-items-center">
<div class="col-3">
<p class="m-0"><?=date("d-m-Y", strtotime($inward_date));?></p>
</div>
<div class="col-2">
<p class="m-0"><?=$inward_number;?></p>
</div>
<div class="col-6">
<p class="m-0"><?=$product_name;?></p>
</div>
<div class="col-1 pe-0 ps-1">
<p class="m-0"><?=$quantity;?></p>
</div>
</div>
<? } ?>
</div>
</div>
<? } ?>
</div>
</div>
</div>
</div></div>



<?php

}

include 'template.php';

?>