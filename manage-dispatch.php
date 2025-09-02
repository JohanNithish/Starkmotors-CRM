<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

if($act=='delete' && $ID>0) 
{
$sales_DeleteValues = mysqli_query($conn,"delete from order_confirmation where id ='$ID' ");
$ordered_ProductDelete = mysqli_query($conn,"delete from ordered_products where sales_id ='$ID' ");
if($sales_DeleteValues && $ordered_ProductDelete)
{
$alert_msg = 'Dispatch Details Successfully';
header('Location:manage-dispatch.php?alert_msg='.$alert_msg);
}
else
{
$alert_msg = 'Could not able to delete try once again!!!';
header('Location:manage-dispatch.php?alert_msg='.$alert_msg);
}
}

?>


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Manage Dispatch</div>
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
<h6 class="mb-0 text-uppercase">List Dispatch</h6>
<hr/>
<?  $select_sales=mysqli_query($conn,"select * from order_confirmation order by id desc "); 
if(mysqli_num_rows($select_sales)>>0){ 
?>
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
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table id="example" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>PO Date</th>
<th>Customer<br>Details</th>
<th>No. of Item</th>

<th>Estimated<br>Delivery Date</th>
<th>Taxable</th>
<th>GST Amount</th>
<th>Net Amount</th>

<th>Action</th>
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
$mobile=$row_sales['mobile'];
$customer_type=$row_sales['customer_type'];
$products_count=$row_sales['products_count'];
$brand_name=$row_sales['brand_name'];
$product_amount=$row_sales['product_amount'];
$gst_amount=$row_sales['gst_amount'];
$enquiry_num=$row_sales['enquiry_num'];
$refered_by=$row_sales['refered_by'];
$estimated_delivery=$row_sales['estimated_delivery'];
$total_order_amount=$row_sales['total_order_amount'];
$invoice_date=$row_sales['invoice_date'];
$created_datetime=$row_sales['created_datetime'];
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td><?=date("d-m-Y", strtotime($invoice_date)); ?></td>
<td><?if($company_name!='')echo "<b>".$company_name."</b><br>"; ?><?=$customer_name; ?><br><?=$mobile; ?><br><?=$customer_type; ?></td>
<td><?=$products_count;?> <?if($products_count>>'1')echo "Items"; else echo "Item"; ?></td>

<td><?=date("d-m-Y", strtotime($estimated_delivery));?></td>
<td>₹<?=$product_amount;?></td>
<td>₹<?if($gst_amount!='')echo $gst_amount; else echo "0"; ?></td>
<td>₹<?=$total_order_amount; ?></td>

<td>
<div class="d-flex order-actions">
<a href="view-sales.php?id=<?=$id; ?>" tooltip="View" class="btn btn-add btn-sm"><i class="lni lni-eye"></i></a>
<a href="export-invoice.php?id=<?=$id; ?>" tooltip="Print" target="_blank" class="btn btn-add btn-sm ms-2"><i class="bx bxs-printer"></i></a>

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

<?php
}
include 'template.php';
?>