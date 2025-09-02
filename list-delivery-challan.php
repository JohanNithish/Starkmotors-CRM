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
$sel_doc_unlink=mysqli_query($conn,"select upload_1, upload_2, upload_3 from delivery_challan where id = '$ID'"); 
$row_file = mysqli_fetch_array($sel_doc_unlink);
if($row_file['upload_1']!=''){
unlink('uploads/'.$row_file['upload_1']);
}
if($row_file['upload_2']!=''){
unlink('uploads/'.$row_file['upload_2']);
}
if($row_file['upload_3']!=''){
unlink('uploads/'.$row_file['upload_3']);
}

	
$challan_DeleteValues = mysqli_query($conn,"delete from delivery_challan where id ='$ID' ");
$challan_ProductDelete = mysqli_query($conn,"delete from delivery_challan_product where delivery_challan_id ='$ID' ");
$challan_inwardDelete = mysqli_query($conn,"delete from delivery_inward where delivery_challan_id ='$ID' ");


if($challan_DeleteValues && $challan_ProductDelete)
{
$alert_msg = 'Delivery Challan Details Successfully';
header('Location:list-delivery-challan.php?alert_msg='.$alert_msg);
}
else
{
$alert_msg = 'Could not able to delete try once again!!!';
header('Location:list-delivery-challan.php?alert_msg='.$alert_msg);
}
}

if($Submit=='Update'){
$update_remark=mysqli_query($conn,"update delivery_challan set customer_remarks = '$remarks', modified_datetime='$currentTime' where  id = '$MainId' ");
if($update_remark)
{
$msg = 'Customer Remarks Updated Successfully';
header('Location:list-delivery-challan.php?msg='.$msg);
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
$select_delivery_challan=mysqli_query($conn,"select * from delivery_challan where 1=1 and returnable_type='Returnable' $subquery"); 




?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase">List Returnable Delivery Challan</h6>

<div class="ms-auto">
<div class="col">
<!-- Button trigger modal -->
<a href="add-delivery-challan.php" class="btn btn-primary">Add Delivery Challan</a>
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


<form action="list-delivery-challan.php" class="" method="post">
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
if(mysqli_num_rows($select_delivery_challan)>>0){ 
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
<th>Delivery<br>Challan No.</th>
<th>Customer<br>Details</th>
<th>Reference No.</th>
<th>Transportation</th>
<th>Net<br>Amount</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_delivery_challan=mysqli_fetch_array($select_delivery_challan))
{ 
$SNo = $SNo + 1; 
$id=$row_delivery_challan['id'];
$customer_name=$row_delivery_challan['customer_name'];
$company_name=$row_delivery_challan['company_name'];
$mobile=$row_delivery_challan['mobile'];
$customer_type=$row_delivery_challan['customer_type'];
$products_count=$row_delivery_challan['products_count'];
$brand_name=$row_delivery_challan['brand_name'];
$product_amount=$row_delivery_challan['product_amount'];
$gst_amount=$row_delivery_challan['gst_amount'];
$total_order_amount=$row_delivery_challan['total_order_amount'];
$status=$row_delivery_challan['status'];
$challan_date=$row_delivery_challan['challan_date'];
$returnable_type=$row_delivery_challan['returnable_type'];
$delivery_challan_number=$row_delivery_challan['delivery_challan_number'];
$reference_number=$row_delivery_challan['reference_number'];
$vechile_number=$row_delivery_challan['vechile_number'];
$transportation_mode=$row_delivery_challan['transportation_mode'];

$inward_date=$row_delivery_challan['inward_date'];
$inward_number=$row_delivery_challan['inward_number'];

if($delivery_challan_number==''){
$delivery_challan_number='-';
}
if($reference_number==''){
$reference_number='-';
}
if($vechile_number==''){
$vechile_number='-';
}
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td><?=date("d-m-Y", strtotime($challan_date));?></td>
<td><?=$delivery_challan_number;?></td>
<td><?if($company_name!='')echo "<b>".$company_name."</b><br>"; ?><?=$customer_name; ?><br><?=$mobile; ?><br><?=$customer_type; ?></td>
<td><?=$reference_number;?></td>
<td><?=$vechile_number;?><br><?=$transportation_mode;?></td>
<td>₹<?=$total_order_amount; ?></td>

<td>
<?if($status=='Received'){?>
<a href="delivery-inward.php?id=<?=$id; ?>" class="btn btn-primary rounded-1">Received</a>
<? }else{ ?>
<a href="delivery-inward.php?id=<?=$id; ?>" class="btn btn-danger rounded-1">Pending</a>
<? } ?>
</td>



<td>
<div class=" order-actions">
<div class="d-flex">
<button type="button" class="btn tbl-btn me-2" tooltip="Remarks" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onclick="getedit(<?=$id; ?>)"><i class="bx bx-comment-add"></i></button>
<a href="add-delivery-challan.php?id=<?=$id; ?>" tooltip="Edit" class="btn btn-add btn-sm"><i class="bx bxs-edit"></i></a>
<a href="#" class="ms-2" data-toggle="modal" tooltip="Delete"  data-target="#customer2" onClick="if(confirm('Are you sure want to delete this?')) { window.location.href='list-delivery-challan.php?act=delete&id=<?=$id ?> ' }"><i class="bx bxs-trash"></i></a>
</div>
<div class="d-flex mt-2">
<a href="view-delivery-challan.php?id=<?=$id; ?>" tooltip="View" class="btn btn-add btn-sm"><i class="lni lni-eye"></i></a>
<a href="export-delivery-challan.php?id=<?=$id; ?>" tooltip="Print" target="_blank" class="btn btn-add btn-sm ms-2"><i class="bx bxs-printer"></i></a>
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
function getedit(val){
$.ajax({
url: "ajax-modal.php", 
type: "POST",
data: "id="+val+"&act=overall_remarks&remarks_table=delivery_challan",
success: function(result){
$("#output").html(result);
}});
}
</script>


<?php
}
include 'template.php';
?>