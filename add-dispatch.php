<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$Act=$_GET['act'];
if($Act!="dispatch"){
 header('Location:list-sales.php');
}
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

$currentDate=date('Y-m-d');

if($Submit=='Move to Dispatch')
{
if(empty(array_filter($document_num))){
  $CountNum=0;
}else{
  $CountNum=count($document_num);
}
if($CountNum>0){
$dispatch_num=addslashes($dispatch_num);
$dispatch_date=addslashes($dispatch_date);
$CountId=count($ProductId);
$tot_count = 0;
$check_id=0;
for($i=0; $i<$CountId; $i++)
  {    
$x=$i+1;
$motornum=$_POST['motor_num'.$x];

if($motornum != '')
{  
 $tot_count = $tot_count +1;
if(count($motornum)>1){
$Motor_num=implode("~",$motornum);
}else{
$Motor_num=$motornum[0]; 
}
$Quantity=addslashes($quantity[$i]);
$Document_num=addslashes($document_num[$i]);

$Total_dispatch=$Quantity+$total_dispatch[$i];
$rs_UpdValues=mysqli_query($conn,"update ordered_products set total_dispatch = '$Total_dispatch', modified_datetime = '$currentTime' where id='$ProductId[$i]' ");
$rs_InsValues=mysqli_query($conn,"insert into dispatch set sales_id='$ID', customer_id='$customer_id', product_name='$product_name[$i]', sales_product_id='$ProductId[$i]', motor_num='$Motor_num', quantity='$Quantity', document_num='$Document_num', dispatch_num = '$dispatch_num', dispatch_date = '$dispatch_date', dispatch_through = '$dispatch_through',  po_reference = '$refered_by',  created_datetime = '$currentTime' ");
 $mess_Motor_Num=str_replace("~",", ",$Motor_num);
$check_id=$ProductId[$x];
$message_table.='<tr>
<td style="padding:5px;">'.$product_name[$i].'</td>
<td style="padding:5px;">'.$Quantity.'</td>
<td style="padding:5px;">'.date("d-m-Y", strtotime($dispatch_date)).'</td>
<td style="padding:5px;">'.wordwrap($mess_Motor_Num, 24, "<br />\n").'</td>
<td style="padding:5px;">'.$Document_num.'</td>
</tr>';
  }
}

$select_date=mysqli_query($conn,"select (select MAX(dispatch_date) from dispatch where sales_id='$ID') as maxdate, (select COUNT(quantity) from ordered_products where quantity=total_dispatch and sales_id='$ID') as TotalCount, (select products_count from order_confirmation where id='$ID') as TotalProducts");
  $row_date=mysqli_fetch_array($select_date);
  $TotalCount=$row_date['TotalCount']; 
  $maxdate=$row_date['maxdate'];
  $TotalProducts=$row_date['TotalProducts'];
  if($TotalCount==$TotalProducts){
    $update_product=mysqli_query($conn,"update order_confirmation set dispatch_date='$maxdate', status='Dispatched', modified_datetime = '$currentTime' where id='$ID' ");
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


$message='<div class="adds-titl" style="text-align:center;"><a href="www.starkmotors.com" target="_blank" style="text-align:center;"><img src="https://crm.starkmotors.com/assets/images/Our/logo2.png" width="135px;"></a>
<h3>'.$company_add.'</h3></div> <div style="max-width: 85%;margin: auto;padding: 20px;border: 1px solid #dddddd;border-radius: 10px;">
        <h2 style="color: #333333;">Your Order Has Been Successfully Dispatched!</h2>
        <p><b>Hi </b> '.$to_name.',</p>
        <p>We are pleased to inform you that your order has been successfully dispatched. Please find the details of your order below:</p>
        <div style="display:flex;">
        <div style="width:50%;">
        <p style="margin: 5px 0px;"><b>PO No: </b>PO'.$ID.'</b></p>
        <p style="margin: 5px 0px;"><b>PO Date: </b>'.date('d-m-Y', strtotime($invoice_date)).' </b></p>
        <p style="margin: 5px 0px;"><b>LR No: </b>'.$refered_by.'</p>
        </div>
        <div style="width:50%;text-align:right;">
        <p style="margin: 5px 0px;"><b>Dispatch No: </b>'.$dispatch_num.'</b></p>
        <p style="margin: 5px 0px;"><b>Dispatch Through: </b>'.$dispatch_through.' </b></p>
        </div>
        </div>
       ';
      $message .='<table style="margin-top:10px;width:100%;">
<thead style="text-align: left;background: #cdcdcd;">
<tr>
<th style="padding:10px 5px">Product Name</th>
<th style="padding:10px 5px">Qty</th>
<th style="padding:10px 5px">Dispatch Date</th>
<th style="padding:10px 5px">Motor Serial No</th>
<th style="padding:10px 5px">Invoice No</th>
</tr>
</thead>
<tbody>'.$message_table.'</tbody></table></div>';


$message.='<div style="max-width: 85%;margin: auto;">
<div width="9" height="30"><br><br>&nbsp;Best regards, <br><br>    </div>
<div width="782" height="30"><strong><a href="https://starkmotors.com/" style="color:#000;">&nbsp;'.$company_add.'</a> </strong>
<div width="10" height="30">&nbsp;</div>
</div>';

$subject="Your Order Dispatched for PO".$ID;
$stark_subject="Order Dispatched for PO".$ID;

        $to=$email;
        $stark_mail="mktg.starkmotors@gmail.com";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'Sender: <noreply@starkmotors.com>' . "\r\n";
        $headers .= 'From: Stark Motors<noreply@starkmotors.com>' . "\r\n";
        $headers .= 'Bcc: <support@starkmotors.com>' . "\r\n";
        $headers .= 'Reply-To: Stark Motors <noreply@starkmotors.com>' . "\r\n";   
        $res1=mail($to , $subject, $message, $headers, '-fnoreply@starkmotors.com');
        $res2=mail($stark_mail , $stark_subject, $message, $headers, '-fnoreply@starkmotors.com');
      $msg = 'Product Dispatched Successfully';
     header('Location:list-dispatch.php?msg='.$msg);
   }
   else
   {
      $alert_msg = 'Could not able to add try once again!!!';     
   }
}
else{
  $alert_msg = 'Please dispatch at least one item.';   
}

}

