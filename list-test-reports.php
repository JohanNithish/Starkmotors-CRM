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

if($fromDate !='' && $endDate !='')
{
$subquery =" and (date(test_date) BETWEEN '".$fromDate."' and '".$endDate."') order by test_date desc ";
}
else{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery =" and (date(test_date) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}

 $select_test=mysqli_query($conn,"select * from test_report where 1=1 $subquery ");
?>

<h6 class="mb-0 text-uppercase">List Test Report</h6>
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



<form action="list-test-reports.php" method="post">
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
if(mysqli_num_rows($select_test)>>0){ 
?>

<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Test<br/>Date</th>
<th>Company Name</th>
<th>Product Name</th>
<th>Checked By</th>
	<? if($_SESSION['USERTYPE']==0){ ?>
<th>Action</th>
<?}?>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_test=mysqli_fetch_array($select_test))
{ 
$SNo = $SNo + 1; 
$id=$row_test['id'];
$customer_id=$row_test['customer_id'];
$product=$row_test['product'];
$test_date=$row_test['test_date'];
$checked_by=$row_test['checked_by'];
$created_datetime=$row_test['created_datetime'];
$select_customer=mysqli_query($conn,"select * from order_confirmation where id='$customer_id'");
$row_customer=mysqli_fetch_array($select_customer);
$company_name=$row_customer['company_name'];
$customer_name=$row_customer['customer_name'];
$mobile=$row_customer['mobile'];
?>
<tr>
<td class="d-none"><?=$SNo; ?></td>
<td><?=date("d-m-Y", strtotime($test_date));?></td>
<td><?if($company_name!='')echo "<b>".$company_name."</b><br>"; ?><?=$customer_name; ?><br><?=$mobile; ?><br><?=$customer_type; ?></td>
<td><?=wordwrap($product, 20, "<br/>\n");?></td>
<td><?=$checked_by;?></td>

<td class="order-actions d-flex gap-2">
	<a href="export-reports.php?id=<?=$id; ?>" tooltip="View" target="_blank" class="btn btn-add btn-sm"><i class="lni lni-eye"></i></a>
	<? if($_SESSION['USERTYPE']==0){ ?>
	<a href="add-test-reports.php?id=<?=$id; ?>&act=edit" tooltip="Edit" class="btn btn-add btn-sm"><i class="bx bxs-edit"></i></a><? } ?>
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