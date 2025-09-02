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

<?  $select_sales=mysqli_query($conn,"select * from quotation where id='$ID'"); 
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
  <h5 class="p-2 text-center view-hdr fw-3">Quotation Details</h5>
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
<h6 for="inputFirstName" class="form-label mb-0">Quotation Date</h6>
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
<? } if($products_count!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Taxable</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$product_amount;?> </p>
</div> 
<? } if($gst_amount!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">CGST</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$gst_amount/2;?> </p>
</div> 
<? } if($gst_amount!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">SGST</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$gst_amount/2;?> </p>
</div> 
<? } if($freight_charges!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Freight Amount</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$freight_charges;?> </p>
</div> 
<? } if($freight_gst!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Freight GST</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$freight_gst;?> %</p>
</div> 
<? } if($total_freight!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Total Freight Amount</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$total_freight;?> </p>
</div> 
<? } if($total_order_amount!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Net Amount</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0">₹<?=$total_order_amount;?> </p>
</div> 
<? } if($terms_condition!=''){?>
<div class="col-md-6 bdr-tp-gray">
<h6 for="inputFirstName" class="form-label mb-0">Terms & Conditions</h6>
</div>

<div class="col-md-6 bdr-tp-gray">
 <p for="client_name" class="client mb-0"><?=$terms_condition;?> </p>
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

</div>


  <div class="col-xl-12">

<div class="card border-0 border-4 ">
  <h5 class="p-2 text-center view-hdr">Product Details</h5>
<div class="card-body p-5">
<div class="row g-2 mt-1 mb-3">

<div class="col-md-3 ">
<label for="inputLastName" class="form-label mt-20 mb-0">Product Name</label>

</div>
<div class="w-12">
<label for="inputLastName" class="form-label mt-20 mb-0">Brand Name</label>

</div>
<div class="w-9">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty</label>
</div>
<div class="col-md-1">
<label for="inputLastName" class="form-label mt-20 mb-0">Pkg</label>
</div>
<div class="col-md-1">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>

  <div class="col-md-1">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (₹)</label>

</div>
<div class="w-13">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>

</div>
<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

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
$gst_amount=$row_product['gst_amount'];
$total_amount=$row_product['total_amount'];
$remarks=$row_product['remarks'];
$estimated_delivery=$row_product['estimated_delivery'];
$package_amount=$row_product['package_amount'];
$sel_mertics=mysqli_query($conn,"select * from product where product = '$product_name'"); 
$row_mertics=mysqli_fetch_array($sel_mertics);
if($row_mertics['kw']!=''){ $kw="<span class=\"fw-500\">  Kw: </span>".$row_mertics['kw'].",";}else{$kw="";}
if($row_mertics['hp']!=''){ $hp="<span class=\"fw-500\">  Hp: </span>".$row_mertics['hp'].",";}else{$hp="";}
if($row_mertics['rpm']!=''){ $rpm="<span class=\"fw-500\">  Rpm: </span>".$row_mertics['rpm'].",";}else{$rpm="";}
if($row_mertics['volt']!=''){ $volt="<span class=\"fw-500\">  Volt: </span>".$row_mertics['volt'].",";}else{$volt="";}
if($row_mertics['type']!=''){ $type="<span class=\"fw-500\">  Type: </span>".$row_mertics['type'].",";}else{$type="";}
if($row_mertics['mounting']!=''){ $mounting="<span class=\"fw-500\">  Mounting: </span>".$row_mertics['mounting'].",";}else{$mounting="";}
if($row_mertics['ins_cl']!=''){ $ins_cl="<span class=\"fw-500\">  INS.CL: </span>".$row_mertics['ins_cl'].",";}else{$ins_cl="";}

if($row_mertics['degree']!=''){ $degree="<span class=\"fw-500\">  Degree: </span>".$row_mertics['degree'].",";}else{$degree="";}
if($row_mertics['frequency']!=''){ $frequency="<span class=\"fw-500\">  Frequency: </span>".$row_mertics['frequency'].",";}else{$frequency="";}
if($row_mertics['frame']!=''){ $frame="<span class=\"fw-500\">  Frame: </span>".$row_mertics['frame'].",";}else{$frame="";}


if($row_mertics['model']!=''){ $model="<span class=\"fw-500\">  Model: </span>".$row_mertics['model'].",";}else{$model="";}
if($row_mertics['efficiency']!=''){ $efficiency="<span class=\"fw-500\">  Efficiency: </span>".$row_mertics['efficiency'].",";}else{$efficiency="";}
if($row_mertics['special_requirements']!=''){ $special_requirements="<span class=\"fw-500\">  Special Requirements: </span>".$row_mertics['special_requirements'].",";}else{$special_requirements="";}


if($kw!="" || $hp!="" || $rpm!="" || $volt!="" || $type!="" || $mounting!="" || $ins_cl!="" || $degree!="" ){
$metrics=rtrim("<br>".$model.$kw.$hp,',');
$metrics.=rtrim("<br>".$rpm.$volt.$type,',');
$metrics.=rtrim("<br>".$mounting.$ins_cl,',');
$metrics.=rtrim("<br>".$degree.$frequency,',');
$metrics.=rtrim("<br>".$frame.$efficiency,',');
$metrics.=rtrim("<br>".$special_requirements,',');
$metrics = rtrim($metrics, '<br>');
}
else{
   $metrics="";
}
?>

<div class="row py-2 bdr-tp ">

<div class="col-md-3 col-ms-68">
<p class="my-2 lh-1_7"><span class="fw-500"><b><?=$product_name;?></b></span><?=$metrics;?></p>
<? if($estimated_delivery!=''){?><p class="align-self-end mb-2 w-100"><b>Est. Deliv. Date: </b> <? echo date("d-m-Y", strtotime($estimated_delivery));?></p><?}?>
</div>
<div class="w-12">
<p class="my-2"><?=$brand_name;?></p>
</div>
<div class="w-9">
<p class="my-2">₹<?=$rate;?></p>
</div>
<div class="w-6">
<p class="my-2"><?=$quantity;?></p>
</div>
<div class="col-md-1 col-ms-22 p-0">
<p class="my-2">₹<?=$package_amount;?></p>
</div>
<div class="col-md-1 col-ms-22 p-0">
<p class="my-2"><? if($gst=="0"){echo "--";} else{echo $gst."%";}?></p>
</div>
<div class="col-md-1 col-ms-68 ps-0">
<p class="my-2"><? if($gst=="0"){echo "--";} else{echo "₹".$gst_amount;}?></p>
</div>
<div class="w-13 ps-0">
<p class="my-2"><? if($remarks!=''){echo $remarks;}else{echo '--';}?></p>
</div>
<div class="w-10 p-0">
<p class="my-2">₹<?=$total_amount;?></p>
</div>


</div>
<? } ?>
<div class="bdr-tp"></div>
<? if($total_freight!=''){ ?>
 <div class="row justify-content-end pt-2">
  <div class="w-13 text-end pe-5">
<p class="my-2 fw-bold">Freight Charges:</p>
</div>
<div class="w-10 p-0">
<p class="my-2 fw-bold">₹<?=$total_freight;?></p>
</div> 
 </div>
 <?}?>
  <div class="row justify-content-end pt-2">
<div class="w-13 text-end pe-5">
<p class="my-2 fw-bold">Net Amount:</p>
</div>
<div class="w-10 p-0">
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