<?php
function main() {
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$Act=$_GET['act'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
?>

<style type="text/css">
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
</style>

<?  $select_sales=mysqli_query($conn,"select * from service where id='$ID'"); 
if(mysqli_num_rows($select_sales)>>0){ 
$row_sales=mysqli_fetch_array($select_sales);
foreach($row_sales as $K1=>$V1) $$K1 = $V1;
$select_customer=mysqli_query($conn,"select * from customer where id='$customer_id'");
$row_customer=mysqli_fetch_array($select_customer);
$company_name=$row_customer['company_name'];
$customer_type=$row_customer['customer_type'];
$customer_name=$row_customer['customer_name'];
$gst=$row_customer['gst'];
$address=$row_customer['address'];
$mobile=$row_customer['mobile'];
$email=$row_customer['email'];
$pan=$row_customer['pan'];
$pin_code=$row_customer['pin_code'];
$state=$row_customer['state'];
if($pin_code!=''){
  $Pin_code=" - ".$pin_code;
} 
?>
<form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateForm(this)" name="form1">
<div class="row form-label">
<div class="col-xl-6">
<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr fw-3">Customer Details</h5>
<div class="card-body p-5">
<div class="row g-3">
<?  if($customer_name!=''){?>
<div class="col-md-6 pb-2">
<h6 for="inputFirstName" class="form-label mb-0">Name </h6>
</div>

<div class="col-md-6 pb-2">
 <p for="client_name" class="client mb-0"><?=$customer_name;?></p>
</div> 
<? } if($company_name!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Company Name</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
<p for="client_name" class="client mb-0"><?=$company_name;?> </p>
</div>
<? }  if($customer_type!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Customer Type</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
<p for="client_name" class="client mb-0"><?=$customer_type;?> </p>
</div>
<? } if($mobile!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0"> Mobile</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
<p for="client_name" class="client mb-0"><?=$mobile;?></p>
</div>
<? }  if($gst!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">GST</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
<p for="client_name" class="client mb-0"><?=$gst;?> </p>
</div>
<? } if($pan!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">PAN </h6>
</div>

<div class="col-md-6 bdr-tp-gray">
<p for="client_name" class="client mb-0"><?=$pan;?></p>
</div>
<? } if($email!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Email</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
<p for="client_name" class="client mb-0"><?=$email;?> </p>
</div>
<? } if($address!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Address</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$address.' '.$state.$Pin_code; ?></p>
</div> 
<? } ?>
</div>
</div>
</div>

  </div>

  <div class="col-xl-6">

<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr fw-3">Services Details</h5>
<div class="card-body p-5">
<div class="row g-3">
  <? if($status!=''){ ?>
  <div class="col-md-6 pb-2">
<h6 for="inputFirstName" class="form-label text-dark fs-6 alert-link">Status</h6>
</div>

<div class="col-md-6 pb-2">
<p for="client_name" class="mb-1 fs-6 alert-link"><?=$status;?></p>
</div>
<? } if($created_datetime!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Services Date</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=date("d-m-Y", strtotime($created_datetime));?></p>
</div> 
<? } if($company_address !=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Company Name</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?if($company_address==1){echo"Stark Engineers";}else{echo"Stark Motors";}?></p>
</div> 
<? } if($products_count!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">No. of Items</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$products_count;?></p>
</div> 
<? }  if($remarks!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Overall Remarks</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$remarks;?> </p>
</div> 
<? }  ?>


</div>
</div>
</div>


<?   $sel_dispatch=mysqli_query($conn,"select (select count(status) from service_product where service_id = '$ID' and status='Not Delivered') as remDispatch  ");
$row_dispatch=mysqli_fetch_array($sel_dispatch);
$remDispatch=$row_dispatch['remDispatch'];
if($total_delivery==$products_count){
  $RemProduct="Delivered"; 
}else{
   $RemProduct="Remaining ".$remDispatch." products"; 
}
 ?>
<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr fw-3">Delivery Details</h5>
<div class="card-body p-5">
<div class="row g-3">
<?  if($status!=''){ 
 ?>
  <div class="col-md-6 pb-2">
<h6 for="inputFirstName" class="form-label text-dark fs-6 alert-link">Status</h6>
</div>

<div class="col-md-6 pb-2">
<p for="client_name" class="mb-1 fs-6 alert-link" id="remDispatch"><?=$RemProduct;?></p>
</div>
<? } if($products_count!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">No of Dispatches</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$total_delivery;?></p>

</div> 
<? } ?>
</div>
</div>
</div>



</div>


  <div class="col-xl-12">

<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr mb-0">Product Details</h5>
<div class="card-body p-5">

<? 
$sel_not_deiv=mysqli_query($conn,"select * from service_product where service_id = '$ID' and status='Not Delivered'"); 
if(mysqli_num_rows($sel_not_deiv)>>0){ 
?>
  <h5 class="px-2 text-center">Not Delivered</h5>
<hr class="mt-2">
<table class="table w-100 spc-tbl">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Product Name</th>
<th>Motor Serial No</th>
<th>Invoice Number</th>
<th>Warranty</th>
<th>Est. Deliv. Date</th>
<th>Remarks</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_not_deiv=mysqli_fetch_array($sel_not_deiv))
{ 
$SNo = $SNo + 1; 
$dispatch_id=$row_not_deiv['dispatch_id'];
$product_name=$row_not_deiv['product_name'];
$brand_name=$row_not_deiv['brand_name'];
$motor_num=$row_not_deiv['motor_num'];
$invoice_num=$row_not_deiv['invoice_num'];
$warranty=$row_not_deiv['warranty'];
$remarks=$row_not_deiv['remarks'];
$estimated_date=$row_not_deiv['estimated_date'];
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td class="w-30" ><?=$product_name;?></td>
<td class="w-15"><?=$motor_num;?></td>
<td class="w-15"><?=$invoice_num;?></td>
<td class="w-10"><?=$warranty;?></td>
<td class="w-15"><?=date("d-m-Y", strtotime($estimated_date));?></td>
<td><?=$remarks;?></td>
</tr>
<? } ?>
</tbody>
</table>

<? }
$sel_delivered=mysqli_query($conn,"select * from service_product where service_id = '$ID' and status='Delivered' ");
if(mysqli_num_rows($sel_delivered)>>0){ 
 ?>
  <h5 class="px-2 text-center mt-4">Delivered</h5>
<hr class="mt-2">
<table class="table w-100 spc-tbl">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Product Name</th>
<th>Motor Serial No</th>
<th>Invoice Number</th>
<th>Warranty</th>
<th>Deliv. Date</th>
<th>Remarks</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_delivered=mysqli_fetch_array($sel_delivered))
{ 
$SNo = $SNo + 1; 
$dispatch_id=$row_delivered['dispatch_id'];
$product_name=$row_delivered['product_name'];
$brand_name=$row_delivered['brand_name'];
$motor_num=$row_delivered['motor_num'];
$invoice_num=$row_delivered['invoice_num'];
$warranty=$row_delivered['warranty'];
$remarks=$row_delivered['remarks'];
$delivery_date=$row_delivered['delivery_date'];
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td class="w-30"><?=$product_name;?></td>
<td class="w-15"><?=$motor_num;?></td>
<td class="w-15"><?=$invoice_num;?></td>
<td class="w-10"><?=$warranty;?></td>
<td class="w-15"><?=date("d-m-Y", strtotime($delivery_date));?></td>
<td><?=$remarks;?></td>
</tr>
<? } ?>
</tbody>
</table>
<? } ?>
</div>
</div>

  </div>
  </div>


  </div> 
 
</div>
</form>

<? } else { echo "No Records Found";  } ?>



<?php
}
include 'template.php';
?>