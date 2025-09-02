<?php
function main() {
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
if($fromDate !='' && $endDate !='')
{
	if($customer!=''){
		$subquery .=" and customer_id='$customer'";
	}
$subquery .=" and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."')";
}
if($subquery ==''){
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery = " and (date(created_datetime) BETWEEN '".$fromDate."' and '".$endDate."') ";
}
$select_sales=mysqli_query($conn,"select * from order_confirmation where 1=1 $subquery order by id desc ");
$num_rows=mysqli_num_rows($select_sales);
 
$select_tot=mysqli_query($conn,"select coalesce(sum(total_order_amount),0) as TotalAmount from order_confirmation where 1=1 $subquery");
$rows_total=mysqli_fetch_array($select_tot);
$Total_Amount=$rows_total['TotalAmount'];
?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Reports</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt color-0d6f00"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">List Sales</li>
</ol>
</nav>
</div>
</div>


<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<div class="row">

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

<div class="col-md-2 mb-20">
<label class="form-label">From Date</label>
<input type="date" class="result form-control" value="<?=$fromDate; ?>" max="<?=date('Y-m-d'); ?>" name="fromDate">

</div>
<div class="col-md-2 mb-20">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>" max="<?=date('Y-m-d'); ?>" name="endDate">

</div>
<div class="col-md-1 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">

</div>
</div> 
</form>

<?  
if($num_rows>>0){ 
?>
<div class="pb-3 d-flex gap-4"><h5>Total: <small class="text-danger ">₹ <? if($Total_Amount>>0){echo round($Total_Amount, 2);}?></small></h5> <h5>No of Sales: <small class="text-danger "><?=$num_rows;?></small></h5></div>
<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<th class="d-none">SNo</th>
<th>Dispatch Date</th>
<th>PO Date</th>
<th>Converted<br>Time Period</th>
<th>Customer Details</th>
<th>No. of Item</th>
<th>Taxable</th>
<th>GST Amount</th>
<th>Net Amount</th>
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
$products_count=$row_sales['products_count'];
$brand_name=$row_sales['brand_name'];
$product_amount=$row_sales['product_amount'];
$gst_amount=$row_sales['gst_amount'];
$invoice_date=$row_sales['invoice_date'];
$dispatch_date=$row_sales['dispatch_date'];
$total_order_amount=$row_sales['total_order_amount'];
$created_datetime=$row_sales['created_datetime'];
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
?>
<tr>
<td class="d-none"><?=$SNo; ?></td>
<td><? if($dispatch_date!=NULL){echo date("d-m-Y", strtotime($dispatch_date));}else{echo "Not Dispatched";}?></td>
<td><?=date("d-m-Y", strtotime($invoice_date));?></td>
<td><b><?=$Sales_conv; ?></b><br>
<?=date("d-m-Y", strtotime($quotation_createdDate))." to<br>".date("d-m-Y", strtotime($created_datetime)); ?></td>
<td><?if($company_name!='')echo "<b>".$company_name."&nbsp;</b><br>"; ?><?=$customer_name; ?>&nbsp;<br><?=$mobile; ?>&nbsp;<br><?=$customer_type; ?></td>
<td><?=$products_count;?> <?if($products_count>>'1')echo "Items"; else echo "Item"; ?></td>
<td>₹<?=$product_amount;?></td>
<td>₹<?if($gst_amount!='')echo $gst_amount; else echo "0"; ?></td>
<td>₹<?=$total_order_amount; ?></td>

</tr>
<? } ?>
</tbody>
</table>
</div>
</div>
</div>
<? } else{ echo "No Records Found";  } ?>


<?php
}
include 'template.php';
?>