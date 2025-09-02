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

if($Motor_num!=''){
	$subquery1= " and FIND_IN_SET('$Motor_num', REPLACE(motor_num, '~', ',')) ";
}
if($fromDate !='' && $endDate !='')
{
$subquery =" and (date(dispatch_date) BETWEEN '".$fromDate."' and '".$endDate."') order by created_datetime desc ";
}
else{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery =" and (date(dispatch_date) BETWEEN '".$fromDate."' and '".$endDate."') order by created_datetime desc ";
}

if($Submit=='Add'){
$update_remark=mysqli_query($conn,"update dispatch set remarks = '$remarks' where id='$MainId' ");
if($update_remark)
{
$msg = 'Remarks Updated Successfully';
header('Location:list-dispatch.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';    
}
}


 $select_dispatch=mysqli_query($conn,"select * from dispatch where 1=1 $subquery1 $subquery ");
?>

<h6 class="mb-0 text-uppercase">List Dispatch</h6>
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



<form action="list-dispatch.php" method="post">
<div class="d-flex gap-2">
<div class="col-md-2 mb-20">
<label class="form-label">From Date</label>
<input type="date" class="result form-control" value="<?=$fromDate; ?>" id="fromDate" name="fromDate" required>

</div>
<div class="col-md-2 mb-20">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>" id="endDate"  name="endDate" required>

</div>
<div class="col-md-2 mb-20">
<label class="form-label">Motor Serial No</label>
<input type="text" class="result form-control" value="<?=$Motor_num; ?>" name="Motor_num">

</div>
<div class="col-md-3 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">
<a href="list-dispatch.php" class="btn btn-danger px-3">Clear</a>
</div>
</div> 
</form>

<?  
if(mysqli_num_rows($select_dispatch)>>0){ 
?>

<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Dispatch<br/>Date</th>
<th>LR No</th>
<th>Company Name</th>
<th>Product Name</th>
<th>Qty</th>
<th>Motor Serial No</th>
<th>Invoice No</th>
<th>Dispatch No</th>
<th>Dispatch<br/>Through</th>
<th>Remarks</th>
<? if($_SESSION['USERTYPE']==0){ ?>
<th>Action</th>
<?}?>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_dispatch=mysqli_fetch_array($select_dispatch))
{ 
$SNo = $SNo + 1; 
$id=$row_dispatch['id'];
$sales_id=$row_dispatch['sales_id'];
$product_name=$row_dispatch['product_name'];
$brand_name=$row_dispatch['brand_name'];
$product_amount=$row_dispatch['product_amount'];
$quantity=$row_dispatch['quantity'];
$dispatch_date=$row_dispatch['dispatch_date'];
$created_datetime=$row_dispatch['created_datetime'];
$motor_num=$row_dispatch['motor_num'];
$document_num=$row_dispatch['document_num'];
$dispatch_num=$row_dispatch['dispatch_num'];
$po_reference=$row_dispatch['po_reference'];
$dispatch_through=$row_dispatch['dispatch_through'];
$test_report=$row_dispatch['test_report'];
$select_customer=mysqli_query($conn,"select * from order_confirmation where id='$sales_id'");
$row_customer=mysqli_fetch_array($select_customer);
$company_name=$row_customer['company_name'];

?>
<tr>
<td class="d-none"><?=$SNo; ?></td>
<td><?=date("d-m-Y", strtotime($dispatch_date));?></td>

<td><?=wordwrap($po_reference, 10, "<br/>\n");?></td>
<td><?=wordwrap($company_name, 20, "<br/>\n");?></td>
<td><?=wordwrap($product_name, 20, "<br/>\n");?></td>
<td><?=$quantity;?></td>
<td><? $Motor_Num=str_replace("~",", ",$motor_num); echo wordwrap($Motor_Num, 15, "<br />\n"); ?></td>
<td><?=$document_num;?></td>

<td><?=wordwrap($dispatch_num, 10, "<br/>\n");?></td>
<td><?=wordwrap($dispatch_through, 20, "<br/>\n");?></td>
<td class="order-actions"><button type="button" class="btn tbl-btn" tooltip="Remarks" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$id ?>)"><i class="bx bx-comment-add"></i></button>
</td><? if($_SESSION['USERTYPE']==0){ ?>
<td class="order-actions d-flex gap-2">
	<a href="add-test-reports.php?id=<?=$id; ?>" tooltip="Test Report" class="btn btn-add btn-sm"><i class="bx bxs-book-add"></i></a>
	<a href="edit-dispatch.php?id=<?=$id; ?>" tooltip="Edit" class="btn btn-add btn-sm"><i class="bx bxs-edit"></i></a>
</td><? } ?>
</tr>
<? } ?>
</tbody>
</table>
</div>
</div>
</div>
<? } else { echo "No Records Found";  } ?>


<div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-xl">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="card border-top border-0 border-4 border-primary">
<div class="card-body p-5">

<div id="output"></div>
</div>
</div>
</div>

</div>
</div>
</div>
 <script src="assets/plugins/ckeditor/ckeditor.js"></script>


<script type="text/javascript">
function getDate(val){
if(val!='Pending' && ($('#fromDate').val()=='') && ($('#endDate').val()=='') ){
	$('#fromDate').val('<?=date("Y-m-d", strtotime("-1 Month", strtotime($currentDate)));?>')
	$('#endDate').val('<?=$currentDate;?>');
}
}


function getedit(val){

$.ajax({
url: "ajax-modal.php", 
type: "POST",
data: "id="+val+"&act=dispatch_remarks",
success: function(result){
$("#output").html(result);
}});
}

</script>
<?php
}
include 'template.php';
?>