$sel_values=mysqli_query($conn,"select * from order_confirmation where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
$customer_id=$row_values['customer_id'];
$mobile=$row_values['mobile'];
$customer_type=$row_values['customer_type'];
$enquiry_num=$row_values['enquiry_num'];
$refered_by=$row_values['refered_by'];
$invoice_date=$row_values['invoice_date'];
$estimated_delivery=$row_values['estimated_delivery'];
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
  <h5 class="text-uppercase mb-0">Move to Dispatch</h5>
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
<input type="text" class="form-control" name="refered_by" value="" Placeholder="LR No" required>
<input type="hidden" name="customer_id" value="<?=$customer_id;?>">
</div>


<div class="col-xl-2 mt-3">
<label for="inputLastName" class="form-label mt-20">Dispatch Date</label>
<input type="date" class="form-control" name="dispatch_date" value="<?=$currentDate;?>" required>
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
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Qty</label>
</div>

<div class="w-20 ms-2 ">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Invoice No</label>

</div>

<div class="w-20 px-1 d-flex flex-wrap align-items-center d-none" id="Motor_title">
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
<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from ordered_products where quantity!=total_dispatch and sales_id = '$ID'"); 
while($row_product=mysqli_fetch_array($sel_product))
{ 
$SNo = $SNo + 1; 
$product_id=$row_product['id'];
$product_name=$row_product['product_name'];
$quantity=$row_product['quantity'];
$package_percent=$row_product['package_percent'];
$motor_num=$row_product['motor_num'];
$document_num=$row_product['document_num'];
$total_dispatch=$row_product['total_dispatch'];

?>
<hr class="my-2">
<div class="row my-1">
<div class="w-3 py-2">
  <?=$SNo;?>
</div>
<div class="w-32">
<label class="m-0 fw-lighter py-2" for="Product<?=$SNo;?>"><?=$product_name;?></label>
<input type="hidden" name="ProductId[]" value="<?=$product_id;?>">
<input type="hidden" name="product_name[]" value="<?=$product_name;?>">
<input type="hidden" name="total_dispatch[]" value="<?=$total_dispatch;?>">
</div>

<div class="w-17 pe-0">
  <div class="d-flex flex-wrap align-items-center">
<input type="number" class="form-control p-qnt w-50" name="quantity[]" id="quantity<?=$SNo?>" placeholder="Qty"  min="1" max="<?=$quantity-$total_dispatch;?>" value=" " onchange="maxValue(this,this.value,'<?=$quantity-$total_dispatch;?>');setList(<?=$SNo?>,'<?=$product_id;?>','<?=$product_name;?>','<?=$total_dispatch;?>');">

<p class="ms-2 mb-0">(<small>Bal- <?=$quantity-$total_dispatch;?></small>)</p>
</div>
</div>
<div class="w-20 pe-0">
<input type="text" class="form-control p-qnt" id="document_num<?=$SNo?>" name="document_num[]" placeholder="Invoice No"  value="" >
</div>
<div class="w-25 pe-0" id="show<?=$SNo?>">

</div>
</div>


<? } ?>
</div>
<div class="col-12 mt-3">
<input type="submit" name="Submit" class="btn btn-primary px-3" value="Move to Dispatch" >
<a href="add-dispatch.php?id=<?=$ID;?>&act=dispatch"  class="btn btn-danger" >Clear All</a>



</div>
</div>
<?}?>
</div>
</div>
</div>
</div></div></div></div>
</form>


