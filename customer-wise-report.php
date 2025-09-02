<?php
function main() {
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
$createdTime = date('H:i:s');
$ID = $_GET['id'];

if($Submit=='Add'){
$update_remark=mysqli_query($conn,"insert into customer_remarks set remarks = '$remarks',  customer_id = '$MainId', created_by=".$_SESSION['UID'].", created_date='$currentDate', created_time='$createdTime'  ");
if($update_remark)
{
$msg = 'Remarks Updated Successfully';
header('Location:customer-wise-report.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';    
}
}

if($Submit=='Set'){
$insert_projection=mysqli_query($conn,"insert into sales_projection set customer_id = '$customer_id',  projection_month = '$projection_month', projection_year = '$projection_year', amount='$amount', created_by=".$_SESSION['UID'].", created_datetime='$currentTime'  ");
if($insert_projection)
{
$msg = 'Sales Projection Updated Successfully';
header('Location:customer-wise-report.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';    
}
}

if($Submit=='Update'){
$update_projection=mysqli_query($conn,"update sales_projection set amount='$amount', created_by=".$_SESSION['UID'].", modified_datetime='$currentTime' where id='$MenuId'  ");
if($update_projection)
{
$msg = 'Sales Projection Updated Successfully';
header('Location:customer-wise-report.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';    
}
}

if($act=='delete' && $ID>0) 
{
$quotation_DeleteValues = mysqli_query($conn,"delete from customer_remarks where id ='$ID' ");
if($quotation_DeleteValues)
{
$alert_msg = 'Remarks Details Successfully';
header('Location:customer-wise-report.php?alert_msg='.$alert_msg);
}
}



if($status =='Date'){
$subquery = " and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."')";
}
if($status =='Month' || $status ==''){
	if($status ==''){
		$year=date('Y');
		$month=date('n');
	}
$subquery = ' and YEAR(created_datetime) = '.$year.' AND MONTH(created_datetime) = '.$month.' ';
$fromDate=date("Y-m-d", strtotime("-1 month", strtotime($currentDate)));
$endDate=$currentDate;
}

$select_report=mysqli_query($conn,"select * from customer where customer_type!='Retailer' order by company_name asc ");
$num_rows=mysqli_num_rows($select_report);
?>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Reports</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt color-0d6f00"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">List Customer-wise Reports</li>
</ol>
</nav>
</div>
</div>
<hr>

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
<div class="row">

<div class="col-md-2 mb-20">
<label for="inputAddress" class="form-label width-100" >Type</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" onchange="getType(this.value)" id="inlineRadio0" value="Month" <? if($status==''|| $status=='Month' ) { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio0">Month</label>

</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio1" onchange="getType(this.value)" value="Date" <? if($status =='Date' ) { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">Date</label>

</div>


</div>
<div class="col-md-4  mb-20" id="date" style="<?if($status =='Month'||$status =='' ) {?>display: none;<?}?>">
	<div class=" row ">
<div class="col-md-6">
<label class="form-label">From Date</label>
<input type="date" class="result form-control" value="<?=$fromDate; ?>" max="<?=date('Y-m-d'); ?>" name="fromDate">

</div>
<div class="col-md-6">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>" max="<?=date('Y-m-d'); ?>" name="endDate">
</div>
</div>
</div>

<div class="col-md-4  mb-20" id="month" style="<?if($status =='Date' ) {?>display: none;<?}?>">
	<div class=" row ">
<div class="col-md-6">
<label class="form-label">Select Month</label>
<select name="month" class="form-select">
	<? for($i=1; $i<=12; $i++)
  {
$Month=date("F", mktime(0, 0, 0, $i, 1)); ?>
	<option value="<?=$i;?>" <? if($i==$month){echo "selected";}elseif($month=='' && $i==date("n")){echo "selected";} ?> ><?=$Month;?></option>
	<?}?>
</select>

</div>
<div class="col-md-6">
<label class="form-label">Select Year</label>
<select name="year" class="form-select">
<option value="<?=date("Y", strtotime("-4 year", time()));?>" <?if(date("Y", strtotime("-4 year", time()))==$year){echo"selected";}?> ><?=date("Y", strtotime("-4 year", time()));?></option>
<option value="<?=date("Y", strtotime("-3 year", time()));?>" <?if(date("Y", strtotime("-3 year", time()))==$year){echo"selected";}?> ><?=date("Y", strtotime("-3 year", time()));?></option>
<option value="<?=date("Y", strtotime("-2 year", time()));?>" <?if(date("Y", strtotime("-2 year", time()))==$year){echo"selected";}?> ><?=date("Y", strtotime("-2 year", time()));?></option>
<option value="<?=date("Y", strtotime("-1 year", time()));?>" <?if(date("Y", strtotime("-1 year", time()))==$year){echo"selected";}?> ><?=date("Y", strtotime("-1 year", time()));?></option>
<option value="<?=date("Y");?>" <?if(date("Y")==$year || $year==''){echo"selected";}?> ><?=date("Y");?></option>
</select>

</div>
</div>
</div>

<div class="col-md-3 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">

</div>
</div> 
</form>

<?  
if($num_rows>>0){ 
?>
<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<th class="d-none">SNo</th>

<th>Customer Details</th>
<?if($status=='Month' || $status==''){?><th>Target Value</th><?}?>
<!-- <th>Sales Projection</th>
 --><th>Order Recieved</th>
<th>Achieved<br>Invoiced</th>
<?if($status=='Month' || $status=='' ){?><th>Pending</th><?}?>
<th>Dealer/OEM</th>
<th>Remarks</th>

</tr>
</thead>
<tbody>
<?   
$SNo = 0;
$current_prj_month=date('F', strtotime('-1 month'));
$current_prj_year=date('Y', strtotime('-1 month'));
$prj_month=date('F');
$prj_year=date('Y');
while($row_report=mysqli_fetch_array($select_report))
{ 
$SNo = $SNo + 1; 
$Customer_id=$row_report['id'];
$customer_type=$row_report['customer_type'];
$company_name=$row_report['company_name'];
$created_datetime=$row_report['created_datetime'];
$target_amount=$row_report['target_amount'];  
$remarks=$row_report['remarks'];
$Sel_Overall_report = mysqli_query($conn,"select (select coalesce(sum(total_order_amount),0) from quotation where customer_id='$Customer_id' $subquery) as QuotationAmount, (select coalesce(sum(total_order_amount),0) from order_confirmation where customer_id='$Customer_id' $subquery) as SalesAmount, (select count(remarks) from customer_remarks where customer_id='$Customer_id') as TotRemarks, (select amount from sales_projection where customer_id='$Customer_id' and projection_month='$prj_month' and projection_year='$prj_year') as PrjAmount, (select amount from sales_projection where customer_id='$Customer_id' and projection_month='$current_prj_month' and projection_year='$current_prj_year') as CurrentPrj ");
$row_Overall_report = mysqli_fetch_array($Sel_Overall_report);
$Quoation_Amount = $row_Overall_report['QuotationAmount'];
$Sales_Amount = $row_Overall_report['SalesAmount'];
$TotRemarks = $row_Overall_report['TotRemarks'];
$Projection_amount = $row_Overall_report['PrjAmount'];
$CurrentPrj = $row_Overall_report['CurrentPrj'];
if($CurrentPrj!=''){
$CurrPrj=$current_prj_month.": ₹".$CurrentPrj."<br>";
}else{
	$CurrPrj="";
}
if($Projection_amount!=''){
$PrjAmt="₹".$Projection_amount;
}else{
	$PrjAmt="";
}
$PendingAmount = $target_amount - $Sales_Amount; 
if($PendingAmount <= 0){
$PendingAmount=0;
}
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>

<td><?=$company_name; ?></td>
<?if($status=='Month' || $status=='' ){?><td>₹<?=$target_amount; ?></td><?}?>
<!-- <td><?if($CurrPrj!=''){ echo $CurrPrj;}  echo $prj_month.": ".$PrjAmt; if($Projection_amount==''){ ?><a href="javascript:;" class="text-dark ms-1 p-0 btn-none" tooltip="Add Projection" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$Customer_id ?>,'projection')"><i class="bx bxs-calendar-plus"></i></a><?}else{?><a href="javascript:;" class="text-dark ms-1 p-0 btn-none" tooltip="Edit Projection" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$Customer_id ?>,'projection')"><i class="bx bxs-calendar-edit"></i></a><?}?></td>
 --><td>₹<?=$Quoation_Amount; ?></td>
<td>₹<?=$Sales_Amount; ?></td>
<?if($status=='Month' || $status=='' ){?><td>₹<?=$PendingAmount; ?></td><?}?>
<td><?=$customer_type; ?></td>
<td class="order-actions d-flex">
	<button type="button" class="btn tbl-btn" tooltip="Remarks" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$Customer_id ?>,'remarks')"><i class="bx bx-comment-add"></i></button>
<? if($TotRemarks>>0){?>
		<button type="button" class="btn tbl-btn ms-2" tooltip="View Remarks" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$Customer_id ?>,'view_remarks')"><i class="lni lni-eye"></i></button>
<? } ?>
</td>
</tr>
<? } ?>
</tbody>
</table>
</div>
</div>
</div>
<? } else{ echo "No Records Found";  }?>

<div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
<div id="ModelWindow" class="modal-dialog modal-xl">
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
$('#date').hide();
function getType(val){
if(val=="Month"){
$('#date').hide();
$('#month').show();
}
else{
$('#month').hide();
$('#date').show();
}
}
function getedit(val,type){
if(type=='remarks'){
	$('#ModelWindow').removeClass('modal-xl');
	$('#ModelWindow').addClass('modal-lg');
}else if(type=='projection'){
	$('#ModelWindow').removeClass('modal-lg modal-xl');
}else{
	$('#ModelWindow').addClass('modal-xl');
	$('#ModelWindow').removeClass('modal-lg');
}
$.ajax({
url: "ajax-modal.php", 
type: "POST",
data: "id="+val+"&act="+type,
success: function(result){
$("#output").html(result);
}});
}

</script>

<?php
}
include 'template.php';
?>