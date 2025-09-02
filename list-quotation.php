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
if($act=='delete' && $ID>0) 
{
$quotation_DeleteValues = mysqli_query($conn,"delete from quotation where id ='$ID' ");
$quotation_ProductDelete = mysqli_query($conn,"delete from quotation_product where quotation_id ='$ID' ");
if($quotation_DeleteValues && $quotation_ProductDelete)
{
$alert_msg = 'Quotation Details Successfully';
header('Location:list-quotation.php?alert_msg='.$alert_msg);
}
else
{
$alert_msg = 'Could not able to delete try once again!!!';
header('Location:list-quotation.php?alert_msg='.$alert_msg);
}
}

if($Submit=='Update'){
$update_remark=mysqli_query($conn,"update quotation set remarks = '$remarks', modified_datetime='$currentTime' where  id = '$MainId' ");
if($update_remark)
{
$msg = 'Remarks Updated Successfully';
header('Location:list-quotation.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';    
}
}

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
$select_quotation=mysqli_query($conn,"select * from quotation where 1=1 $subquery"); 





?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase">List Quotation</h6>

<div class="ms-auto">
<div class="col">
<!-- Button trigger modal -->
<a href="add-quotation.php" class="btn btn-primary">Add Quotation</a>
<!-- Modal -->
</div>
</div>
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


<form action="list-quotation.php" class="" method="post">
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
<th>No. of Item</th>
<th>Taxable</th>
<th>GST Amount</th>
<th>Net Amount</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_quotation=mysqli_fetch_array($select_quotation))
{ 
$SNo = $SNo + 1; 
$id=$row_quotation['id'];
$customer_name=$row_quotation['customer_name'];
$company_name=$row_quotation['company_name'];
$mobile=$row_quotation['mobile'];
$customer_type=$row_quotation['customer_type'];
$products_count=$row_quotation['products_count'];
$brand_name=$row_quotation['brand_name'];
$product_amount=$row_quotation['product_amount'];
$gst_amount=$row_quotation['gst_amount'];
$total_order_amount=$row_quotation['total_order_amount'];
$status=$row_quotation['status'];
$created_datetime=$row_quotation['created_datetime'];
    
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td><?=date("d-m-Y", strtotime($created_datetime));?></td>
<td><?if($company_name!='')echo "<b>".$company_name."</b><br>"; ?><?=$customer_name; ?><br><?=$mobile; ?><br><?=$customer_type; ?></td>
<td><?=$products_count;?> <?if($products_count>>'1')echo "Items"; else echo "Item"; ?></td>
<td>₹<?=$product_amount;?></td>
<td>₹<?if($gst_amount!='')echo $gst_amount; else echo "0"; ?></td>
<td>₹<?=$total_order_amount; ?><? $select_log=mysqli_query($conn,"select * from price_log where quotation_id='$id' and category='0' ");
if(mysqli_num_rows($select_log)>>0 && $_SESSION['USERTYPE']==0){ ?>
<a type="button" class="ms-1 text-dark" tooltip="Price Log" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getlog(<?=$id; ?>)"><i class="bx bx-info-circle"></i></a>
<?}?></td>
<td><? if($status=='Approved'){ echo"<p class=\"mt-2\"><span class=\"label-paid rounded-1\">Approved</span></p>";}else {?><a href="add-sales.php?id=<?=$id ?>&act=quotation" class="btn btn-danger" >Pending</a><?}?>
</td>
<td>
<div class=" order-actions">
	<? if($status=='Pending' && $_SESSION['USERTYPE']==0){ ?>
		<div class="d-flex">
<button type="button" class="btn tbl-btn me-2" tooltip="Remarks" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onclick="getedit(<?=$id; ?>)"><i class="bx bx-comment-add"></i></button>
<a href="add-quotation.php?id=<?=$id; ?>" tooltip="Edit" class="btn btn-add btn-sm"><i class="bx bxs-edit"></i></a>
<a href="#" class="ms-2" data-toggle="modal" tooltip="Delete"  data-target="#customer2" onClick="if(confirm('Are you sure want to delete this?')) { window.location.href='list-quotation.php?act=delete&id=<?=$id ?> ' }"><i class="bx bxs-trash"></i></a>
</div><?}else{?>
	<div class="d-flex ">
		<button type="button" class="btn tbl-btn me-2" tooltip="Remarks" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onclick="getedit(<?=$id; ?>)"><i class="bx bx-comment-add"></i></button>
		<a href="add-sales.php?id=<?=$id ?>&act=quotation" tooltip="Repeat Sales" class="btn btn-sm btn-repeat"><i class="lni lni-reload fs-6"></i></a>
	</div>
	<? } ?>
<div class="d-flex mt-2">
<a href="view-quotation.php?id=<?=$id; ?>" tooltip="View" class="btn btn-add btn-sm"><i class="lni lni-eye"></i></a>
<a href="export-quotation.php?id=<?=$id; ?>" tooltip="Print" target="_blank" class="btn btn-add btn-sm ms-2"><i class="bx bxs-printer"></i></a>
</div>

</div>
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