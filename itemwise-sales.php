<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
$Status=$status;

if($Submit=='Update'){
$update_remark=mysqli_query($conn,"update order_confirmation set remarks = '$remarks', modified_datetime='$currentTime' where  id = '$MainId' ");
if($update_remark)
{
$msg = 'Remarks Updated Successfully';
header('Location:list-sales.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';    
}
}


if($status=='Pending' && $fromDate !='' && $endDate !='')
{
$subquery =" and status='Approved' and (date(invoice_date) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}

elseif($status=='Dispatched' && $fromDate !='' && $endDate !='')
{
$subquery ="  and status='Dispatched' and (date(dispatch_date) BETWEEN '".$fromDate."' and '".$endDate."') order by modified_datetime desc ";
}
elseif($status=='Dispatched' && $fromDate =='' && $endDate =='')
{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery ="  and status='Dispatched' and (date(dispatch_date) BETWEEN '".$fromDate."' and '".$endDate."') order by modified_datetime desc ";
}

elseif($status=='All' && $fromDate !='' && $endDate !='')
{
$subquery =" and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}
elseif($status=='All' && $fromDate =='' && $endDate =='')
{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery =" and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}
else{
   $subquery ="and status='Approved' order by id desc ";
}

 $select_sales=mysqli_query($conn,"select * from order_confirmation where 1=1  $subquery ");


?>


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase">List Sales</h6>

</div>
<hr/>

<? if($msg !=''){ ?><div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
<div class="d-flex align-items-center">
<div class="font-35 text-white"><i class="bx bxs-check-circle"></i>
</div>
<div class="ms-3">
<h6 class="mb-0 text-white">Success Alerts</h6>
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
<h6 class="mb-0 text-white">Alerts</h6>
<div class="text-white"><?=$alert_msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>

<form action="itemwise-sales.php" method="post">
<div class="d-flex gap-2">
<div class="mb-20">

<label for="inputAddress" class="form-label width-100" >Status</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" onchange="getDate(this.value)" id="inlineRadio1" value="Pending" <? if($status =='Pending' || $status=='') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">Pending</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio2" onchange="getDate(this.value)" value="Dispatched" <? if($status =='Dispatched') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio2">Dispatched </label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio3" onchange="getDate(this.value)" value="All" <? if($status =='All') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio3">All</label>
</div>

</div>
<div class="col-md-2 mb-20">
<label class="form-label">From Date</label>
<input type="date" class="result form-control" value="<?=$fromDate; ?>" id="fromDate" name="fromDate" required>

</div>
<div class="col-md-2 mb-20">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>" id="endDate"  name="endDate" required>

</div>

<div class="col-md-3 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">

</div>
</div> 
</form>

<?  
if(mysqli_num_rows($select_sales)>>0){ 
?>

<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<?if($Status!='Pending' && $Status!=''){?>
<th>Dispatch<br>Date</th><?}?>
<th>PO<br>Date</th>
<th>Job<br>Card No</th>
<th>Customer<br>PO No</th>
<th>Customer<br>Details</th>
<th>Item<br> Name</th>
<th>Rate</th>
<th>Qty</th>
<th>Remarks</th>
<th>Taxable</th>
<th>GST <br>Amount</th>
<th>Net <br>Amount</th>
<th>Converted<br>Time Period</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_sales=mysqli_fetch_array($select_sales))
{ 
$SNo = $SNo + 1; 
$id=$row_sales['id'];
$customer_name=$row_sales['customer_name'];
$company_name=$row_sales['company_name'];
$quotation_id=$row_sales['quotation_id'];
$mobile=$row_sales['mobile'];
$customer_type=$row_sales['customer_type'];
$enquiry_num=$row_sales['enquiry_num'];
$refered_by=$row_sales['refered_by'];
$estimated_delivery=$row_sales['estimated_delivery'];
$invoice_date=$row_sales['invoice_date'];
$created_datetime=$row_sales['created_datetime'];
$dispatch_date=$row_sales['dispatch_date'];
$status=$row_sales['status'];
$select_timePeriod=mysqli_query($conn,"select created_datetime from quotation where id='$quotation_id' ");
$row_timePeriod=mysqli_fetch_array($select_timePeriod);
$quotation_createdDate=$row_timePeriod['created_datetime'];
$date1 = new DateTime(explode(" ", $quotation_createdDate)[0]);
$date2 = new DateTime(explode(" ", $created_datetime)[0]);
$interval = $date1->diff($date2);
$Converted_days = $interval->days;
if($Converted_days==0){
   $Sales_conv='Same Day';
}elseif($Converted_days==1){
   $Sales_conv=$Converted_days.' Day';
}else{
   $Sales_conv=$Converted_days.' Days';
}
$sel_products = mysqli_query($conn,"select * from ordered_products where sales_id='$id'");

while($row_productssales=mysqli_fetch_array($sel_products))
{

$rate=$row_productssales['rate'];
$Qty=$row_productssales['quantity'];
$product_name=$row_productssales['product_name'];
$product_amount=$row_productssales['product_amount'];
$gst_amount=$row_productssales['gst_amount'];
$total_amount=$row_productssales['total_amount'];
$remarks=$row_productssales['remarks'];

?>
<tr>
<!-- <?=date("d-m-Y", strtotime($dispatch_date));?> -->
<td class="d-none"><?=$SNo; ?></td>
<?if($status=='Dispatched' || $Status=='All'){?>
<td><? if($dispatch_date!=NULL){echo date("d-m-Y", strtotime($dispatch_date));}else{echo "--";}?></td><?}?>
<td><?=date("d-m-Y", strtotime($invoice_date));?></td>
<td><?=$refered_by; ?></td>
<td><?=$enquiry_num; ?></td>
<td><?if($company_name!='')echo "<b>".wordwrap($company_name, 20, "<br />\n")."</b>"; ?></td>
<td><? echo wordwrap($product_name, 20, "<br />\n"); ?></td>
<td>₹<?=$rate;?></td>
<td><?=$Qty;?> </td>
<td><? if($remarks !=''){ echo wordwrap($remarks, 20, "<br />\n"); } else{ echo " - "; }?> </td>
<td>₹<?=$product_amount;?></td>
<td>₹<?if($gst_amount!='')echo $gst_amount; else echo "0"; ?></td>
<td>₹<?=$total_amount; ?></td>
<td><b><?=$Sales_conv; ?></b><br>
<?=date("d-m-Y", strtotime($quotation_createdDate))." to<br>".date("d-m-Y", strtotime($created_datetime)); ?></td>
<td><? if($status=='Dispatched'){ echo"<p class=\"mt-2\"><span class=\"label-paid rounded-1\">Dispatched</span></p>";}else {?>
   <a href="#" class="btn btn-danger">Pending</a><?}?>
</td>

</tr>
<? } } ?>
</tbody>
</table>
</div>
</div>
</div>
<? } else { echo "No Records Found";  } 
if($fromDate=='' || $endDate==''){
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
}?>

<script type="text/javascript">
function getDate(val){
if(val!='Pending' && ($('#fromDate').val()=='') && ($('#endDate').val()=='') ){
   $('#fromDate').val('<?=$fromDate?>');
   $('#endDate').val('<?=$endDate;?>');
}
}
function getlog(val){
$('#model-heading').html("PRICE LOG");
$.ajax({
url: "ajax-log.php", 
type: "POST",
data: "id="+val+"&category=1",
success: function(result){
$("#output").html(result);
}});
}

</script>

<?php
}
include 'template.php';
?>