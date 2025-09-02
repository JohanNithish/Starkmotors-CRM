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
	$motQurery=" and FIND_IN_SET('$Motor_num', REPLACE(motor_num, '~', ','))  ";
}

if($fromDate !='' && $endDate !='' && ($status=='' || $status=='Approved' && $Motor_num!='' ))
{
$select_dispatch=mysqli_query($conn,"select * from dispatch where (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') $motQurery order by created_datetime desc  ");
}
elseif($fromDate !='' && $endDate !='' && $status=='Approved' && $Motor_num=='')
{
$select_dispatch=mysqli_query($conn,"select * from ordered_products where quantity!=total_dispatch and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by created_datetime desc ");
}
else{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$select_dispatch=mysqli_query($conn,"select * from dispatch where (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by created_datetime desc  ");
}

if($status==''){
$select_tot=mysqli_query($conn,"select (select COALESCE(SUM(total_dispatch),0) from ordered_products where (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."')) as NumDispatched, (select COALESCE(SUM(quantity),0) from ordered_products where 1=1 and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') ) as TotalDispatch  ");
$row_tot=mysqli_fetch_array($select_tot);
$NumDispatched=$row_tot['NumDispatched'];
$TotalDispatch=$row_tot['TotalDispatch'];
$Show_Status='<span class="text-danger ">'.$NumDispatched.'/'.$TotalDispatch.'</span> items dispatched.';
}elseif($status=='Approved'){
	$select_pending_dis=mysqli_query($conn,"select (select COALESCE(SUM(quantity - total_dispatch),0) from ordered_products where 1=1 and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."')) as PendingDispatch  ");
	$row_pending_tot=mysqli_fetch_array($select_pending_dis);
	$PendingDispatch=$row_pending_tot['PendingDispatch'];
$Show_Status='<span class="text-danger ">'.$PendingDispatch.'</span> items pending.';
}

?>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Reports</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="home.php"><i class="bx bx-home-alt color-af251c"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">List Dispatch</li>
</ol>
</nav>
</div>
</div>

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




<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<div class="d-flex gap-2">
<div class="mb-10">
<label for="inputAddress" class="form-label width-100" >Status</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="" <? if($status =='' || $Motor_num !='') { echo 'checked';}?>>
<label class="form-check-label" for="inlineRadio2">Dispatched</label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="Approved" <? if($status =='Approved' && $Motor_num =='') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">Pending</label>
</div>

</div>

<div class="col-md-2 mb-20">
<label class="form-label">From Date</label>
<input type="date" class="result form-control" value="<?=$fromDate; ?>" name="fromDate">

</div>
<div class="col-md-2 mb-20">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>" name="endDate">

</div>
<div class="col-md-2 mb-20">
<label class="form-label">Motor Serial No</label>
<input type="text" class="result form-control" value="<?=$Motor_num; ?>" name="Motor_num">

</div>
<div class="col-md-2 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">
<a href="dispatch-report.php" class="btn btn-danger px-3">Clear</a>

</div>
</div> 
</form>

<?  
if(mysqli_num_rows($select_dispatch)>>0){ 
	if($Motor_num==""){
?>
<div class="pb-3 d-flex gap-4"><h5>Dispatch Status: <small><?=$Show_Status;?></small></h5> </div><?}?>
<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Dispatch<br/>Date</th>
<th>PO No</th>
<th>LR No</th>
<th>Company Name</th>
<th>Product Name</th>
<th><?if($Status=='Approved' && $Motor_num =='' ){echo "Remaining Qty </th>";}else{ echo " Qty</th>";?>
<th>Motor Serial No</th>
<th>Document No</th>
<th>Dispatch No</th>
<th>Dispatch<br/>Through</th><?}?>
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
$total_dispatch=$row_dispatch['total_dispatch'];
$select_customer=mysqli_query($conn,"select * from order_confirmation where id='$sales_id'");
$row_customer=mysqli_fetch_array($select_customer);
$company_name=$row_customer['company_name'];
if($dispatch_num==''){
$po_reference=$row_customer['refered_by'];
$Dispatch_date="Not Dispatched";
}else{
$Dispatch_date=date("d-m-Y", strtotime($dispatch_date));
}

?>
<tr>
<td class="d-none"><?=$SNo; ?></td>
<td><?=$Dispatch_date;?></td>
<td>PO<?=$sales_id;?></td>
<td><?=$po_reference;?></td>
<td><?=wordwrap($company_name, 30, "<br/>\n");?></td>
<td><?=wordwrap($product_name, 30, "<br/>\n");?></td>
<td><?if($Status=='Approved' && $Motor_num ==''){echo $quantity-$total_dispatch."</td>";}else{echo $quantity."</td>";?>
<td><? $Motor_Num=str_replace("~",", ",$motor_num); echo wordwrap($Motor_Num, 24, "<br />\n"); ?></td>
<td><?=$document_num;?></td>
<td><?=$dispatch_num;?></td>
<td><?=$dispatch_through;?></td><?}?>
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
<h5 class="mb-0">PRICE LOG</h5>
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

<script type="text/javascript">
function getDate(val){
if(val!='Pending' && ($('#fromDate').val()=='') && ($('#endDate').val()=='') ){
$('#fromDate').val('<?=date("Y-m-d", strtotime("-1 Month", strtotime($currentDate)));?>')
$('#endDate').val('<?=$currentDate;?>');
}
}
function getlog(val){

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