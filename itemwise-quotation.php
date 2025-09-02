<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$Status=$_GET['status'];
if($Status!=""){
	$subquery=" and status='$Status' ";
}
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$currentDate = date("Y-m-d");



if($fromDate !='' && $endDate !='')
{
$subquery .=" and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}
else{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery .=" and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}
$select_quotation=mysqli_query($conn,"select * from quotation_product where 1=1 $subquery"); 

?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase">List Quotation Items</h6>

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


<form action="itemwise-quotation.php" class="" method="post">
<div class="d-flex gap-2">
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
if(mysqli_num_rows($select_quotation)>>0){ 
?>
<div class="card srch-top ">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Date</th>
<th>Customer Details</th>
<th>Item Name</th>
<th>Rate</th>
<th>Qty</th>
<th>Remarks</th>
<th>Taxable</th>
<th>GST Amount</th>
<th>Net Amount</th>
<th>Status</th>

</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_quotation=mysqli_fetch_array($select_quotation))
{ 
$SNo = $SNo + 1; 
$id=$row_quotation['id'];
$quotation_id=$row_quotation['quotation_id'];
$rate=$row_quotation['rate'];
$Qty=$row_quotation['quantity'];
$product_name=$row_quotation['product_name'];
$product_amount=$row_quotation['product_amount'];
$gst_amount=$row_quotation['gst_amount'];
$total_amount=$row_quotation['total_amount'];
$remarks=$row_quotation['remarks'];

$sel_quotation_no = mysqli_query($conn,"select * from quotation where id='$quotation_id'");
$row_quotation_no = mysqli_fetch_array($sel_quotation_no);
$customer_name=$row_quotation_no['customer_name'];
$company_name=$row_quotation_no['company_name'];
$status=$row_quotation_no['status'];
$created_datetime=$row_quotation_no['created_datetime'];
    
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td><?=date("d-m-Y", strtotime($created_datetime));?></td>
<td><?if($company_name!='')echo "<b>".wordwrap($company_name, 20, "<br />\n")."</b>"; ?></td>
<td><? echo wordwrap($product_name, 20, "<br />\n"); ?></td>
<td>₹<?=$rate;?></td>
<td><?=$Qty;?> </td>
<td><? if($remarks !=''){ echo wordwrap($remarks, 20, "<br />\n"); } else{ echo " - "; }?> </td>
<td>₹<?=$product_amount;?></td>
<td>₹<?if($gst_amount!='')echo $gst_amount; else echo "0"; ?></td>
<td>₹<?=$total_amount; ?></td>
<td><? if($status=='Approved'){ echo"<p class=\"mt-2\"><span class=\"label-paid rounded-1\">Approved</span></p>";}else {?><a href="#" class="btn btn-danger" >Pending</a><?}?>
</td>

</tr>
<? } ?>
</tbody>
</table>
</div>
</div>
</div>
<? } else { echo "No Records Found";  } ?>



<div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header d-flex justify-space-between align-items-center">
<h5 class="mb-0" id="model-heading"></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="card border-top border-0 border-4 border-primary">
<div class="card-body px-2 pb-2 pt-2">

<div id="output"></div>
</div>
</div>
</div>

</div>
</div>
</div>





<script>
function getlog(val){
$('#model-heading').html("PRICE LOG");
$.ajax({
url: "ajax-log.php", 
type: "POST",
data: "id="+val+"&category=0",
success: function(result){
$("#output").html(result);
}});
}
</script>  
<script>
function getedit(val){
$('#model-heading').html("");
$.ajax({
url: "ajax-modal.php", 
type: "POST",
data: "id="+val+"&act=overall_remarks&remarks_table=quotation",
success: function(result){
$("#output").html(result);
}});
}
</script>


<?php
}
include 'template.php';
?>