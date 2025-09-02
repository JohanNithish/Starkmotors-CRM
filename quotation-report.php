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
	if($status!=''){
		$subquery .=" and status='$status'";
	}
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
 
$select_quotation=mysqli_query($conn,"select * from quotation where 1=1 $subquery order by created_datetime desc ");
$num_rows=mysqli_num_rows($select_quotation);

$select_tot=mysqli_query($conn,"select coalesce(sum(total_order_amount),0) as TotalAmount from quotation where 1=1 $subquery");
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
<li class="breadcrumb-item active" aria-current="page">List Quotation</li>
</ol>
</nav>
</div>
</div>

<hr>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<div class="d-flex gap-2">
<div class="mb-10">
<label for="inputAddress" class="form-label width-100" >Status</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio0" value="" <? if($status=='') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio0">All</label>

</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="Pending" <? if($status =='Pending' ) { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">Pending</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="Approved" <? if($status =='Approved') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio2">Approved</label>
</div>
</div>

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
<input type="date" class="result form-control" value="<?=$fromDate; ?>"  name="fromDate">

</div>
<div class="col-md-2 mb-20">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>"  name="endDate">

</div>

<div class="col-md-1 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">

</div>
</div> 
</form>

<?  
if($num_rows>>0){ 
?>
<div class="pb-3 d-flex gap-4"><h5>Total: <small class="text-danger ">₹ <? if($Total_Amount>>0){echo round($Total_Amount, 2);}?></small></h5> <h5>No of Quotation: <small class="text-danger "><?=$num_rows;?></small></h5></div>
<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<th class="d-none">SNo</th>
<th>Date</th>
<th>Customer Details</th>
<th>No. of Item</th>
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
<td><?if($company_name!='')echo "<b>".$company_name."&nbsp;</b><br>"; ?><?=$customer_name; ?>&nbsp;<br><?=$mobile; ?>&nbsp;<br><?=$customer_type; ?></td>
<td><?=$products_count;?> <?if($products_count>>'1')echo "Items"; else echo "Item"; ?></td>
<td>₹<?=$product_amount;?></td>
<td>₹<?if($gst_amount!='')echo $gst_amount; else echo "0"; ?></td>
<td>₹<?=$total_order_amount; ?></td>
<td><p class="mt-2 "><?if($status=="Pending"){ echo '<span class="sts-pnd rounded-2"> '.$status.'.. </span>';}else{echo "<span class=\"sts-appr rounded-2\">".$status."</span>"; } ?></p></td>
</tr>
<? } ?>
</tbody>
</table>
</div>
</div>
</div>
<? } else{ echo "No Records Found";  }?>

<?php
}
include 'template.php';
?>