<div class="card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<div class="card-body p-5">
<div class="bg-3f663a text-center mt-1 mb-3 rounded-1">
  <h5 class="text-white py-1">Dispatched</h5>
</div>
<? 
$sel_dispatch=mysqli_query($conn,"select * from dispatch where sales_id = '$ID' order by id desc");  
if(mysqli_num_rows($sel_dispatch)>>0){ ?>

<div class="col-12 my-3">
  <div class="row " >
<div class="w-40">
<label for="inputLastName" class="form-label mt-20 mb-0 ms-2 fw-bolder">Product Name</label>
</div>
<div class="w-5 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Qty</label>
</div>
<div class="w-10 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Dispatch Date</label>
</div>
<div class="w-10 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Dispatch No</label>
</div>
<div class="w-15 pe-0">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Motor Serial No</label>
</div>

<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Invoice No</label>
</div>
<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0 fw-bolder">Dispatch Through</label>
</div>
 </div>
 </div>
 <?}else echo"<div class=\"col-5\"><p class=\"ms-2 mb-0\">Not dispatched yet.</p></div>";?>
<div class="col-12">
<? 
$SNo = 0;
while($row_dispatch=mysqli_fetch_array($sel_dispatch))
{ 
$SNo = $SNo + 1; 
$product_id=$row_dispatch['id'];
$product_name=$row_dispatch['product_name'];
$quantity=$row_dispatch['quantity'];
$package_percent=$row_dispatch['package_percent'];
$motor_num=$row_dispatch['motor_num'];
$dispatch_date=$row_dispatch['dispatch_date'];
$document_num=$row_dispatch['document_num'];
$dispatch_num=$row_dispatch['dispatch_num'];
$dispatch_through=$row_dispatch['dispatch_through'];
?>
<hr class="my-2">
<div class="row my-1 align-items-center">
<div class="w-40">
<p class="m-0"><?=$product_name;?></p>
</div>
<div class="w-5">
<p class="m-0"><?=$quantity;?></p>
</div>
<div class="w-10">
<p class="m-0"><?=date("d-m-Y", strtotime($dispatch_date));?></p>
</div>
<div class="w-10">
<p class="m-0"><?=$dispatch_num;?></p>
</div>
<div class="w-15">
<p class="m-0"><? $Motor_Num=str_replace("~",", ",$motor_num); echo wordwrap($Motor_Num, 24, "<br />\n"); ?></p>
</div>

<div class="w-10"><p class="m-0"><?=$document_num;?></p>
</div>
<div class="w-10"><p class="m-0"><?=$dispatch_through;?></p>
</div>
</div>
<? } ?>
</div>
</div>
</div>
<script type="text/javascript">
function maxValue(obj,val,maxVal) {
if (parseInt(val) >= parseInt(maxVal)) {
$(obj).val(maxVal);
}
}

function setList(val,product_id,product_name,total_dispatch){
quantity_count=$("#quantity"+val).val();
$("#show"+val).html(" ");
if(quantity_count>0){
$("#document_num"+val).attr("required", "true");
$("#Motor_title").removeClass("d-none");
for (let i = 1; i <= quantity_count; i++) {
  if(i<=9){num_0="0";}else{num_0="";}
$("#show"+val).append('<div class="d-flex mb-2 gap-2 align-items-center"><div class=" pe-0">'+num_0+i+'</div><div class="pe-0 "><input type="text" class="form-control p-qnt" id="motor_num'+i+'" name="motor_num'+val+'[]" placeholder="Motor Serial No"  value="" required ></div></div>');
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