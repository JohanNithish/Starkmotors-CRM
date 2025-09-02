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

<?  $select_sales=mysqli_query($conn,"select * from delivery_challan where id='$ID'"); 
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


<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr fw-3">Price Details</h5>
<div class="card-body p-5">
<div class="row g-3">
<? if($products_count!=''){?>
<div class="col-md-6 pt-2">
<h6 for="inputFirstName" class="form-label mb-0">Taxable</h6>
</div>

<div class="col-md-6 pt-2">
 <p for="client_name" class="client mb-0">₹<?=$product_amount;?> </p>
</div> 
<? }  if($gst_amount!='' && $state=='Tamil Nadu'){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">CGST</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$gst_amount/2;?> </p>
</div> 
<? } if($gst_amount!='' && $state=='Tamil Nadu'){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">SGST</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$gst_amount/2;?> </p>
</div> 
<? } if($gst_amount!='' && $state!='Tamil Nadu'){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">IGST</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$gst_amount;?> </p>
</div> 
<? } if($total_order_amount!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Net Amount</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$total_order_amount;?> </p>
</div> 
<? } ?>


</div>
</div>
</div>


  </div>

  <div class="col-xl-6">

<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr fw-3">Delivery Challan Details</h5>
<div class="card-body p-5">
<div class="row g-3">
<? if($returnable_type!=''){ ?>
<div class="col-md-6 pb-2">
<h6 for="inputFirstName" class="form-label text-dark fs-6 alert-link">Returnable Type</h6>
</div>

<div class="col-md-6 pb-2">
<p for="client_name" class="mb-1 fs-6 alert-link"><?=$returnable_type;?></p>
</div>
<? } if($status!='' && $returnable_type=='Returnable'){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Status</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
<p for="client_name" class="client mb-0"><?=$status;?> </p>
</div>
<? } if($challan_date != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Date</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?= date("d-m-Y", strtotime($challan_date)); ?></p>
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
<? } if($delivery_challan_number != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Delivery Challan Number</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?= $delivery_challan_number; ?></p>
</div>
<? } if($reference_number != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Reference Number</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?= $reference_number; ?></p>
</div>
<? } if($customer_reference_number != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Customer Reference Number</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?= $customer_reference_number; ?></p>
</div>
<? } if($transportation_mode != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Transportation Mode</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?= $transportation_mode; ?></p>
</div>
<? } if($vechile_number != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Vehicle Number</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?= $vechile_number; ?></p>
</div>
<? } if($supply_date != '' && $supply_date != '0000-00-00') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Supply Date</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?= date("d-m-Y", strtotime($supply_date)); ?></p>
</div>
<? } if($eway_number != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Eway Bill No.</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?=$eway_number; ?></p>
</div>
<? } if($supply_place != '') { ?>
<div class="col-md-6 bdr-tp-gray">
  <h6 class="form-label mb-0">Supply Place</h6>
</div>
<div class="col-md-6 bdr-tp-gray">
  <p class="client mb-0"><?=$supply_place; ?></p>
</div>
<? } if($overall_remarks!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Notes</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$overall_remarks;?> </p>
</div> 
<? }  if($customer_remarks!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Customer Remarks</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$customer_remarks;?> </p>
</div> 
<? } if($upload_1!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">File 1</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <a href="uploads/<?=$upload_1; ?>" target="_blank"><img src="assets/images/Our/dox.png" class="mt-2" width="30px"></a>
</div> 
<? } if($upload_2!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">File 2</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <a href="uploads/<?=$upload_2; ?>" target="_blank"><img src="assets/images/Our/dox.png" class="mt-2" width="30px"></a>
</div> 
<? } if($upload_3!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">File 3</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <a href="uploads/<?=$upload_3; ?>" target="_blank"><img src="assets/images/Our/dox.png" class="mt-2" width="30px"></a>
</div> 
<? } ?>


</div>
</div>
</div>

</div>


  <div class="col-xl-12">

<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr">Product Details</h5>
<div class="card-body p-5">
<div class="row g-2 mt-1 mb-3">

<div class="col-md-4 ">
<label for="inputLastName" class="form-label mt-20 mb-0">Product Name</label>

</div>

<div class="w-9">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty</label>
</div>

<div class="col-md-1">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>

  <div class="col-md-1">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (₹)</label>

</div>
<div class="w-22-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>

</div>
<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

</div>


</div>
<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from delivery_challan_product where delivery_challan_id = '$ID'"); 
while($row_product=mysqli_fetch_array($sel_product))
{ 
$SNo = $SNo + 1; 
$product_name=$row_product['product_name'];
$brand_name=$row_product['brand_name'];
$rate=$row_product['rate'];
$quantity=$row_product['quantity'];
$gst=$row_product['gst'];
$gst_amount=$row_product['gst_amount'];
$total_amount=$row_product['total_amount'];
$remarks=$row_product['remarks'];
$sel_mertics=mysqli_query($conn,"select * from product where product = '$product_name'"); 
$row_mertics=mysqli_fetch_array($sel_mertics);



?>

<div class="row py-2 bdr-tp ">

<div class="col-md-4 col-ms-68">
<p class="my-2 lh-1_7"><span class="fw-500"><b><?=$product_name;?></b></span></p>
</div>

<div class="w-9">
<p class="my-2">₹<?=$rate;?></p>
</div>
<div class="w-6">
<p class="my-2"><?=$quantity;?></p>
</div>

<div class="col-md-1 col-ms-22 p-0">
<p class="my-2"><? if($gst=="0"){echo "--";} else{echo $gst."%";}?></p>
</div>
<div class="col-md-1 col-ms-68 ps-0">
<p class="my-2"><? if($gst=="0"){echo "--";} else{echo "₹".$gst_amount;}?></p>
</div>
<div class="w-22-5 ps-0">
<p class="my-2"><? if($remarks!=''){echo $remarks;}else{echo '--';}?></p>
</div>
<div class="w-10 p-0">
<p class="my-2">₹<?=$total_amount;?></p>
</div>


</div>
<? } ?>
<div class="bdr-tp"></div>
  
  <div class="row justify-content-end pt-2">
<div class="w-13 text-end pe-5">
<p class="my-2 fw-bold">Net Amount:</p>
</div>
<div class="w-12 p-0">
<p class="my-2 fw-bold">₹<?=$total_order_amount;?></p>
</div>   
 </div>
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