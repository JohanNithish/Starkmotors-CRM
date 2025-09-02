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

if($customer!='' && $fromDate !='' && $endDate !=''){

if($brand_name!=''){
$subquery =" and brand_name='$brand_name'";
}
$select_dispatch=mysqli_query($conn,"select op.*, oc.customer_id from ordered_products op INNER JOIN order_confirmation oc ON op.sales_id = oc.id where 1=1 and customer_id='$customer' $subquery  and (date(op.created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by op.created_datetime desc");
$QUERY=" from ordered_products op INNER JOIN order_confirmation oc ON op.sales_id = oc.id where 1=1 and customer_id='$customer' $subquery  and (date(op.created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') order by op.created_datetime desc";
}else{
if($fromDate !='' && $endDate !='')
{
if($brand_name!=''){
$subquery .=" and brand_name='$brand_name'";
}
$subquery .=" and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."')";
}

else{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery .=" and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."')";
}
$select_dispatch=mysqli_query($conn,"select * from ordered_products where 1=1 $subquery  order by created_datetime desc ");
$QUERY=" from ordered_products where 1=1 $subquery  order by created_datetime desc ";
}

?>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Reports</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="home.php"><i class="bx bx-home-alt color-af251c"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">List Brand-wise</li>
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
div class="text-white"><?=$alert_msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>




<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<div class="d-flex gap-2">
	<div class="col-xl-3" >
<label for="inputLastName" class="form-label mt-20">Select Company / Customer</label>
<select class="multiple-select" name="customer">
<option value="">All Customer</option>
<? 
$sql_customer=mysqli_query($conn,"select * from  customer ORDER BY customer_name asc"); 
while($row_customer=mysqli_fetch_array($sql_customer))
{
?>
<option value="<?=$row_customer['id']?>" <? if($row_customer['id'] == $customer) { ?>selected<? } ?> ><?if($row_customer['company_name']!='')echo $row_customer['company_name'].' / ';?><?=$row_customer['customer_name'];?></option>
<?
}
?>
</select>
</div>

<div class="col-md-3">
<label for="inputLastName" class="form-label mt-20">Select Brand</label>
<select class="form-select" name="brand_name" >
<option value="">All Brands</option>
<? 
$sql_brand=mysqli_query($conn,"select * from  brand ORDER BY brand_name asc"); 
while($row_brand=mysqli_fetch_array($sql_brand))
{
?>
<option value="<?=$row_brand['brand_name']?>" <? if($row_brand['brand_name'] == $brand_name) { ?>selected<? } ?> ><?=$row_brand['brand_name'];?></option>
<?
}
?>
</select>
</div>
<div class="col-md-2 mb-20">
<label class="form-label">From Date</label>
<input type="date" class="result form-control" value="<?=$fromDate; ?>" name="fromDate">

</div>
<div class="col-md-2 mb-20">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>" name="endDate">

</div>

<div class="col-md-3 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">

</div>
</div> 
</form>

<?  
if(mysqli_num_rows($select_dispatch)>>0){ 
$select_tot=mysqli_query($conn,"select coalesce(sum(total_amount),0) as TotalAmount ".$QUERY);
$rows_total=mysqli_fetch_array($select_tot);
$Total_Amount=$rows_total['TotalAmount'];
?>
<div class="pb-3 d-flex gap-4"><h5>Total: <small class="text-danger ">₹ <? if($Total_Amount>>0){echo round($Total_Amount, 2);}?></small></h5> <h5>Total Products: <small class="text-danger "><?=mysqli_num_rows($select_dispatch);?></small></h5></div>
<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>PO No</th>
<th>LR No</th>
<th>Company Name</th>
<th>Product Name</th>
<th>Brand Name</th>
<th>Qty</th>
<th>Total Amount</th>
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
$total_amount=$row_dispatch['total_amount'];
$po_reference=$row_dispatch['po_reference'];
$select_customer=mysqli_query($conn,"select * from order_confirmation where id='$sales_id'");
$row_customer=mysqli_fetch_array($select_customer);
$company_name=$row_customer['company_name'];
if($dispatch_num==''){
$po_reference=$row_customer['refered_by'];
}
?>
<tr>
<td class="d-none"><?=$SNo; ?></td>
<td>PO<?=$sales_id;?></td>
<td><?=$po_reference;?></td>
<td><?=wordwrap($company_name, 30, "<br/>\n");?></td>
<td><?=wordwrap($product_name, 30, "<br/>\n");?></td>
<td><?=$brand_name;?></td>
<td><?=$quantity;?></td>
<td>₹<?=$total_amount;?></td>

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